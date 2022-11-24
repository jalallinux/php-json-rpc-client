<?php

namespace JalalLinuX\JsonRpcClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Rpc client handler
 *
 * @author JalalLinuX
 */
class RpcClient
{
    private Client $httpClient;

    private array $options = [
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ],
    ];

    private string $jsonRpcVersion;

    /**
     * Class constructor
     *
     * @param  string|null  $uri full rpc url
     * @param  array  $options
     * @param  string|null  $jsonRpcVersion
     *
     * @author JalalLinuX
     */
    public function __construct(string $uri, array $options = [], string $jsonRpcVersion = '2.0')
    {
        $this->options = array_merge_recursive($this->options, $options);
        $this->jsonRpcVersion = $jsonRpcVersion;
        $this->httpClient = new Client([
            'base_uri' => $uri,
            'http_errors' => false,
        ]);
    }

    /**
     * Set header on RPC request
     *
     * @param  array  $headers
     * @return self
     *
     * @author JalalLinuX
     */
    public function withHeaders(array $headers = []): self
    {
        $this->options['headers'] = array_merge($this->options['headers'], $headers);

        return $this;
    }

    /**
     * Set basic auth on RPC request
     *
     * @param  string  $username
     * @param  string  $password
     * @return self
     *
     * @author JalalLinuX
     */
    public function withBasicAuth(string $username, string $password): self
    {
        $this->options['auth'] = [$username, $password];

        return $this;
    }

    /**
     * Set jwy auth on RPC request
     *
     * @param  string  $token
     * @return self
     *
     * @author JalalLinuX
     */
    public function withJwtAuth(string $token): self
    {
        return $this->withHeaders(['Authorization' => $token]);
    }

    /**
     * Add RPC request
     *
     * @param  string  $method
     * @param  array  $params
     * @param  string|null  $id
     * @return self
     *
     * @author JalalLinuX
     */
    public function request(string $method, array $params, string $id = null): self
    {
        $this->options['json'][] = [
            'id' => $id ?? uniqid(),
            'jsonrpc' => $this->jsonRpcVersion,
            'method' => $method,
            'params' => $params,
        ];

        return $this;
    }

    /**
     * Add RPC notification request
     * https://www.jsonrpc.org/specification#notification
     *
     * @param  string  $method
     * @param  array  $params
     * @return self
     *
     * @author JalalLinuX
     */
    public function notify(string $method, array $params): self
    {
        $this->options['json'][] = [
            'id' => null,
            'jsonrpc' => $this->jsonRpcVersion,
            'method' => $method,
            'params' => $params,
        ];

        return $this;
    }

    /**
     * Send RPC requests
     *
     * @return RpcResponse
     *
     * @throws GuzzleException
     *
     * @author JalalLinuX
     */
    public function send(): RpcResponse
    {
        return new RpcResponse($this->httpClient->post('', $this->options));
    }
}
