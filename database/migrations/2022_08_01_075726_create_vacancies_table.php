<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacanciesTable extends Migration
{
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->string('job_position')->nullable();
            $table->string('job_description')->nullable();
            $table->string('job_requirements')->nullable();
            $table->date('deadline')->nullable();
            $table->foreignId('admin_id')->constrained('administrators')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacancies');
    }
}
