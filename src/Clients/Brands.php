<?php

namespace WalletApp\Support\Clients;

use Clients\Core;

class Brands extends Core
{
    // get the available brands
    public function get()
    {
        $response = $this->httpClient->get('https://stagingbackend.walnutloyalty.com/brands');
        
        // if the response data key is set then return the ['body']['data']
        if (isset($response['body']['data'])) {
            return $response['body']['data'];
        }
        
        // else throw an exception
        throw new \Exception('No data found');    
    }
}