<?php

namespace Spatie\DataTransferObject;

use Iterator;
use Countable;
use ArrayAccess;

abstract class DataTransferObjectCollection implements
    ArrayAccess,
    Iterator,
    Countable
{
    /** @var array */
    protected $collection;

    /** @var int */
    protected $position = 0;

    /**
     * @param array $collection
     */
    public function __construct(array $collection = [])
    {
        $this->collection = $collection;
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->collection[$this->position];
    }

    /**
     * @param $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->collection) ? $this->collection[$offset] : null;
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->collection[] = $value;
        } else {
            $this->collection[$offset] = $value;
        }
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->collection);
    }

    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->collection[$offset]);
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->position++;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return array_key_exists($this->position, $this->collection);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $collection = $this->collection;

        foreach ($collection as $key => $item) {
            if (
                ! $item instanceof DataTransferObject
                && ! $item instanceof DataTransferObjectCollection
            ) {
                continue;
            }

            $collection[$key] = $item->toArray();
        }

        return $collection;
    }

    /**
     * @return array
     */
    public function items()
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }
}
