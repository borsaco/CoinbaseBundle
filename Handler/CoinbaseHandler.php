<?php

namespace Borsaco\CoinbaseBundle\Handler;

use Borsaco\CoinbaseBundle\Model\Addresses;
use Borsaco\CoinbaseBundle\Api\CommerceClient;
use Borsaco\CoinbaseBundle\Model\Block;
use Borsaco\CoinbaseBundle\Model\Charge;
use Borsaco\CoinbaseBundle\Model\Charges;
use Borsaco\CoinbaseBundle\Model\Event;
use Borsaco\CoinbaseBundle\Model\Metadata;
use Borsaco\CoinbaseBundle\Model\Money;
use Borsaco\CoinbaseBundle\Model\Pagination;
use Borsaco\CoinbaseBundle\Model\Payment;
use Borsaco\CoinbaseBundle\Model\Pricing;
use Borsaco\CoinbaseBundle\Model\Timeline;
use Borsaco\CoinbaseBundle\Model\Webhook;
use Borsaco\CoinbaseBundle\Model\Value;
use Borsaco\CoinbaseBundle\Util\Castable;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CoinbaseHandler
{
    protected $client;

    public function __construct(ContainerInterface $container)
    {
        $config = $container->getParameter('coinbase_bundle.config');
        $this->client = new CommerceClient($config['api']['key'], $config['api']['version'], $config['webhook']['secret']);
    }

    public function createNewCharge($input){

        $charge = null;

        if(is_object($input) && $input instanceof Charge){
            $json = json_encode($input);
            $input = json_decode($json,true);
        }else if(is_string($input) && is_array(json_decode($input, true))) {
            $input = json_decode($input, true);
        }


        if(!is_array($input)) { 
            return null;
        }

        $jsonString = $this->client->createNewCharge($input);
    
        return $this->parseCharge($jsonString);
    }

    public function parseWebhook($jsonString){


        $json = json_decode($jsonString);

        if(!is_array($input)) { 
            return null;
        }

        $webhook = Castable::cast(new Webhook(), $json);
        $event = Castable::cast(new Event(), $json->event);
        $data = $this->parseCharge (json_encode($json->event->data));
        $event->setData($data);
        $webhook->setEvent($event);

        return $webhook;
    }

    public function parseCharge($jsonString): Charge {

        $json = json_decode($jsonString);
        $jsonArray = json_decode($jsonString, true);

        if(!is_array($json)) { 
            return null;
        }

        $json =  property_exists($json, 'data') ? $json->data : $json;

        $charge = Castable::cast(new Charge(), $json);
        $charge->setRawJson($jsonArray);

        $addresses = Castable::cast(new Addresses(), $json->addresses);
        $charge->setAddresses($addresses);

        $timelineArr  = array();
        foreach ($json->timeline as $item){
            /** @var Timeline $timeline */
            $timeline = Castable::cast(new Timeline(), $item);

            if(property_exists($item,'payment')){
                /** @var Payment $payment */
                $payment = Castable::cast(new Payment(), $item->payment);
                $timeline->setPayment($payment);
            }

            $timelineArr[] = $timeline;
        }
        $charge->setTimeline($timelineArr);

        if(property_exists($json, 'pricing')){

            $pricing = Castable::cast(new Pricing(), $json->pricing);
            if(property_exists($json->pricing, 'local')){
                $moneyLocal = Castable::cast(new Money(), $json->pricing->local);
                $pricing->setLocal($moneyLocal);
            }
            if(property_exists($json->pricing, 'ethereum')){
                $moneyEthereum = Castable::cast(new Money(), $json->pricing->ethereum);
                $pricing->setEthereum($moneyEthereum);
            }
            if(property_exists($json->pricing, 'bitcoin')){
                $moneyBitcoin = Castable::cast(new Money(), $json->pricing->bitcoin);
                $pricing->setBitcoin($moneyBitcoin);
            }
            if(property_exists($json->pricing, 'bitcoincash')){
                $moneyBitcoincash = Castable::cast(new Money(), $json->pricing->bitcoincash);
                $pricing->setBitcoincash($moneyBitcoincash);
            }
            if(property_exists($json->pricing, 'litecoin')){
                $moneyLitecoin = Castable::cast(new Money(), $json->pricing->litecoin);
                $pricing->setLitecoin($moneyLitecoin);
            }
            $charge->setPricing($pricing);
        }

        $paymentsArr = array();
        foreach ($json->payments as $item){
            /** @var Payment $payment */
            $payment = Castable::cast(new Payment(), $item);

            //if value property exists in item (payment) json object
            if(property_exists($item, 'value')){
                /** @var Value $value */
                $value = Castable::cast(new Value(), $item->value);
                //local money
                if(property_exists($item->value, 'local')){
                    /** @var Money $moneyLocal */
                    $moneyLocal = Castable::cast(new Money(), $item->value->local);
                    $value->setLocal($moneyLocal);
                }
                //crypto money
                if(property_exists($item->value, 'crypto')){
                    /** @var Money $moneyCrypto */
                    $moneyCrypto= Castable::cast(new Money(), $item->value->crypto);
                    $value->setCrypto($moneyCrypto);
                }
                $payment->setValue($value);
            }

            //if block property exists in item (payment) json object
            if(property_exists($item, 'block')){
                /** @var Block $block */
                $block = Castable::cast(new Block(), $item->block);
                $payment->setBlock($block);
            }

            $paymentsArr[] = $payment;
        }
        $charge->setPayments($paymentsArr);

        $metadata = Castable::cast(new Metadata(), $json->metadata);
        $charge->setMetadata($metadata);

        return $charge;
    }


    public function parseCharges($jsonString): Charges {

        $json = json_decode($jsonString);

        //do nothing if nil
        if(is_null($json)) return null;

        /**
         * Create the Charges object
         * @var Charges $charges
         */
        $charges = Castable::cast(new Charges(), $json);

        /** @var Pagination $pagination */
        $pagination = Castable::cast(new Pagination(), $json->pagination);
        $charges->setPagination($pagination);

        /** @var Charge[] $chargeArr */
        $chargeArr = array();
        foreach ($json->data as $item){
            //echo " " .$item->code;
            /** @var Charge $charge */
            $charge = $this->parseCharge(json_encode($item));
            $chargeArr[] = $charge;
        }
        $charges->setData($chargeArr);


        return $charges;
    }

    /**
     * @param $code
     * @return Charge|null
     */
    public function showCharge($code){

        if(is_null($code) || empty($code)) return null;

        $jsonString = $this->getCommerceClient()->getCharge($code);
        $charge = $this->parseCharge($jsonString);
        return $charge;
    }

    /**
     * @return Charges
     */
    public function listCharges(){

        $jsonString = $this->getCommerceClient()->getCharges();
        $charges = $this->parseCharges($jsonString);
        return $charges;

    }

    /**
     * Validate webhook signature
     *
     * @param string $cc_signature, string $secret, JSON $request
     * @return boolean
     */
    public function validateWebhookSignature($cc_signature, $request) {
        if ($cc_signature != hash_hmac('SHA256', $request , $this->getCommerceClient()->getWebhooksecret())){
            return false;
        }
        return true;
    }

    /**
     * @return CommerceClient
     */
    public function getCommerceClient(): CommerceClient
    {
        return $this->client;
    }

    /**
     * @param CommerceClient $commerceClient
     */
    public function setCommerceClient(CommerceClient $commerceClient): void
    {
        $this->client = $commerceClient;
    }
}