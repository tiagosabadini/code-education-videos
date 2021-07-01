<?php

use Illuminate\Database\Seeder;

class CastMemberSeeder extends Seeder
{
    public function run()
    {
        return factory(\App\Models\CastMember::class, 50)->create();
    }
}
