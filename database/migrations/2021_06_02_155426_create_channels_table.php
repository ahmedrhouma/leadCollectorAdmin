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
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('media_id')->constrained('medias')->onDelete('cascade');
            $table->foreignId('authorization_id')->constrained('authorizations')->onDelete('cascade');
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
