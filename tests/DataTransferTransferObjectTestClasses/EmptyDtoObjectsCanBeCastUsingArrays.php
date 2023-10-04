<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class EmptyDtoObjectsCanBeCastUsingArrays extends DataTransferObject
{
    /** @var \Spatie\DataTransferObject\Tests\TestClasses\EmptyChild */
    public $child;
}
