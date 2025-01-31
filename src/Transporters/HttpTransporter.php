<?php

declare(strict_types=1);

namespace OpenAI\Transporters;

use JsonException;
use OpenAI\Contracts\Transporter;
use OpenAI\Exceptions\ErrorException;
use OpenAI\Exceptions\TransporterException;
use OpenAI\Exceptions\UnserializableResponse;
use OpenAI\ValueObjects\Transporter\BaseUri;
use OpenAI\ValueObjects\Transporter\Headers;
use OpenAI\ValueObjects\Transporter\Payload;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;

/**
 * @internal
 */
final class HttpTransporter implements Transporter {
    private ClientInterface $client;
    private BaseUri $baseUri;
    private Headers $headers;

    /**
     * Creates a new Http Transporter instance.
     */
    public function __construct(
        ClientInterface $client,
        BaseUri $baseUri,
        Headers $headers
    ) {
        $this->client = $client;
        $this->baseUri = $baseUri;
        $this->headers = $headers;
    }

    /**
     * {@inheritDoc}
     */
    public function requestObject(Payload $payload) {
        $request = $payload->toRequest($this->baseUri, $this->headers);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        $contents = (string) $response->getBody();

        $contentTypeHeaders = $response->getHeader('Content-Type');
        if (isset($contentTypeHeaders[0]) && $contentTypeHeaders[0] == 'text/plain; charset=utf-8') {
            return $contents;
        }

        try {
            /** @var array{error?: array{message: string, type: string, code: string}} $response */
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }

        if (isset($response['error'])) {
            throw new ErrorException($response['error']);
        }

        return $response;
    }

    /**
     * {@inheritDoc}
     */
    public function requestContent(Payload $payload): string {
        $request = $payload->toRequest($this->baseUri, $this->headers);

        try {
            $response = $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            throw new TransporterException($clientException);
        }

        $contents = $response->getBody()->getContents();

        try {
            /** @var array{error?: array{message: string, type: string, code: string}} $response */
            $response = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException $e) {
            // ..
        }

        return $contents;
    }
}
