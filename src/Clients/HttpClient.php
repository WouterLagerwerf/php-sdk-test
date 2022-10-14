<?php

namespace WalletApp\Support\Clients;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class HttpClient
{
    private GuzzleClient $httpClient;

    // construct a new HTTP client
    public function __construct($api_key = null, GuzzleClient $client = null)
    {
        if (isset($_ENV['WALLETAPP_API_KEY'])) {
            $api_key = $_ENV['WALLETAPP_API_KEY'];
        }

        $this->httpClient = $client ?? new GuzzleClient([    
        'headers' => [
            'Content-Type' => 'Application/json',
            'Accept' => 'Application/json',
            'Authorization' => 'Bearer ' . $api_key
        ]]);
    }

    // basic get function
    public function get(string $url)
    {
        try { 
            $response = $this->httpClient->get($url);
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();           
        }
        $response_data = json_decode($response->getBody()->getContents(), true);
        $status_code = $response->getStatusCode();
        return ['body' => $response_data, 'status_code' => $status_code];
    }

    // basic get function
    public function post(string $url, array $data)
    {
        try { 
            $response = $this->httpClient->post($url, ['json' => $data]);
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();           
        }
        $response_data = json_decode($response->getBody()->getContents(), true);
        $status_code = $response->getStatusCode();
        return ['body' => $response_data, 'status_code' => $status_code];
    }

    // basic put function
    public function put(string $url, array $data)
    {
        try { 
            $response = $this->httpClient->put($url, ['json' => $data]);
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();           
        }
        $response_data = json_decode($response->getBody()->getContents(), true);
        $status_code = $response->getStatusCode();
        return ['body' => $response_data, 'status_code' => $status_code];
    }

    // basic delete function
    public function delete(string $url)
    {
        try { 
            $response = $this->httpClient->delete($url, ['json' => $data]);
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();           
        }
        $response_data = json_decode($response->getBody()->getContents(), true);
        $status_code = $response->getStatusCode();
        return ['body' => $response_data, 'status_code' => $status_code];
    }

    // basic patch function
    public function patch(string $url, array $data)
    {
        try { 
            $response = $this->httpClient->patch($url, ['json' => $data]);
        } catch (ClientException|ServerException $e) {
            $response = $e->getResponse();           
        }
        $response_data = json_decode($response->getBody()->getContents(), true);
        $status_code = $response->getStatusCode();
        return ['body' => $response_data, 'status_code' => $status_code];
    }
}