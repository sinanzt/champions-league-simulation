<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('simulation_id');
            $table->tinyInteger('week')->default(1);
            $table->unsignedBigInteger('host_fc_id');
            $table->integer('host_fc_goals')->default(0);
            $table->unsignedBigInteger('guest_fc_id');
            $table->integer('guest_fc_goals')->default(0);
            $table->dateTime('played_at')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('simulation_id')->references('id')->on('simulations');
            $table->foreign('host_fc_id')->references('id')->on('teams');
            $table->foreign('guest_fc_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
