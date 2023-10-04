<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class MixedIsSupported extends DataTransferObject
{
    /** @var mixed */
    public $foo;
}
