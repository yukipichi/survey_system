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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 200)->nullable(false);
            $table->tinyInteger('gender')->nullable(false)->comment('1: 男性, 2: 女性');
            $table->integer('age_id')->nullable(false);
            $table->string('email', 255)->nullable(false);
            $table->tinyInteger('is_send_email')->nullable(false)->default(1)->comment('1:送信許可, 0:送信不可');
            $table->text('feedback')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
