<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('identifier',255);
            $table->string('name',255);
            $table->string('picture',355);
            $table->unsignedTinyInteger('status');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('media_id')->constrained('medias');
            $table->foreignId('authorization_id')->constrained('authorizations');
            $table->foreignId('responder_id')->constrained('responders');
            $table->timestamps();
            $table->date('end_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
