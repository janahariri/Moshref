<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTechFieldsLookupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tech_fields_lookup', function (Blueprint $table) {
            $table->id()->unique();
            $table->unsignedBigInteger('techsupervisor_id');
            $table->unsignedBigInteger('fieldsupervisor_id');
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
        Schema::dropIfExists('tech_fieldsu_lookup');
    }
}
