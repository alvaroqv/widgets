<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JsonData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jsons_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->boolean('checked')->nullable();
            $table->mediumText('description')->nullable();
            $table->string('interest')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('account')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_name')->nullable();
            $table->string('card_date')->nullable();
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
        Schema::dropIfExists('json_files');
    }
}
