<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class AnExceptionIsThrownForAGenericCollectionOfNull extends DataTransferObject
{
    /** @var string[] */
    public $foo;
}
