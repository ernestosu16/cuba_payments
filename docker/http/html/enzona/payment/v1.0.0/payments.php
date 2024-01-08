<?php

use JetBrains\PhpStorm\NoReturn;

class Payments
{
    private function checkToken(): bool
    {
        $headers = apache_request_headers();
        $token = $headers['Authorization'];
        return (bool)$token;
    }

    private function generatePayment(array $request): array
    {
        if (!$this->checkToken()) {
            header("HTTP/1.1 401 Unauthorized");
            return [ "fault" => [ "code" => 900902, "type" => "Status report", "message" => "Runtime Error", "description" => "Missing Credentials" ]];
        }

        return [
            "amount" => [
                "total" => 0.01,
                "details" => [
                    "shipping" => 0.01,
                    "discount" => 0.01,
                    "tax" => 0.01,
                    "tip" => 0.01
                ]
            ],
            "status_code" => 1113,
            "created_at" => "2024-01-07T20:44:20.194Z",
            "description" => "Payment description",
            "transaction_uuid" => $json['transaction_uuid'] ?? '',
            "merchant_op_id" => 1135,
            "update_at" => "2024-01-07T20:44:20.194Z",
            "status_denom" => "Pendiente",
            "currency" => "CUP",
            "links" => [
                [
                    "method" => "REDIRECT",
                    "rel" => "confirm",
                    "href" => "https://enzona.xetid.cu/checkout/1940841ec89d4f32aef06c813825920b/login"
                ]
            ],
            "invoice_number" => 0.01,
            "items" => [
                [
                    "quantity" => 1,
                    "price" => 20,
                    "name" => "Arroz a la Cubana",
                    "description" => "Pan",
                    "tax" => 0.01
                ]
            ],
            "terminal_id" => 0.01
        ];
    }

    #[NoReturn]
    public static function run(): void
    {
        $request = json_decode(file_get_contents('php://input'), true);

        $class = new self();
        $data = $class->generatePayment($request);

        header("Content-Type: application/json");
        echo json_encode($data);
        exit();
    }
}

;

Payments::run();
