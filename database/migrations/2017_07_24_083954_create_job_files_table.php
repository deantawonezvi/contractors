<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('status')->default('pending');
            $table->unsignedInteger('tender_id');
            $table->foreign('tender_id')->references('id')->on('tenders')->onDelete('cascade');
            $table->string('file');
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
        Schema::dropIfExists('job_files');
    }
}
