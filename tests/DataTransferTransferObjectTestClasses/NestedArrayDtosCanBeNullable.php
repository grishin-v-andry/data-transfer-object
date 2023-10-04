<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class NestedArrayDtosCanBeNullable extends DataTransferObject
{
    /** @var \Spatie\DataTransferObject\Tests\TestClasses\NestedChild[]|null */
    public $children;
}
