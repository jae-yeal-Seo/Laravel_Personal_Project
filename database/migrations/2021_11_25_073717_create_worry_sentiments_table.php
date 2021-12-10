<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorrySentimentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worry_sentiments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('neutral');
            $table->double('positive');
            $table->double('negative');
            $table->string('sentiment');
            $table->foreignId('worry_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worry_sentiments');
    }
}
