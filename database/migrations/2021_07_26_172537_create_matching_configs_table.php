<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage');
            $table->tinyInteger('obligation');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');
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
        Schema::dropIfExists('matching_configs');
    }
}
