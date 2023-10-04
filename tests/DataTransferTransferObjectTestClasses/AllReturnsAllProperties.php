<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class AllReturnsAllProperties extends DataTransferObject
{
    /** @var int */
    public $foo;

    /** @var int */
    public $bar;
}
