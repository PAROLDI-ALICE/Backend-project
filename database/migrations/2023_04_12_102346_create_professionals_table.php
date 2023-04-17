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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('email')->unique();
            $table->string('phoneNumber');
            $table->string('password');
            $table->text('profilePicture')->nullable();
            $table->string('profession');
            $table->string('city');
            $table->integer('experienceYears');
            $table->text('experienceDetails');
            $table->text('description')->nullable();
            $table->text('skills');
            $table->float('price');
            $table->text('diplomas');
            $table->text('languages');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};