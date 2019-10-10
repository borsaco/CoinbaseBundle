<?php

namespace Borsaco\CoinbaseBundle\Model;


class Event implements \JsonSerializable
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $type;

    /** @var string */
    protected $api_version;

    /** @var string */
    protected $created_at;

    /** @var Charge */
    protected $data;

    /**
     * @var string
     */
    const TYPE_CHARGE_CREATED = 'charge:created';

    /**
     * @var string
     */
    const TYPE_CHARGE_CONFIRMED = 'charge:confirmed';

    /**
     * @var string
     */
    const TYPE_CHARGE_FAILED = 'charge:failed';

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->api_version;
    }

    /**
     * @param string $api_version
     */
    public function setApiVersion(string $api_version): void
    {
        $this->api_version = $api_version;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     */
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Charge
     */
    public function getData(): Charge
    {
        return $this->data;
    }

    /**
     * @param Charge $data
     */
    public function setData(Charge $data): void
    {
        $this->data = $data;
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
            "id" => $this->id,
            "type" => $this->type,
            "api_version" => $this->api_version,
            "created_at" => $this->created_at,
            "data" => $this->data
        ];
    }
}