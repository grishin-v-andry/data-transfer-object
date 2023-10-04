<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class AnExceptionIsThrownWhenPropertyWasNotInitialised extends DataTransferObject
{
    /** @var string */
    public $foo;
}
