<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillOfQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_of_quantities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file_name');
            $table->string('file');
            $table->unsignedInteger('sub_contractor_id');
            $table->foreign('sub_contractor_id')->references('id')->on('sub_contractors');
            $table->unsignedInteger('tender_id');
            $table->foreign('tender_id')->references('id')->on('tenders');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('bill_of_quantities');
    }
}
