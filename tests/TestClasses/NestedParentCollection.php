<?php

namespace Spatie\DataTransferObject\Tests\TestClasses;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class NestedParentCollection extends DataTransferObjectCollection
{
    /**
     * @return NestedChildCollection
     */
    public function current()
    {
        return parent::current();
    }
}
