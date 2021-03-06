<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        /** @var Category $category */
        factory(Category::class, 1)->create();
        $categories = Category::all();
        $this->assertCount(1, $categories);
        $categoryKey = array_keys($categories->first()->getAttributes());
        $this->assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'description',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at'
            ],
            $categoryKey);
    }

    public function testCreate()
    {
        /** @var Category $category */
        $category = Category::create([
            'name' => 'test_category',
            'description' => 'test_description',
            'is_active' => false,
        ]);
        $category->refresh();

        $this->assertEquals('test_category', $category->name);
        $this->assertNotNull($category->description);
        $this->assertFalse((bool)$category->is_active);

        /** @var Category $category */
        $category = Category::create([
            'name' => 'test_category_2',
        ]);
        $category->refresh();

        $this->assertNull($category->description);
        $this->assertTrue((bool)$category->is_active);
    }


    public function testUpdate()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create([
            'description' => 'test_description',
        ])->first();
        $category->update([
            'description' => 'test_description_updated',
            'is_active' => false,
        ]);
        $this->assertEquals('test_description_updated', $category->description);
        $this->isFalse((bool)$category->is_active);
    }

    public function testDelete()
    {
        /** @var Category $category */
        $category = Category::create([
            'name' => 'test_category',
            'description' => 'test_description',
            'is_active' => true,
        ]);
        $category->delete();
        $this->assertSoftDeleted($category);
    }


}
