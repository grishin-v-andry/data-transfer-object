<?php

namespace Spatie\DataTransferObject\Tests;

use Spatie\DataTransferObject\DataTransferObjectError;
use Spatie\DataTransferObject\Tests\TestClasses\DummyClass;
use Spatie\DataTransferObject\Tests\TestClasses\EmptyChild;
use Spatie\DataTransferObject\Tests\TestClasses\OtherClass;
use Spatie\DataTransferObject\Tests\TestClasses\NestedChild;
use Spatie\DataTransferObject\Tests\TestClasses\NestedParent;
use Spatie\DataTransferObject\Tests\TestClasses\NestedParentOfMany;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\OnlyTheTypeHintedTypeMayBePassed;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\UnionTypesAreSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\NullableTypesAreSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\DefaultValuesAreSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\NullIsAllowedOnlyIfExplicitlySpecified;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\UnknownPropertiesThrowAnError;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\UnknownPropertiesShowAComprehensiveErrorMessage;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\OnlyReturnsFilteredProperties;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\ExceptReturnsFilteredProperties;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\AllReturnsAllProperties;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\MixedIsSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\FloatIsSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\ClassesAreSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\GenericCollectionsAreSupported;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\AnExceptionIsThrownForAGenericCollectionOfNull;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\AnExceptionIsThrownWhenPropertyWasNotInitialised;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\EmptyTypeDeclarationAllowsEverything;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\NestedDtosAreRecursiveCastFromObjectTAarrayWhenToArray;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\NestedArrayDtosAreRecursiveCastToArraysOfDtos;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\NestedArrayDtosCanBeNullable;
use Spatie\DataTransferObject\Tests\DataTransferTransferObjectTestClasses\EmptyDtoObjectsCanBeCastUsingArrays;

class DataTransferObjectTest extends TestCase
{

    /** @test */
    public function only_the_type_hinted_type_may_be_passed()
    {
        new OnlyTheTypeHintedTypeMayBePassed([
            'foo' => 'value',
        ]);

        $this->markTestSucceeded();

        $this->expectException(DataTransferObjectError::class);

        new OnlyTheTypeHintedTypeMayBePassed([
            'foo' => false,
        ]);
    }

    /** @test */
    public function union_types_are_supported()
    {
        new UnionTypesAreSupported(['foo' => 'value']);

        new UnionTypesAreSupported(['foo' => false]);

        $this->markTestSucceeded();
    }

    /** @test */
    public function nullable_types_are_supported()
    {
        new NullableTypesAreSupported(['foo' => null]);

        $this->markTestSucceeded();
    }

    /** @test */
    public function default_values_are_supported()
    {
        $valueObject = new DefaultValuesAreSupported(['bar' => true]);

        $this->assertEquals(['foo' => 'abc', 'bar' => true], $valueObject->all());
    }

    /** @test */
    public function null_is_allowed_only_if_explicitly_specified()
    {
        $this->expectException(DataTransferObjectError::class);

        new NullIsAllowedOnlyIfExplicitlySpecified(['foo' => null]);
    }

    /** @test */
    public function unknown_properties_throw_an_error()
    {
        $this->expectException(DataTransferObjectError::class);

        new UnknownPropertiesThrowAnError(['bar' => null]);
    }

    /** @test */
    public function unknown_properties_show_a_comprehensive_error_message()
    {
        try {
            new UnknownPropertiesShowAComprehensiveErrorMessage(['foo' => null, 'bar' => null]);
        } catch (DataTransferObjectError $error) {
            $this->assertContains('`foo`', $error->getMessage());
            $this->assertContains('`bar`', $error->getMessage());
        }
    }

    /** @test */
    public function only_returns_filtered_properties()
    {
        $valueObject = new OnlyReturnsFilteredProperties(['foo' => 1, 'bar' => 2]);

        $this->assertEquals(['foo' => 1], $valueObject->only('foo')->toArray());
    }

    /** @test */
    public function except_returns_filtered_properties()
    {
        $valueObject = new ExceptReturnsFilteredProperties(['foo' => 1, 'bar' => 2]);

        $this->assertEquals(['foo' => 1], $valueObject->except('bar')->toArray());
    }

    /** @test */
    public function all_returns_all_properties()
    {
        $valueObject = new AllReturnsAllProperties(['foo' => 1, 'bar' => 2]);

        $this->assertEquals(['foo' => 1, 'bar' => 2], $valueObject->all());
    }

