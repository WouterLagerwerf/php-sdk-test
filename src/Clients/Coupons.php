<?php

namespace WalletApp\Support\Clients;

use Walletapp\Support\Clients\Core;

class Coupons extends Core
{
    public function get()
    {
        $response = $this->httpClient->get('coupons');
        return $response->getBody()->getContents();
    }
}