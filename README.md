# CoinbaseBundle
Coinbase Commerce Bundle for Symfony

## API Reference

For more information about Coinbase Commerce API, look at:
 
> https://commerce.coinbase.com/docs/

## Getting Started

Assuming you already have your own **symfony** project, please follow the below instructions along with configuration installation and test codes.
This bundle makes it very easy to develop high level of Coinbase Commerce applications. 

## Prerequisites

Create **_coinbase.yaml_** file under folder **_[symfonyproject]/config/packages/_**  

##### coinbase.yaml

```
coinbase_commerce:
  api:
    key: 3f8944d4*********************
    version: "2018-03-22"
  webhook:
    secret: 3e859e4b************************
```



## Installing

edit your composer with the bundle library and version

```
composer require borsaco/coinbase-bundle
```

## Development

You can get the handler inside your Controller and call the functions

### Create new Charge
Let's create a new charge along with $3.6 donation. The input can be json array, json string or Charge object

#### CALL WITH JSON ARRAY
```
   use Borsaco\CoinbaseBundle\Handler\CoinbaseHandler;

   /**
    * @Route("/acceptcrypto/", name="acceptcrypto")
    */
    public function acceptDonation(CoinbaseHandler $coinbaseHandler){
        $amount = 3.6;//$3.6 dollars
        $json =  [
           "name" => "Cancer Donation Box",
           "description" => "Donate to Children",
           "local_price" => array("amount" => $amount, "currency" => "USD"),
           "pricing_type" => "fixed_price",
           "metadata" => array("id" => "1234", "firstname" => "John", "lastname" => "Doe", "email" => "jdoe@example.com")
        ];
        
        $charge = $coinbaseHandler->createNewCharge($json);//get the charge object

        $this->redirect($charge->getHostedUrl());//it will redirect you to the coinbase crypto box to be paid in 15 minutes
    }
```

#### CALL WITH JSON STRING
```
   /**
    * @Route("/acceptcrypto/", name="acceptcrypto")
    */
    public function acceptDonation(CoinbaseHandler $coinbaseHandler){
        
        $json_string = "{\"name\":\"Cancer Donation Form\",\"description\":\"Donation to Children\",\"pricing_type\":\"fixed_price\",\"local_price\":{\"amount\":\"2.7\",\"currency\":\"USD\"},\"meta_data\":{\"id\":\"12345\",\"firstname\":\"Victor\",\"lastname\":\"Doe\",\"email\":\"vdoe@example.com\"}}";
        
        /**
        * @var Charge $charge
        */
        $charge = $coinbaseHandler->createNewCharge($json_string);//get the charge object

        $this->redirect($charge->getHostedUrl());//it will redirect you to the coinbase crypto box to be paid in 15 minutes
    }
```

#### CALL WITH CHARGE OBJECT
```
   /**
    * @Route("/acceptcrypto/", name="acceptcrypto")
    */
    public function acceptDonation(CoinbaseHandler $coinbaseHandler){
        
        /**
        * @var Charge $charge
        */
        $charge = new Charge();
        $charge->setName("Cancer Donation Form");
        $charge->setDescription("Donation to Children");
        $charge->setPricingType("fixed_price");
       
        $localPrice = new Money();
        $localPrice->setAmount(2.6);
        $localPrice->setCurrency("USD");
        $charge->setLocalPrice($localPrice);
       
       
        //Whatever object fields you wanna put
        $metadata = new Metadata();
        $metadata->id = "1234";
        $metadata->firstname = "Melisa";
        $metadata->lastname = "Doe";
        $metadata->email = "mdoe@example.com";
        $charge->setMetadata($metadata);
        
        /**
        * @var Charge $charge
        */
        $charge = $coinbaseHandler->createNewCharge($charge);//get the charge object

        $this->redirect($charge->getHostedUrl());//it will redirect you to the coinbase crypto box to be paid in 15 minutes
    }
```

## Show a Charge
```
$code = "2G3GM4X9";
/**
* get a single charge
* @var Charge $charge
*/
$charge = $coinbaseHandler->showCharge($code);
$hosted_url = $charge->getHostedUrl();
```

## List Charges
```
/**
* list charges
* @var Charges $charges
*/
$charges = $this->_coinbaseHandler->listCharges();

//iterate through the charges
foreach ($charges->getData() as $charge){
    print_r($charge);
}
```

## Charge Object

Charge is one of your main object model that is re-usable once it is retrieved. It includes all other object models;
> Addresses, Timeline, Pricing, Money etc..

It includes the raw json string as well in case you need to look up the fields manually. 
```
$charge->getRawJson()
```

