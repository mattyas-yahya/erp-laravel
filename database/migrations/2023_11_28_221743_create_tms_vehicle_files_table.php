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
        Schema::create('tms_vehicle_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tms_vehicle_id');
            $table->string('file')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->date('expired_at')->nullable();
            $table->string('remaining_time')->nullable();
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('tms_vehicle_files');
    }
};
