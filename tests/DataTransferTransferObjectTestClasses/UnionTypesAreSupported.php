<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class UnionTypesAreSupported extends DataTransferObject
{
    /** @var string|bool */
    public $foo;
}
