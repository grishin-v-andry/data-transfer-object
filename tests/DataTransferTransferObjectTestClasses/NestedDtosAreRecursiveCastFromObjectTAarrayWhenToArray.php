<?php

namespace Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses;

use Spatie\DataTransferObject\DataTransferObject;

class NestedDtosAreRecursiveCastFromObjectTAarrayWhenToArray extends DataTransferObject
{
    /** @var \Spatie\DataTransferObject\Tests\TestClasses\NestedChild[] */
    public $childs;
}
