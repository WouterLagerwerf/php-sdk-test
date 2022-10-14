<?php

namespace WalletApp\Support\Clients;

use WalletApp\Support\Clients\Core;

class Authentication extends Core
{
    public $ABILITIES = [
        'brands' => [
            "brand.get",
            "brand.import",
        ],
        'members' => [
            "members.get",
            "brand.import",
        ],
        'passes' => [
            "passes.get",
            "passes.remove",
            "passes.update",
            "passes.store",
            "search.pass",
            "scan.url",
        ],
        'products' => [
            "product.get",
            "product.store",
            "scan.url",
        ],
        'coupons' => [
            "product.get",
            "product.store",
            "scan.url",
        ],
        'storecards' => [
            "product.get",
            "product.store",
            "scan.url",
        ],
        'tags' => [
            "tags.get",
            "tags.store",
        ],
        'devices' => [
            "device.get",
            "device.store",
        ],
        'locations' => [
            "location.get",
            "location.store",
        ],

        'full_access' => [
            "device.get",
            "device.store",
            "location.get",
            "passes.get",
            "passes.remove",
            "passes.update",
            "passes.store",
            "location.store",
            "search.pass",
            "product.get",
            "product.store",
            "brand.get",
            "brand.import",
            "scan.url",
            "tags.get",
            "tags.store",
            "members.get"
        ]
    ];

    public function login(array $data)
    {
        $data = $this->validate('AUTH_VALIDATORS', 'login', $data);
        $response = $this->httpClient->post('https://stagingbackend.walnutloyalty.com/api/login', $data);

        return $response;
    }

    public function token(array $data)
    {
        $data = $this->validate('AUTH_VALIDATORS', 'token', $data);
        if (gettype($data['permissions']) !== 'string') {
            throw new \Exception('permissions must be a string');
        }

        $data['permissions'] = $this->getPermissions($data['permissions']);

        $response = $this->httpClient->post('https://stagingbackend.walnutloyalty.com/oauth/token', $data);

        // if the response data key is set then return the ['body']['data']
        if (isset($response['body']['data'])) {
            return $response['body']['data']['key'];
        }
        return $response;
    }

    public function scopes()
    {
        return array_keys($this->ABILITIES);
    }

    private function getPermissions($string)
    {
        try {
            return $this->ABILITIES[$string];
         } catch (\Exception $e) {
            throw new \Exception('invalid permissions provided, use the scopes method to get a list of valid permissions');
         }
    }

}
