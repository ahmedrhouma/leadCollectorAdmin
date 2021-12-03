<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class fieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert([
            ["id" => "1", "name" => "first name ", "tag" => "first_name", "format" => "regex=>\/^[\\pL\\s\\-]+$\/u|min=>4", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "2", "name" => "last name", "tag" => "last_name", "format" => "regex=>\/^[\\pL\\s\\-]+$\/u|min=>4", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "3", "name" => "birthday", "tag" => "birthday", "format" => "date", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "4", "name" => "city", "tag" => "city", "format" => "required", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "5", "name" => "country", "tag" => "country", "format" => "required", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "6", "name" => "email", "tag" => "email", "format" => "email", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null],
            ["id" => "7", "name" => "phone", "tag" => "phone", "format" => "phone=>TN", "status" => "1", "account_id" => null, "created_at" => null, "updated_at" => null]
        ]);
    }
}
