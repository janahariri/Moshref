<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->id()->unique();
            $table->timestamps();
            $table->datetime('submit_datetime');
            $table->unsignedBigInteger('batch_name');
            $table->string('order_status');
            $table->unsignedBigInteger('fieldsupervisor_id');
            $table->unsignedBigInteger('techsupervisor_id');
            $table->integer('cmap_label');
            $table->integer('office_number');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
