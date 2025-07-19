
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentLabelTable extends Migration
{
    public function up()
    {
Schema::create('label_student', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('label_id')->constrained('labels')->onDelete('cascade');
    $table->timestamps();
});

    }

    public function down()
    {
        Schema::dropIfExists('label_student');
    }
}
