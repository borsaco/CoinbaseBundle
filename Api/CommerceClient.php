<?php

namespace Borsaco\CoinbaseBundle\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CommerceClient
{

    private $jsonContent;
    private $httpResponse;
    private $status = '';
    private $statuscode = 0;

    const VERSION = "2018-03-22";
    const CONTENT_TYPE = "application/json";
    const URL_CHECKOUT = "https://api.commerce.coinbase.com/checkouts";
    const URL_CHARGE = "https://api.commerce.coinbase.com/charges";
    const URL_CHARGES = "https://api.commerce.coinbase.com/charges?limit=100";

    const HTTP_STATUS_CODE_OK = "200";//OK
    const HTTP_STATUS_CODE_CREATED = "201";//Created
    const HTTP_STATUS_CODE_ACCEPTED = "202";//Accepted

    /**
     * @var string
     */
    protected $apikey;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $webhooksecret;


    public function __construct(string $apikey, string $version, string $webhooksecret) {
        $this->httpClient = new Client();

        $this->apikey = $apikey;
        $this->version = $version;
        $this->webhooksecret = $webhooksecret;
    }

    public function __destruct() {

    }

    public function checkout() {

        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'X-CC-Api-Key' => $this->apikey,
                'X-CC-Version' => $this->version
            ]
        ];

        try {
            $response = $this->httpClient->request('GET', self::URL_CHECKOUT, $options);
            $content = $response->getBody()->getContents();
            if($response->getStatusCode() == self::HTTP_STATUS_CODE_OK){
                $this->httpResponse = json_decode($content);
                $this->jsonContent = json_decode($content, true);
            }else{
                $this->status = $response->getReasonPhrase();
                $this->statuscode = $response->getStatusCode();
            }
        } catch (GuzzleException $e) {
            $this->status = $e->getMessage();
            $this->statuscode = $e->getCode();
        }

    }

    public function createNewCharge($json){

        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'X-CC-Api-Key' => $this->apikey,
                'X-CC-Version' => $this->version,
                'Content-Type' => self::CONTENT_TYPE
            ],
            \GuzzleHttp\RequestOptions::JSON => $json
        ];


        try {
            $response = $this->httpClient->request('POST', self::URL_CHARGE, $options);
            $content = $response->getBody()->getContents();

            if($response->getStatusCode() == self::HTTP_STATUS_CODE_CREATED){//created
                $this->httpResponse = json_decode($content);
                $this->jsonContent = json_decode($content, true);
            }else{
                $this->status = $response->getReasonPhrase();
                $this->statuscode = $response->getStatusCode();
                return null;
            }

        } catch (GuzzleException $e) {
            $this->status = $e->getMessage();
            $this->statuscode = $e->getCode();
            return null;
        }

        return $content;
    }

    public function getCharge($code){

        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'X-CC-Api-Key' => $this->apikey,
                'X-CC-Version' => $this->version
            ]
        ];

        try {
            $response = $this->httpClient->request('GET', self::URL_CHARGE . '/' . $code, $options);
            $content = $response->getBody()->getContents();

            if($response->getStatusCode() == self::HTTP_STATUS_CODE_OK){
                $this->httpResponse = json_decode($content);
                $this->jsonContent = json_decode($content, true);
            }else{
                $this->status = $response->getReasonPhrase();
                $this->statuscode = $response->getStatusCode();
                return null;
            }
        } catch (GuzzleException $e) {
            $this->status = $e->getMessage();
            $this->statuscode = $e->getCode();
            return null;
        }

        return $content;
    }


    public function getCharges(){

        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'X-CC-Api-Key' => $this->apikey,
                'X-CC-Version' => $this->version
            ]
        ];

        try {
            $response = $this->httpClient->request('GET', self::URL_CHARGES, $options);
            $content = $response->getBody()->getContents();

            if($response->getStatusCode() == self::HTTP_STATUS_CODE_OK){
                $this->httpResponse = json_decode($content);
                $this->jsonContent = json_decode($content, true);
            }else{
                $this->status = $response->getReasonPhrase();
                $this->statuscode = $response->getStatusCode();
                return null;
            }
        } catch (GuzzleException $e) {
            $this->status = $e->getMessage();
            $this->statuscode = $e->getCode();
            return null;
        }

        return $content;
    }


    /**
     * @return mixed
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }

    /**
     * @param mixed $httpResponse
     */
    public function setHttpResponse($httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatuscode(): int
    {
        return $this->statuscode;
    }

    /**
     * @param int $statuscode
     */
    public function setStatuscode(int $statuscode): void
    {
        $this->statuscode = $statuscode;
    }

    /**
     * @return mixed
     */
    public function getJsonContent()
    {
        return $this->jsonContent;
    }

    /**
     * @param mixed $jsonContent
     */
    public function setJsonContent($jsonContent): void
    {
        $this->jsonContent = $jsonContent;
    }

    /**
     * @return string
     */
    public function getApikey(): string
    {
        return $this->apikey;
    }

    /**
     * @param string $apikey
     */
    public function setApikey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

    /**
     * @return string
     */
    public function getWebhooksecret(): string
    {
        return $this->webhooksecret;
    }

    /**
     * @param string $webhooksecret
     */
    public function setWebhooksecret(string $webhooksecret): void
    {
        $this->webhooksecret = $webhooksecret;
    }
}