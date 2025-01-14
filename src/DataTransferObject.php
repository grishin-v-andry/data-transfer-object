<?php

namespace Spatie\DataTransferObject;

use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject
{
    /** @var array */
    protected $exceptKeys = [];

    /** @var array */
    protected $onlyKeys = [];

    /**
     * @param array $parameters
     *
     * @return \Spatie\DataTransferObject\ImmutableDataTransferObject|static
     */
    public static function immutable(array $parameters)
    {
        return new ImmutableDataTransferObject(new static($parameters));
    }

    /**
     * @param array $parameters
     * @throws DataTransferObjectError
     */
    public function __construct(array $parameters)
    {
        $class = new ReflectionClass(static::class);

        $properties = $this->getPublicProperties($class);

        foreach ($properties as $property) {
            if (
                ! isset($parameters[$property->getName()])
                && ! $property->isDefault()
                && ! $property->isNullable()
            ) {
                throw DataTransferObjectError::uninitialized($property);
            }

            $value = array_key_exists($property->getName(), $parameters)
                ? $parameters[$property->getName()]
                : $property->getValue($this);

            $property->set($value);

            unset($parameters[$property->getName()]);
        }

        if (count($parameters)) {
            throw DataTransferObjectError::unknownProperties(array_keys($parameters), $class->getName());
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $reflectionProperty) {
            $data[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
        }

        return $data;
    }

    /**
     * @param string ...$keys
     *
     * @return static
     */
    public function only(...$keys)
    {
        $valueObject = clone $this;

        $valueObject->onlyKeys = array_merge($this->onlyKeys, $keys);

        return $valueObject;
    }

    /**
     * @param string ...$keys
     *
     * @return static
     */
    public function except(...$keys)
    {
        $valueObject = clone $this;

        $valueObject->exceptKeys = array_merge($this->exceptKeys, $keys);

        return $valueObject;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if (count($this->onlyKeys)) {
            $array = Arr::only($this->all(), $this->onlyKeys);
        } else {
            $array = Arr::except($this->all(), $this->exceptKeys);
        }

        $array = $this->parseArray($array);

        return $array;
    }

    /**
     * @param array $array
     * @return array
     */
    protected function parseArray(array $array)
    {
        foreach ($array as $key => $value) {
            if (
                $value instanceof DataTransferObject
                || $value instanceof DataTransferObjectCollection
            ) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (! is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }

    /**
     * @param \ReflectionClass $class
     *
     * @return array|\Spatie\DataTransferObject\Property[]
     */
    protected function getPublicProperties(ReflectionClass $class)
    {
        $properties = [];

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty) {
            $properties[$reflectionProperty->getName()] = Property::fromReflection($this, $reflectionProperty);
        }

        return $properties;
    }
}
