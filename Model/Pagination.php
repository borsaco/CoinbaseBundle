<?php

namespace Borsaco\CoinbaseBundle\Model;


class Pagination
{
    /** @var string */
    protected $order;

    /** @var integer */
    protected $starting_after;

    /** @var integer */
    protected $ending_before;

    /** @var integer */
    protected $total;

    /** @var integer */
    protected $limit;

    /** @var integer */
    protected $yielded;

    /** @var integer[] */
    protected $cursor_range;

    /** @var string */
    protected $previous_uri;

    /** @var string */
    protected $next_uri;

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order): void
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getStartingAfter(): int
    {
        return $this->starting_after;
    }

    /**
     * @param int $starting_after
     */
    public function setStartingAfter(int $starting_after): void
    {
        $this->starting_after = $starting_after;
    }

    /**
     * @return int
     */
    public function getEndingBefore(): int
    {
        return $this->ending_before;
    }

    /**
     * @param int $ending_before
     */
    public function setEndingBefore(int $ending_before): void
    {
        $this->ending_before = $ending_before;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getYielded(): int
    {
        return $this->yielded;
    }

    /**
     * @param int $yielded
     */
    public function setYielded(int $yielded): void
    {
        $this->yielded = $yielded;
    }

    /**
     * @return integer[]
     */
    public function getCursorRange(): array
    {
        return $this->cursor_range;
    }

    /**
     * @param integer[] $cursor_range
     */
    public function setCursorRange(array $cursor_range): void
    {
        $this->cursor_range = $cursor_range;
    }

    /**
     * @return string
     */
    public function getPreviousUri(): string
    {
        return $this->previous_uri;
    }

    /**
     * @param string $previous_uri
     */
    public function setPreviousUri(string $previous_uri): void
    {
        $this->previous_uri = $previous_uri;
    }

    /**
     * @return string
     */
    public function getNextUri(): string
    {
        return $this->next_uri;
    }

    /**
     * @param string $next_uri
     */
    public function setNextUri(string $next_uri): void
    {
        $this->next_uri = $next_uri;
    }

}