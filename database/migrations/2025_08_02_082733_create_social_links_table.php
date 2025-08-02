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
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['facebook','whatsapp', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'github', 'discord', 'reddit', 'pinterest']);
            $table->string('url')->nullable();
            $table->enum('status', ['1', '0'])->default('0')->comment('1 = Active, 0 = Inactive');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
