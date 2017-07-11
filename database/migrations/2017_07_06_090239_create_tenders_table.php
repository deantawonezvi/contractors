<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenders', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->unsignedInteger('tender_type_id');
            $table->foreign('tender_type_id')->references('id')->on('tender_types');

            $table->unsignedInteger('organisation_id');
            $table->foreign('organisation_id')->references('id')->on('organisations');

            $table->unsignedInteger('business_type_id');
            $table->foreign('business_type_id')->references('id')->on('business_types');

            $table->string('description');

            $table->text('instructions');

            $table->string('status')->default('pending');


            $table->timestamp('published_at')->nullable();

            $table->timestamp('closing_at')->nullable();
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
        Schema::dropIfExists('tenders');
    }
}
