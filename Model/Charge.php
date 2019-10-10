<?php

namespace Borsaco\CoinbaseBundle\Model;


class Charge implements \JsonSerializable
{
    /** @var string */
    protected $code;

    /** @var string */
    protected $name;

    /** @var string */
    protected $description;

    /** @var Money */
    protected $local_price;

    /** @var string */
    protected $hosted_url;

    /** @var string */
    protected $created_at;

    /** @var string */
    protected $expires_at;

    /** @var string */
    protected $confirmed_at;

    /** @var string */
    protected $pricing_type;

    /** @var Addresses */
    protected $addresses;

    /** @var Metadata */
    protected $metadata;

    /** @var Timeline[] */
    protected $timeline;

    /** @var Pricing */
    protected $pricing;

    /** @var Payment[] */
    protected $payments;

    /** @var array */
    protected $raw_json;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return Money
     */
    public function getLocalPrice()
    {
        return $this->local_price;
    }

    /**
     * @param Money $local_price
     */
    public function setLocalPrice(Money $local_price)
    {
        $this->local_price = $local_price;
    }

    /**
     * @return string
     */
    public function getHostedUrl()
    {
        return $this->hosted_url;
    }

    /**
     * @param string $hosted_url
     */
    public function setHostedUrl(string $hosted_url)
    {
        $this->hosted_url = $hosted_url;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string  $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getExpiresAt()
    {
        return $this->expires_at;
    }

    /**
     * @param string $expires_at
     */
    public function setExpiresAt(string $expires_at)
    {
        $this->expires_at = $expires_at;
    }

    /**
     * @return string
     */
    public function getConfirmedAt()
    {
        return $this->confirmed_at;
    }

    /**
     * @param string $confirmed_at
     */
    public function setConfirmedAt(string $confirmed_at)
    {
        $this->confirmed_at = $confirmed_at;
    }

    /**
     * @return string
     */
    public function getPricingType()
    {
        return $this->pricing_type;
    }

    /**
     * @param string $pricing_type
     */
    public function setPricingType(string $pricing_type)
    {
        $this->pricing_type = $pricing_type;
    }

    /**
     * @return Addresses
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @param Addresses $addresses
     */
    public function setAddresses(Addresses $addresses)
    {
        $this->addresses = $addresses;
    }

    /**
     * @return Metadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param Metadata $metadata
     */
    public function setMetadata(Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * @return Timeline[]
     */
    public function getTimeline()
    {
        return $this->timeline;
    }

    /**
     * @param Timeline[] $timeline
     */
    public function setTimeline(array $timeline)
    {
        $this->timeline = $timeline;
    }

    /**
     * @return Pricing
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * @param Pricing $pricing
     */
    public function setPricing(Pricing $pricing)
    {
        $this->pricing = $pricing;
    }

    /**
     * @return Payment[]
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * @param Payment[] $payments
     */
    public function setPayments(array $payments)
    {
        $this->payments = $payments;
    }

    /**
     * @return array
     */
    public function getRawJson(): array
    {
        return $this->raw_json;
    }

    /**
     * @param array $raw_json
     */
    public function setRawJson(array $raw_json)
    {
        $this->raw_json = $raw_json;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return  "Name: " . $this->getName() . ", Code:" . $this->getCode() . ", Description: " . $this->getDescription() . ", HostedUrl: " . $this->getHostedUrl() . ", CreatedAt: " . $this->getCreatedAt() .
            ", ExpiresAt: " . $this->getExpiresAt() . ", ConfirmedAt: " . $this->getConfirmedAt() . ", PricingType: " . $this->getPricingType() . ", Addresses: " . $this->getAddresses();
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'addresses' => $this->addresses,
            'code'  => $this->code,
            'created_at' => $this->created_at,
            'expires_at' => $this->expires_at,
            'hosted_url' => $this->hosted_url,
            'name'  => $this->name,
            'description'  => $this->description,
            'local_price' => $this->local_price,
            'metadata'  => $this->metadata,
            'pricing'   => $this->pricing,
            'pricing_type'  => $this->pricing_type,
            'timeline'  => $this->timeline,
            'payments' => $this->payments

        ];
    }
}