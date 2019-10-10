<?php

namespace Borsaco\CoinbaseBundle\Model;


class Value implements \JsonSerializable
{
    /** @var Money */
    protected $local;

    /** @var Money */
    protected $crypto;

    /**
     * @return Money
     */
    public function getLocal(): Money
    {
        return $this->local;
    }

    /**
     * @param Money $local
     */
    public function setLocal(Money $local): void
    {
        $this->local = $local;
    }

    /**
     * @return Money
     */
    public function getCrypto(): Money
    {
        return $this->crypto;
    }

    /**
     * @param Money $crypto
     */
    public function setCrypto(Money $crypto): void
    {
        $this->crypto = $crypto;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Local: " . $this->getLocal() . ", Crypto: " . $this->getCrypto();
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
            'local' => $this->local,
            'crypto' => $this->crypto
        ];
    }
}