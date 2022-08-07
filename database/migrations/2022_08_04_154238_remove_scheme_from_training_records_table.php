<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSchemeFromTrainingRecordsTable extends Migration
{
    public function up()
    {
        Schema::table('training_records', function (Blueprint $table) {
            $table->string('training_certificate')->after('training_id')->nullable();
            $table->string('competence_certificate')->after('training_certificate')->nullable();
            $table->dropColumn('scheme');
            $table->dropForeign(['trainer_id']);
            $table->dropColumn(['trainer_id']);
        });
    }

    public function down()
    {
        Schema::table('training_records', function (Blueprint $table) {
            $table->enum('scheme', ['Operator', 'Pengawas', 'Ahli']);
            $table->dropColumn('training_certificate');
            $table->dropColumn('competence_certificate');
            $table->foreignId('trainer_id')->constrained('trainers')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }
}
