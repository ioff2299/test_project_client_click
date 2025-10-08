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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->string('url');
            $table->timestamp('clicked_at')->nullable();
            $table->integer('page_x');
            $table->integer('page_y');
            $table->double('pct_x', 8, 6);
            $table->double('pct_y', 8, 6);
            $table->double('vp_x', 8, 6)->nullable();
            $table->double('vp_y', 8, 6)->nullable();
            $table->string('target')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('viewport_width')->nullable();
            $table->integer('viewport_height')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clicks');
    }
};
