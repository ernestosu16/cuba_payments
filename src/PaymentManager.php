<?php

namespace Lnx\CubaPayment;

use Lnx\CubaPayment\Attribute\Request;
use Lnx\CubaPayment\Attribute\RequestValue;
use Lnx\CubaPayment\Config\ConfigInterfaces;
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\Manager\EnzonaManager;
use Lnx\CubaPayment\Manager\ManagerInterface;
use Lnx\CubaPayment\Request\RequestInterface;
use PHPUnit\Logging\Exception;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

final class PaymentManager
{
    private ManagerInterface|null $manager = null;
    private string|null $tokenManagerClass = null;

    public function __construct(
        private readonly ConfigInterfaces $connection
    )
    {
    }

    public function getTokenManager(): Guzzle\Manager\TokenManagerInterface
    {
        return $this->getManager()->getClientBuilder()->getTokenManager();
    }

    public function withTokenManager(string $tokenManagerClass): PaymentManager
    {
        $this->tokenManagerClass = $tokenManagerClass;
        return $this;
    }

    private function getManager(): ManagerInterface
    {
        if (!$this->manager) {
            $this->manager = match (true) {
                $this->connection instanceof EnzonaConfig => new EnzonaManager($this->connection, $this->tokenManagerClass),
                default => throw new Exception(sprintf(
                    'El método de connexion "%s::class" no está configurado para ser usado',
                    $this->connection::class
                )),
            };
        }

        return $this->manager;
    }

    public function execute(RequestInterface $payment): array
    {
        $manager = $this->getManager();
        $connection = $this->connection;
        $reflection = new ReflectionClass($payment);
        $attributes = $reflection->getAttributes();
        $uri = null;
        $method = null;
        $required = [];

        # Class attribute
        foreach ($attributes as $attribute) {
            if (!$attribute->getName() == Request::class) {
                continue;
            }

            $arguments = $attribute->getArguments();
            if ($arguments['connection'] != $connection::class) {
                throw new RuntimeException(sprintf('connection: %s, request: %s', $connection::class, $arguments['connection']));
            }

            $uri = $arguments['uri'];
            $method = $arguments['method'];
            if (preg_match('/{\w+}/m', $uri, $matches)) {
                $required = $matches;
            }
        }

        $properties = $reflection->getProperties();
        if (count($properties) == 0 && count($required) > 0) {
            throw new RuntimeException(sprintf(
                'Es requerido pasar el valor para %s, use el atributo "RequestValue" en la propiedad "%s"',
                $required[0], $payment::class
            ));
        }

        # Property attribute
        foreach ($properties as $property) {
            $property = new ReflectionProperty($payment::class, $property->getName());
            $attributes = $property->getAttributes();
            foreach ($attributes as $attribute) {
                if (!$attribute->getName() == RequestValue::class) {
                    continue;
                }
                $arguments = $attribute->getArguments();
                $name = $arguments['name'];
                $value = $payment->{$name};

                if (!$value) {
                    throw new RuntimeException(sprintf('La propiedad "%s::%s" no puede ser "" o NULL', $payment::class, $name));
                }

                $uri = str_replace("{{$name}}", $value, $uri);
            }
        }

        return $manager->execute($payment, $method, $uri);
    }
}