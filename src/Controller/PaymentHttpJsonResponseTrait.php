<?php

namespace App\Controller;

use CPay\Sdk\Exception\TransactionException;
use CPay\Sdk\TransactionResponse;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait PaymentHttpJsonResponseTrait
{

    private function onFailedPaymentHttpJsonResponse(string $message, int $code): JsonResponse
    {
        return $this->json([
            'payment_status' => $code,
            'message' => $message,
        ], Response::HTTP_BAD_REQUEST);
    }


    private function onSuccessPaymentHttpJsonResponse(TransactionResponse $transactionResponse): JsonResponse
    {
        return $this->json([
            'payment_status' => $transactionResponse->getStatus(),
            'message' => $transactionResponse->getMessage(),
            'payment_transaction_id' => $transactionResponse->getTransactionId()
        ], Response::HTTP_OK);
    }

    public function invalidDataHttpJsonResponse(array $violations): JsonResponse
    {
        return $this->json([
            'payment_status' => Response::HTTP_BAD_REQUEST,
            'message' => "Les champs suivants ne peuvent être vide ou null",
            'violations' => $violations
        ], Response::HTTP_BAD_REQUEST);
    }
}