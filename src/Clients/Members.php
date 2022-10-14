<?php

namespace WalletApp\Support\Clients;

use Clients\Core;

class Members extends Core
{
    public string $brand_id;

    public function brand($id)
    {
        $this->brand_id = $id;
        return $this;
    }

    public function search($email)
    {
        // validate the data
        $this->validate('MEMBER_VALIDATORS', 'search', ['email' => $email]);
        $response = $this->httpClient->get('https://stagingbackend.walnutloyalty.com/members?email='. $email. '&brand_id='. $this->brand_id);

        // if the response body key is set then return the ['body']
        if (isset($response['body'])) {
            return $response['body'];
        }

        // else throw an exception
        throw new \Exception('No data found');
    }

    // needs to be validated
    public function logs()
    {
        $response = $this->httpClient->get('https://stagingbackend.walnutloyalty.com/import/users?brand_id='. $this->brand_id);

        // if the response data key is set then return the ['body']['data']
        if (isset($response['body'])) {
            return $response['body'];
        }

        // else throw an exception
        throw new \Exception('No data found');
    }

    public function export(string $storecard_id)
    {
        // validate the data
        $this->validate('MEMBER_VALIDATORS', 'export', [
            'storecard_id' => $storecard_id,
        ]);

        $response = $this->httpClient->post('https://stagingbackend.walnutloyalty.com/import/export', [
            'brand_id' => $this->brand_id,
            'storecard_id' => $storecard_id,
        ]);

        // if the response body key is set then return the ['body']
        if (isset($response['body'])) {
            return $response['body'];
        }

        return [];
    }

    public function import(array $data)
    {
        $validated_emails = true;
        $validated_name = true;
        $validated_points = true;

        foreach ($data as $key => $value) {
            if (!isset($value['email'])) {
                $validated_emails = false;
            } else {
                strtolower($value['email']);
            }

            if (!isset($value['name'])) {
                $validated_name = false;
            }

            if (! isset($value['points'])) {
                $data[$key]['points'] = 0;
            }
            
            if (isset($this->brand_id)) {
                $data[$key]['brand_id'] = $this->brand_id;
            }
        }
         
        // if the emails are not validated then throw an exception
        if (!$validated_emails) {
            throw new \Exception('Email is required');
        }

        // if the name is not set then throw an exception
        if (!$validated_name) {
            throw new \Exception('Name is required');
        }

        // if the brand_id is not set then throw an exception
        if (!isset($this->brand_id)) {
            throw new \Exception('Brand ID is required');
        }


        $response = $this->httpClient->post('https://stagingbackend.walnutloyalty.com/v2/import', ['users' => $data]);
        // if isset respons body
        if (isset($response['body'])) {
            return $response['body'];
        }
        // throw an exception
        throw new \Exception('No data found');
    }
}