Here is an example of a returned Charge object that is already expired. No action taken in 15 minutes

```
App\Coinbase\Commerce\Model\Charge Object
(
    [code:protected] => GR9M6MYK
    [name:protected] => Cancer Donation Box
    [description:protected] => Donate to Children
    [hosted_url:protected] => https://commerce.coinbase.com/charges/GR9M6MYK
    [created_at:protected] => 2018-06-18T22:21:38Z
    [expires_at:protected] => 2018-06-18T22:36:38Z
    [confirmed_at:protected] => 
    [pricing_type:protected] => fixed_price
    [addresses:protected] => App\Coinbase\Commerce\Model\Addresses Object
        (
            [ethereum:protected] => 0xa5027c04f257f8f9c4a2f1f10***************
            [bitcoin:protected] => 1PTGB2jGD8ohqdtPPFa***************
            [bitcoincash:protected] => qqz8q26722wq22ep9fsxy0vu4sz***************
            [litecoin:protected] => LKF2ETmPtqkqYG1s1f1***************
        )

    [metadata:protected] => App\Coinbase\Commerce\Model\Metadata Object
        (
            [id] => 1234
            [firstname] => John
            [lastname] => Doe
            [email] => jdoe@example.com
        )

    [timeline:protected] => Array
        (
            [0] => App\Coinbase\Commerce\Model\Timeline Object
                (
                    [status:protected] => NEW
                    [time:protected] => 2018-06-18T22:21:38Z
                    [payment:protected] => 
                )

            [1] => App\Coinbase\Commerce\Model\Timeline Object
                (
                    [status:protected] => EXPIRED
                    [time:protected] => 2018-06-18T22:36:46Z
                    [payment:protected] => 
                )

        )

    [pricing:protected] => App\Coinbase\Commerce\Model\Pricing Object
        (
            [local:protected] => App\Coinbase\Commerce\Model\Money Object
                (
                    [amount:protected] => 1.00
                    [currency:protected] => USD
                )

            [ethereum:protected] => App\Coinbase\Commerce\Model\Money Object
                (
                    [amount:protected] => 0.001935000
                    [currency:protected] => ETH
                )

            [bitcoin:protected] => App\Coinbase\Commerce\Model\Money Object
                (
                    [amount:protected] => 0.00014900
                    [currency:protected] => BTC
                )

            [bitcoincash:protected] => App\Coinbase\Commerce\Model\Money Object
                (
                    [amount:protected] => 0.00112791
                    [currency:protected] => BCH
                )

            [litecoin:protected] => App\Coinbase\Commerce\Model\Money Object
                (
                    [amount:protected] => 0.01010867
                    [currency:protected] => LTC
                )

        )

    [payments:protected] => Array
        (
        )

    [json:protected] => Array
        (
            [data] => Array
                (
                    [addresses] => Array
                        (
                            [ethereum] => 0xa5027c04f257f8f9c4a2f1f10***************
                            [bitcoin] => 1PTGB2jGD8ohqdtPPFa***************
                            [bitcoincash] => qqz8q26722wq22ep9fsxy0vu4sz***************
                            [litecoin] => LKF2ETmPtqkqYG1s1f1***************
                        )

                    [code] => GR9M6MYK
                    [created_at] => 2018-06-18T22:21:38Z
                    [description] => Donate to Children
                    [expires_at] => 2018-06-18T22:36:38Z
                    [hosted_url] => https://commerce.coinbase.com/charges/GR9M6MYK
                    [metadata] => Array
                        (
                            [id] => 1234
                            [firstname] => John
                            [lastname] => Doe
                            [email] => jdoe@example.com
                        )

                    [name] => Cancer Donation Box
                    [payments] => Array
                        (
                        )

                    [pricing] => Array
                        (
                            [local] => Array
                                (
                                    [amount] => 1.00
                                    [currency] => USD
                                )

                            [ethereum] => Array
                                (
                                    [amount] => 0.001935000
                                    [currency] => ETH
                                )

                            [bitcoin] => Array
                                (
                                    [amount] => 0.00014900
                                    [currency] => BTC
                                )

                            [bitcoincash] => Array
                                (
                                    [amount] => 0.00112791
                                    [currency] => BCH
                                )

                            [litecoin] => Array
                                (
                                    [amount] => 0.01010867
                                    [currency] => LTC
                                )

                        )

                    [pricing_type] => fixed_price
                    [timeline] => Array
                        (
                            [0] => Array
                                (
                                    [status] => NEW
                                    [time] => 2018-06-18T22:21:38Z
                                )

                            [1] => Array
                                (
                                    [status] => EXPIRED
                                    [time] => 2018-06-18T22:36:46Z
                                )

                        )

                )

        )

)

```

