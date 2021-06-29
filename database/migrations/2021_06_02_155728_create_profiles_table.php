<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('identifier',255);
            $table->string('username',255);
            $table->string('picture',255);
            $table->string('email',128)->nullable();
            $table->string('phone',64)->nullable();
            $table->tinyInteger('status');
            $table->foreignId('contact_id')->constrained('contacts')->onDelete('cascade');
            $table->foreignId('channel_id')->constrained('channels');
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
        Schema::dropIfExists('profiles');
    }
}
