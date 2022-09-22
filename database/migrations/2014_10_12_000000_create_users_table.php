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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->timestamps();
        });

        $user = \App\Models\User::query()->insert([
            [
                'name'              => 'Admin Sinh',
                'email'             => 'buinhansinh@gmail.com',
                'password'          => bcrypt('12345678'),
                'created_at'        => now(),
                'updated_at'        => now()
            ],
            [
                'name'              => 'Admin Phuc',
                'email'             => 'phuchp.613@gmail.com',
                'password'          => bcrypt('12345678'),
                'created_at'        => now(),
                'updated_at'        => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
