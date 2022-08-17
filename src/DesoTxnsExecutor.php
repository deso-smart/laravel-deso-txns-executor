<?php

namespace DesoSmart\DesoTxnsExecutor;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class DesoTxnsExecutor
{
    public function __construct(
        private readonly string $baseUri,
        private readonly string $vendorKey,
    ) {
    }

    private function createHttpClient(): PendingRequest
    {
        return Http::asJson()->baseUrl($this->baseUri);
    }

    /**
     * @throws DesoTxnsExecutorException
     */
    private function handlerThrow(Response $response, RequestException $e): void
    {
        $payload = $response->json();

        if (! empty($payload['Message'])) {
            throw new DesoTxnsExecutorException($payload['Message'], $e->getCode(), $e);
        }

        throw new DesoTxnsExecutorException($e->getMessage(), $e->getCode(), $e);
    }

    public function getDerivedKey(string $internalKey): Collection
    {
        return $this->createHttpClient()
            ->get(sprintf('/v0/vendors/%s/%s/derived-key', $this->vendorKey, $internalKey))
            ->throw(fn ($res, $e) => $this->handlerThrow($res, $e))
            ->collect('Data');
    }

    public function addDerivedKey(string $internalKey, array $derivedKey): Collection
    {
        return $this->createHttpClient()
            ->post(sprintf('/v0/vendors/%s/%s/derived-key', $this->vendorKey, $internalKey), $derivedKey)
            ->throw(fn ($res, $e) => $this->handlerThrow($res, $e))
            ->collect('Data');
    }

    public function deleteDerivedKey(string $internalKey): void
    {
        $this->createHttpClient()
            ->delete(sprintf('/v0/vendors/%s/%s/derived-key', $this->vendorKey, $internalKey))
            ->throw(fn ($res, $e) => $this->handlerThrow($res, $e));
    }

    public function signTransaction(string $internalKey, string $transactionHex): Collection
    {
        return $this->createHttpClient()
            ->post(sprintf('/v0/vendors/%s/%s/transactions/sign', $this->vendorKey, $internalKey), [
                'TransactionHex' => $transactionHex,
            ])
            ->throw(fn ($res, $e) => $this->handlerThrow($res, $e))
            ->collect('Data');
    }

    public function getTransaction(string $id): Collection
    {
        return $this->createHttpClient()
            ->get(sprintf('/v0/transactions/%s', $id))
            ->throw(fn ($res, $e) => $this->handlerThrow($res, $e))
            ->collect('Data');
    }
}
