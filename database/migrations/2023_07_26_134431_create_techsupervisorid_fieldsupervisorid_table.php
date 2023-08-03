<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechsupervisoridFieldsupervisoridTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('techsupervisorid_fieldsupervisorid', function (Blueprint $table) {
            $table->id()->unique();
            $table->timestamps();
            $table->unsignedBigInteger('techsupervisor_id');
            $table->unsignedBigInteger('fieldsupervisor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('techsupervisorid_fieldsupervisorid');
    }
}
