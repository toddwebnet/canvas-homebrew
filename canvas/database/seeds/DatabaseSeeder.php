<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("
            insert into families
            (
            name, address, city, state, zipcode, created_at, updated_at
            )
            values
            (
            'The Todd Family',
            '20514 Rainstone Ct',
            'Katy', 'TX', '77449',
            now(), now()

            )
        ");

        /**
         * $table->unsignedBigInteger('family_id');
         * $table->string('first_name');
         * $table->string('last_name');
         * $table->string('school');
         * $table->string('grade');
         */
    }
}
