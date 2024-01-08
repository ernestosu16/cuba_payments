<?php

$data = [
    'access_token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJtZXJjdXJlIjp7InN1YnNjcmliZSI6W10sInB1Ymxpc2giOlsiKiJdfX0.ZDg-F81ohe_cGhdE_IBXbXhHlRvU_MWHwizmdiWwzFA',
    'expires_in' => 350
];

header("Content-Type: application/json");
echo json_encode($data);
exit();