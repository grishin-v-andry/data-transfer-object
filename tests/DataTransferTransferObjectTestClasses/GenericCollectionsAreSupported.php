<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class GenericCollectionsAreSupported extends DataTransferObject
{
    /** @var \Spatie\DataTransferObject\Tests\TestClasses\DummyClass[] */
    public $foo;
}
