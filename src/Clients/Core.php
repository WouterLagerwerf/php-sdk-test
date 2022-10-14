<?php

namespace WalletApp\Support\Clients;

use Walletapp\Support\Clients\HttpClient;

class Core
{
    public function docs()
    {
        echo file_get_contents(str_replace('Clients', '',__DIR__) . '/views/authentication_helper.html');
    }

    private $AUTH_VALIDATORS = [
        'login' => [
            'email' => 'required',
            'password' => 'required'
        ],

        'token' => [
            'email' => 'required',
            'password' => 'required',
            'permissions' => 'required'
        ],
    ];

    private $MEMBER_VALIDATORS = [
        'export' => [
            'storecard_id' => 'required',
        ],
        'search' => [
            'email' => 'required',
        ],
    ];

    public HttpClient $httpClient;

    public function __construct(string $api_key = null)
    {
        $this->httpClient = new HttpClient($api_key);
    }

    protected function validate($validator, $method, $data)
    {
        $validator = $this->{$validator};
        $validator = $validator[$method];

        foreach ($validator as $key => $value) {
            if ($value == 'required' && !isset($data[$key])) {
                throw new \Exception($key . ' is required');
            }
        }

        return $data;
    }
}
