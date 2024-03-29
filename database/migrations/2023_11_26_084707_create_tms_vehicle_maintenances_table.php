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
        Schema::create('tms_vehicle_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_vehicle_id');
            $table->string('name');
            $table->string('vendor');
            $table->date('planned_at');
            $table->string('planned_kilometers');
            $table->string('planned_cost');
            $table->date('realized_at')->nullable();
            $table->string('realized_kilometers')->nullable();
            $table->string('realized_cost')->nullable();
            $table->string('context_type');
            $table->string('status');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('tms_vehicle_maintenances');
    }
};
