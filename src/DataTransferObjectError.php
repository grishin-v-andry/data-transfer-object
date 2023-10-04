<?php

namespace Spatie\DataTransferObject;

use Exception;

class DataTransferObjectError extends Exception
{
    /**
     * @param array $properties
     * @param string $className
     * @return DataTransferObjectError
     */
    public static function unknownProperties(array $properties, $className)
    {
        $propertyNames = implode('`, `', $properties);

        return new self("Public properties `{$propertyNames}` not found on {$className}");
    }

    /**
     * @param Property $property
     * @param $value
     * @return DataTransferObjectError
     */
    public static function invalidType(Property $property, $value)
    {
        if ($value === null) {
            $value = 'null';
        }

        if (is_object($value)) {
            $value = get_class($value);
        }

        if (is_array($value)) {
            $value = 'array';
        }

        $expectedTypes = implode(', ', $property->getTypes());

        $currentType = gettype($value);

        return new self("Invalid type: expected {$property->getFqn()} to be of type {$expectedTypes}, instead got value `{$value}` ({$currentType}).");
    }

    /**
     * @param Property $property
     * @return DataTransferObjectError
     */
    public static function uninitialized(Property $property)
    {
        return new self("Non-nullable property {$property->getFqn()} has not been initialized.");
    }

    /**
     * @param string $property
     * @return DataTransferObjectError
     */
    public static function immutable($property)
    {
        return new self("Cannot change the value of property {$property} on an immutable data transfer object");
    }
}
