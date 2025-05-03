<?php

namespace BatAPI\Http;

use BatAPI\Utils\JSON;

class HttpRequest
{

    private ?string $url = null;
    private array $headers = [];
    private array $body = [];


    public static function to(string $url): HttpRequest
    {
        return new HttpRequest($url);
    }

    public function url(string $url): HttpRequest
    {
        $this->url = $url;
        return $this;
    }

    public function headers(array $headers): HttpRequest
    {
        foreach($headers as $header => $value) {
            $this->headers[] = "{$header}: {$value}";
        }

        return $this;
    }

    public function data(array $body): HttpRequest
    {
        $this->body = $body;
        return $this;
    }

    public function body(array $body): HttpRequest
    {
        return $this->data($body);
    }

    public function get(): HttpResponse
    {
        return $this->send("GET");
    }

    public function post(): HttpResponse
    {
        return $this->send("POST");
    }

    public function patch(): HttpResponse
    {
        return $this->send("PATCH");
    }

    public function put(): HttpResponse
    {
        return $this->send("PUT");
    }

    public function delete(): HttpResponse
    {
        return $this->send("DELETE");
    }

    

    public function __construct(?string $url = null)
    {
        $this->url = $url;
    }


    private function send(string $method): HttpResponse
    {
        $curl = curl_init();

        if (!empty($this->body)) {
            $this->headers[] = 'Content-Type: application/json';
            $this->headers[] = 'Accept: application/json';

            curl_setopt_array($curl, [
                CURLOPT_POSTFIELDS => JSON::encode($this->body),
            ]);
        }

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $this->headers,
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return new HttpResponse($response, $statusCode, $err);
    }
}