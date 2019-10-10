<?php

namespace Borsaco\CoinbaseBundle\Model;


class Webhook implements \JsonSerializable
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $scheduled_for;

    /** @var Event */
    protected $event;

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
    public function getScheduledFor(): string
    {
        return $this->scheduled_for;
    }

    /**
     * @param string $scheduled_for
     */
    public function setScheduledFor(string $scheduled_for): void
    {
        $this->scheduled_for = $scheduled_for;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param Event $event
     */
    public function setEvent(Event $event): void
    {
        $this->event = $event;
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
            "scheduled_for" => $this->scheduled_for,
            "event" => $this->event
        ];
    }
}