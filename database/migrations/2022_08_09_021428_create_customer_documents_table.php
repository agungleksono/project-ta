<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('customer_documents', function (Blueprint $table) {
            $table->id();
            $table->string('cv')->nullable();
            $table->string('ktp')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('work_experience')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('optional_file')->nullable();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_documents');
    }
}
