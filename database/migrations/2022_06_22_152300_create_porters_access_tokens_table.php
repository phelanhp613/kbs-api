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
        Schema::create('porters_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('access_token', 255);
            $table->string('refresh_token', 255);
            $table->dateTime('access_token_expires_at')->nullable();
            $table->dateTime('refresh_token_expires_at')->nullable();
            $table->integer('inserted_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->timestamps();

            $table->index('user_id');
            $table->index('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('porters_access_tokens');
    }
};
