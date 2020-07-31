<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('game');
            $table->string('uid');
            $table->string('rarity');
            $table->string('title');
            $table->text('image');
            $table->double('float', 9, 8);

            $table->unsignedInteger('price');
            $table->unsignedInteger('steam_price');

            $table->timestamp('locked_to')->nullable();

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
        Schema::dropIfExists('items');
    }
}
