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
            $table->string('order_status')->nullable();
            $table->unsignedBigInteger('fieldsupervisor_id')->nullable();
            $table->unsignedBigInteger('techsupervisor_id');
            $table->string('cmap_label');
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
