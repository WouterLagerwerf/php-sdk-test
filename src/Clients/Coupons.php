<?php

namespace WalletApp\Support\Clients;

class Coupons extends Core
{
    public function get()
    {
        $response = $this->httpClient->get('coupons');
        return $response->getBody()->getContents();
    }
}