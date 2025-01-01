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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('post_category_id')->unsigned();
            $table->foreign('post_category_id')->references('id')->on('post_categories')->onUpdate('cascade');
            $table->enum('i_am_hard', ['yes', 'no'])->default('no');
            $table->longText('location');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status', ['1', '0'])->default('0')->comment('1 = Active, 0 = Inactive');
            $table->longText('description')->nullable();
            $table->timestamp('report_date')->nullable();
            $table->string('district')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
