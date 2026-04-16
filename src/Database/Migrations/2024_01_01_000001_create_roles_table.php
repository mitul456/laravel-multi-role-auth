<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('guard_name')->default('web');
            $table->text('description')->nullable();
            $table->integer('priority')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->index('guard_name');
            $table->index('priority');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};