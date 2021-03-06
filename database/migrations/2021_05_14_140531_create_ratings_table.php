<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->decimal('landlord')->default(0);
            $table->decimal('premise')->default(0);
            $table->decimal('area')->default(0);
            $table->decimal('transport')->default(0);
            $table->decimal('noise')->default(0);
            $table->decimal('overall')->default(0);
            $table->foreignId('review_id')->constrained();
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
        Schema::dropIfExists('ratings');
    }
}
