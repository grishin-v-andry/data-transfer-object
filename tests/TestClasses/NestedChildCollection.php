<?php

namespace Spatie\DataTransferObject\Tests\TestClasses;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class NestedChildCollection extends DataTransferObjectCollection
{
    /**
     * @return NestedParent
     */
    public function current()
    {
        return parent::current();
    }
}
