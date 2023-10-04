<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class OnlyTheTypeHintedTypeMayBePassed extends DataTransferObject
{
    /** @var string */
    public $foo;
}
