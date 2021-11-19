<?php

namespace App\Http;


use GuzzleHttp\Client;


class FarazSMS
{
    private $url;
    private $key;
    private $from;

    /**
     * @param $url
     * @param $username
     * @param $password
     */
    public function __construct($url, $key, $from)
    {
        $this->url = $url;
        $this->key = $key;
        $this->from = $from;
    }

    public function sendPattern($patternCode, $recipient, $values)
    {
        $client = new Client();

        $params = [
            "pattern_code" => $patternCode,
            "originator" => $this->from,
            "recipient" => '+' . $recipient,
            "values" => $values,
        ];

        $response = $client->request('POST', $this->url . '/v1/messages/patterns/send', [
            'headers' => [
                'Authorization' => 'AccessKey ' . $this->key,
            ],
            'json' => $params,
        ]);

        return $response->getBody();
    }

}
