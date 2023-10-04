<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class DefaultValuesAreSupported extends DataTransferObject
{
    /** @var string */
    public $foo = 'abc';

    /** @var bool */
    public $bar;
}
