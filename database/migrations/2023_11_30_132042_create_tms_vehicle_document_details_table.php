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
        Schema::create('tms_vehicle_detail_document_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_vehicle_detail_document_id');
            $table->string('name');
            $table->string('category');
            $table->string('activity_type');
            $table->integer('quantity');
            $table->decimal('price', 16, 2)->default(0.0);
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
        Schema::dropIfExists('tms_vehicle_document_details');
    }
};