### Webhook
To retrieve a Webhook object from a json string, use the method below, just so simple!

```
/** @var Webhook $webhook */
$webhook = $this->_coinbaseHandler->parseWebhook($jsonString);
```

When Coinbase calls your webhook endpoint, follow the below example inside your controller

```
    /**
    * @Route("/webhooks/", name="webhooks")
    * @throws \Exception
    */
    public function webHook(Request $request, CoinbaseHandler $coinbaseHandler){

        if ($request->getMethod() != 'POST') {
            return new Response( 'Only post requests accepted!',  400);
        }

        $jsonString = $request->getContent();//get the json string from the request

        // This header contains the SHA256 HMAC signature of the raw request payload
        $cc_signagure = isset($_SERVER["HTTP_X_CC_WEBHOOK_SIGNATURE"]) ? $_SERVER["HTTP_X_CC_WEBHOOK_SIGNATURE"] : '';
        if(!$coinbaseHandler->validateWebhookSignature($cc_signagure, $request)){
                throw new \Exception("Request could not be validated");
        }
        
        /** @var Webhook $webhook */
        $webhook = $coinbaseHandler->parseWebhook($jsonString);
        //You have your webhook object. Do Something... save webhook data to database or email people or anything useful

        if($webhook->getEvent()->getType() == Event::TYPE_CHARGE_CREATED){
            //Do Something
        }

        return new Response('',Response::HTTP_OK, array('Content-Type' => 'text/html'));//make sure you respond with status 200 (OK) at the end
    }

```

### Webhook Object
Here is an example of Webhook Object
```
App\Coinbase\Commerce\Model\Webhook Object
(
    [id:protected] => 1
    [scheduled_for:protected] => 2017-01-31T20:50:02Z
    [event:protected] => App\Coinbase\Commerce\Model\Event Object
        (
            [id:protected] => 24934862-d980-46cb-9402-43c81b0cdba6
            [type:protected] => charge:created
            [api_version:protected] => 2018-03-22
            [created_at:protected] => 2017-01-31T20:49:02Z
            [data:protected] => App\Coinbase\Commerce\Model\Charge Object
                (
                    [code:protected] => 66BEOV2A
                    [name:protected] => The Sovereign Individual
                    [description:protected] => Mastering the Transition to the Information Age
                    [local_price:protected] => 
                    [hosted_url:protected] => https://commerce.coinbase.com/charges/66BEOV2A
                    [created_at:protected] => 2017-01-31T20:49:02Z
                    [expires_at:protected] => 2017-01-31T21:04:02Z
                    [confirmed_at:protected] => 
                    [pricing_type:protected] => no_price
                    [addresses:protected] => App\Coinbase\Commerce\Model\Addresses Object
                        (
                            [ethereum:protected] => 0x419f91df39951fd4e8acc8f1874b01c0c78ceba6
                            [bitcoin:protected] => mymZkiXhQNd6VWWG7VGSVdDX9bKmviti3U
                            [bitcoincash:protected] => 
                            [litecoin:protected] => 
                        )

                    [metadata:protected] => App\Coinbase\Commerce\Model\Metadata Object
                        (
                        )

                    [timeline:protected] => Array
                        (
                            [0] => App\Coinbase\Commerce\Model\Timeline Object
                                (
                                    [status:protected] => NEW
                                    [time:protected] => 2017-01-31T20:49:02Z
                                    [payment:protected] => 
                                )

                        )

                    [pricing:protected] => 
                    [payments:protected] => Array
                        (
                        )

                    [raw_json:protected] => Array
                        (
                            [code] => 66BEOV2A
                            [name] => The Sovereign Individual
                            [description] => Mastering the Transition to the Information Age
                            [hosted_url] => https://commerce.coinbase.com/charges/66BEOV2A
                            [created_at] => 2017-01-31T20:49:02Z
                            [expires_at] => 2017-01-31T21:04:02Z
                            [timeline] => Array
                                (
                                    [0] => Array
                                        (
                                            [time] => 2017-01-31T20:49:02Z
                                            [status] => NEW
                                        )

                                )

                            [metadata] => Array
                                (
                                )

                            [pricing_type] => no_price
                            [payments] => Array
                                (
                                )

                            [addresses] => Array
                                (
                                    [bitcoin] => mymZkiXhQNd6VWWG7VGSVdDX9bKmviti3U
                                    [ethereum] => 0x419f91df39951fd4e8acc8f1874b01c0c78ceba6
                                )

                        )

                )

        )

)
```

# Note
This is a repaired copy of https://github.com/mehmetsen80/cbcommercesymfonybundle
