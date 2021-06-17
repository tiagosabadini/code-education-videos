<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->category = new Category();
    }

    /**
     * EXECUTAR TESTES
     * Executar todos os testes vendor/bin/phpunit
     * Executar em uma classe vendor/bin/phpunit /test/Unit/NomedaClasse.php
     * Executar um método de um arquivo vendor/bin/phpunit --filter nomeDoMetodo test/Unit/NomeDaClasse.php
     * Executar um método de uma classe vendor/bin/phpunit --filter test/Unit/NomeDaClasse::nomeDoMetodo
     */




    function testFillableType()
    {
        $fillable = ['name', 'description', 'is_active'];
        $this->assertEquals($fillable, $this->category->getFillable());
    }

    function testIfUseTraits()
    {
        $useClassesReferences = [SoftDeletes::class, Uuid::class];
        $useClasses = array_keys(class_uses($this->category));
        $this->assertEquals($useClassesReferences, $useClasses);
    }

    function testIcrementingFalse()
    {
        $this->assertFalse($this->category->getIncrementing());
    }

}
