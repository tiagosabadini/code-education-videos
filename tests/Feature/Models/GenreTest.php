<?php

namespace Tests\Feature\Models;

use App\Models\Genre;
use App\Models\Traits\Uuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenreTest extends TestCase
{
    use DatabaseMigrations;

    public function testList()
    {
        factory(Genre::class, 2)->create();

        $genres = Genre::all();
        $this->assertCount(2, $genres);

        $genreKeys = array_keys($genres->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            'id',
            'name',
            'is_active',
            'created_at',
            'updated_at',
            'deleted_at'
        ], $genreKeys);
    }

    public function testCreate()
    {
        $genre = Genre::create([
            'name' => 'genre_test',
            'is_active' => true,
        ]);

        $this->assertEquals('genre_test', $genre->name);
        $this->assertTrue((bool)$genre->is_active);
        $this->assertRegExp('^-?\d{1,2}\.\d{6,}\s*,\s*-?\d{1,2}\.\d{6,}$', $genre->id);
    }
}
