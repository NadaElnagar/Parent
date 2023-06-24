<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataProviderXTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_provider_x', function (Blueprint $table) {
            $table->id();
            $table->double('parentAmount');
            $table->string('currency');
            $table->string('parentEmail');
            $table->integer('statusCode');
            $table->string('registerationDate');
            $table->string('parentIdentification');
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
        Schema::dropIfExists('data_provider_x');
    }
}
