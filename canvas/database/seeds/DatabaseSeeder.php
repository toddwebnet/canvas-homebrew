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
        $familyId = DB::select('select max(id) as id from families')[0]->id;

        $students = [
            [$familyId, 'Gavin', 'Todd', 'Morton Ranch High', '12'],
            [$familyId, 'Abigail', 'Todd', 'Morton Ranch High', '9'],
            [$familyId, 'Carolyn', 'Todd', 'McDonald Jr High', '8'],
            [$familyId, 'Bethany', 'Todd', 'McDonald Jr High', '6'],
        ];
        foreach ($students as $student) {
            DB::insert("
            insert into students
            (
            family_id, first_name, last_name, school, grade, created_at, updated_at
            )
            values
            (?,?,?,?,?, now(), now())
        ", $student);
        }

        /**
         * $table->unsignedBigInteger('family_id');
         * $table->string('first_name');
         * $table->string('last_name');
         * $table->string('school');
         * $table->string('grade');
         */
    }
}
