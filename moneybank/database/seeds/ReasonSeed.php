<?php

use Illuminate\Database\Seeder;

class ReasonSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Reason::create([
            "name"=>"З"
        ]);
    }
}
