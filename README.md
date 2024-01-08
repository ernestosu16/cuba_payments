# Cuba Payments

Es una librería en PHP para facilitar las método de transacciones con las pasarelas más usada tanto en ENZONA como
Transfermovil

# *Actualmente está en desarrollo*

## Ejemplo del código
La idea que tengo es que sea fácil de usar y manejar. No he podido hacerle pruebas porque el api de ENZONA de prueba que es https://apisandbox.enzona.net no funciona.

```php
<?php
use Lnx\CubaPayment\Config\EnzonaConfig;
use Lnx\CubaPayment\PaymentManager;
use Lnx\CubaPayment\Tests\Request\Enzona\ConfirmPayment;
use Lnx\CubaPayment\Tests\Request\Enzona\GeneratePayment;


$enzonaConfig = new EnzonaConfig('https://api.enzona.net', 'ASSA#', 'SDASD');

$manager = new PaymentManager($enzonaConfig);

# https://api.enzona.net/store/apis/info?name=PaymentAPI&version=v1.0.0&provider=admin#tab1

# Permite crear un pago
$generatePayment = new GeneratePayment();
$generatePayment->setCurrency('CUP');
...

$data = $manager->execute($generatePayment);

# Permite confirmar un pago
$confirmPayment = new ConfirmPayment();
$confirmPayment->setTransactionUuid('f89c79c8dfbd43939cdc43cf47b1ee47');
...

$data = $manager->execute($confirmPayment);
```