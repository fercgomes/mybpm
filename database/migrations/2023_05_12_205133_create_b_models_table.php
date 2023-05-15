<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b_models', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string("name");
            $table->unsignedBigInteger('owner_id');
            $table->longText("content");

            $table->foreign('owner_id')->references('id')->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_models');
    }
};