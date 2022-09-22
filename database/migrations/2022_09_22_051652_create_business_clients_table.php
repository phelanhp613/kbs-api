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
        Schema::create('business_clients', function (Blueprint $table) {
            $table->id();
            $table->string('inquiry_type');
            $table->string('company_name');
            $table->string('company_name_furi');
            $table->string('representiave_name')->nullable();
            $table->string('representative_name_furi')->nullable();
            $table->string('client_pic_name');
            $table->string('department_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('inquiry')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('business_clients');
    }
};
