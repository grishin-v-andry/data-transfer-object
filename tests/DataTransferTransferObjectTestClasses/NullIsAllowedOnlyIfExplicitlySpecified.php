<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class NullIsAllowedOnlyIfExplicitlySpecified extends DataTransferObject
{
    /** @var string */
    public $foo;
}
