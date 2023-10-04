<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class NestedArrayDtosAreRecursiveCastToArraysOfDtos extends DataTransferObject
{
    /** @var \Spatie\DataTransferObject\Tests\TestClasses\NestedParentOfMany[] */
    public $children;
}
