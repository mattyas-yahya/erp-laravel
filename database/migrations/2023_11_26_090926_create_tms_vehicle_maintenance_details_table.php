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
        Schema::create('tms_vehicle_maintenance_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_vehicle_maintenance_detail_id');
            $table->string('name');
            $table->string('part_number');
            $table->string('category');
            $table->string('activity_type');
            $table->string('planned_quantity');
            $table->string('planned_cost');
            $table->string('planned_cost_total');
            $table->string('realized_quantity')->nullable();
            $table->string('realized_cost')->nullable();
            $table->string('realized_cost_total')->nullable();
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
        Schema::dropIfExists('tms_vehicle_maintenance_details');
    }
};
