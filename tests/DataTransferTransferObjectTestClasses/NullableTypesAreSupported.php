<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class NullableTypesAreSupported extends DataTransferObject
{
    /** @var string|null */
    public $foo;
}
