<?php

namespace Mia\PushBullet;

use GuzzleHttp\Psr7\Request;

class PushBulletHelper
{
    /**
     * URL de la API
     */
    const BASE_URL = 'https://api.pushbullet.com/v2/';
    /**
     * 
     * @var string
     */
    protected $clientId = '';
    /**
     * 
     * @var string
     */
    protected $clientSecret = '';
    /**
     * 
     * @var string
     */
    protected $clientIden = '';
    /**
     * 
     * @var string
     */
    protected $accessToken = '';
    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;
    /**
     * 
     * @param string $access_token
     */
    public function __construct($client_id, $client_secret, $client_iden)
    {
        $this->clientId = $client_id;
        $this->clientSecret = $client_secret;
        $this->clientIden = $client_iden;
        $this->guzzle = new \GuzzleHttp\Client();
    }
    /**
     * Envia una notificacion Push al cliente
     */
    public function sendPushNote($senderIden, $title, $body)
    {
        return $this->generateRequest('POST', 'pushes', [
            'type' => 'note',
            'title' => $title,
            'body' => $body,
            'sender_iden' => $senderIden
        ]);
    }
    /**
     * Obtiene los datos de la cuenta logueada
     * @return Object
     */
    public function getCurrentUser()
    {
        return $this->generateRequest('GET', 'users/me');
    }
    /**
     * Funcion ara generar request
     */
    protected function generateRequest($method, $path, $params = null)
    {
        $body = null;
        if($params != null){
            $body = json_encode($params);
        }

        $request = new Request(
            $method, 
            self::BASE_URL . $path, 
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Access-Token' => $this->accessToken
            ], $body);

        $response = $this->guzzle->send($request);
        if($response->getStatusCode() == 200){
            return json_decode($response->getBody()->getContents());
        }

        return null;
    }

    /**
     * 
     */
    public function setAccessToken($access_token)
    {
        $this->accessToken = $access_token;
    }
}