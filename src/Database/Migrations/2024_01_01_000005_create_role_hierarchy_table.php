<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('role_hierarchy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_role_id')->constrained('roles')->onDelete('cascade');
            $table->foreignId('child_role_id')->constrained('roles')->onDelete('cascade');
            $table->integer('level')->default(1);
            $table->timestamps();
            
            $table->unique(['parent_role_id', 'child_role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('role_hierarchy');
    }
};