<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            
            $table->id();
            $table->string('card_holder_name')->nullable();
            $table->string('card_number');
            $table->string('expiration_year', 4)->nullable();
            $table->string('expiration_month', 2)->nullable();
            $table->tinyInteger('is_assigned')->default(0);
            $table->tinyInteger('status')->default(0);

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
        Schema::dropIfExists('cards');
    }
};
