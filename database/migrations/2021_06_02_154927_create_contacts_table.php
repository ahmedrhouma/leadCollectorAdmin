<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_type');
            $table->tinyInteger('gender');
            $table->string('first_name',128);
            $table->string('last_name',128);
            $table->date('birthday')->nullable();
            $table->string('city',128)->nullable();
            $table->char('country',2)->nullable();
            $table->char('language',2)->nullable();
            $table->string('ip_address',64)->nullable();
            $table->string('browser_data',255)->nullable();
            $table->tinyInteger('status');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