    /** @test */
    public function mixed_is_supported()
    {
        new MixedIsSupported(['foo' => 'abc']);

        new MixedIsSupported(['foo' => 1]);

        $this->markTestSucceeded();
    }

    /** @test */
    public function float_is_supported()
    {
        new FloatIsSupported(['foo' => 5.1]);

        $this->markTestSucceeded();
    }

    /** @test */
    public function classes_are_supported()
    {
        new ClassesAreSupported(['foo' => new DummyClass()]);

        $this->markTestSucceeded();

        $this->expectException(DataTransferObjectError::class);

        new ClassesAreSupported(['foo' => new OtherClass()]);
    }

    /** @test */
    public function generic_collections_are_supported()
    {
        new GenericCollectionsAreSupported(['foo' => [new DummyClass()]]);

        $this->markTestSucceeded();

        $this->expectException(DataTransferObjectError::class);

        new GenericCollectionsAreSupported(['foo' => [new OtherClass()]]);
    }

    /** @test */
    public function an_exception_is_thrown_for_a_generic_collection_of_null()
    {
        $this->expectException(DataTransferObjectError::class);

        new AnExceptionIsThrownForAGenericCollectionOfNull(['foo' => [null]]);
    }

    /** @test */
    public function an_exception_is_thrown_when_property_was_not_initialised()
    {
        $this->expectException(DataTransferObjectError::class);

        new AnExceptionIsThrownWhenPropertyWasNotInitialised([]);
    }

    /** @test */
    public function empty_type_declaration_allows_everything()
    {
        new EmptyTypeDeclarationAllowsEverything(['foo' => new DummyClass()]);

        new EmptyTypeDeclarationAllowsEverything(['foo' => null]);

        new EmptyTypeDeclarationAllowsEverything(['foo' => null]);

        new EmptyTypeDeclarationAllowsEverything(['foo' => 1]);

        $this->markTestSucceeded();
    }

    /** @test */
    public function nested_dtos_are_automatically_cast_from_arrays_to_objects()
    {
        $data = [
            'name' => 'parent',
            'child' => [
                'name' => 'child',
            ],
        ];

        $object = new NestedParent($data);

        $this->assertInstanceOf(NestedChild::class, $object->child);
        $this->assertEquals('parent', $object->name);
        $this->assertEquals('child', $object->child->name);
    }

    /** @test */
    public function nested_dtos_are_recursive_cast_from_object_to_array_when_to_array()
    {
        $data = [
            'name' => 'parent',
            'child' => [
                'name' => 'child',
            ],
        ];

        $object = new NestedParent($data);

        $this->assertEquals(['name' => 'child'], $object->toArray()['child']);

        $valueObject = new NestedDtosAreRecursiveCastFromObjectTAarrayWhenToArray(['childs' => [new NestedChild(['name' => 'child'])]]);

        $this->assertEquals(['name' => 'child'], $valueObject->toArray()['childs'][0]);
    }

    /** @test */
    public function nested_array_dtos_are_automatically_cast_to_arrays_of_dtos()
    {
        $data = [
            'name' => 'parent',
            'children' => [
                ['name' => 'child'],
            ],
        ];

        $object = new NestedParentOfMany($data);

        $this->assertNotEmpty($object->children);
        $this->assertInstanceOf(NestedChild::class, $object->children[0]);
        $this->assertEquals('parent', $object->name);
        $this->assertEquals('child', $object->children[0]->name);
    }

    /** @test */
    public function nested_array_dtos_are_recursive_cast_to_arrays_of_dtos()
    {
        $data = [
            'children' => [
                [
                    'name' => 'child',
                    'children' => [
                        ['name' => 'grandchild'],
                    ],
                ],
            ],
        ];

        $object = new NestedArrayDtosAreRecursiveCastToArraysOfDtos($data);

        $this->assertEquals(['name' => 'grandchild'], $object->toArray()['children'][0]['children'][0]);
    }

    /** @test */
    public function nested_array_dtos_cannot_cast_with_null()
    {
        $this->expectException(DataTransferObjectError::class);

        new NestedParentOfMany([
            'name' => 'parent',
        ]);
    }

    /** @test */
    public function nested_array_dtos_can_be_nullable()
    {
        $object = new NestedArrayDtosCanBeNullable(['children' => null]);

        $this->assertNull($object->children);
    }

    /** @test */
    public function empty_dto_objects_can_be_cast_using_arrays()
    {
        $object = new EmptyDtoObjectsCanBeCastUsingArrays(['child' => []]);

        $this->assertInstanceOf(EmptyChild::class, $object->child);
    }
}
