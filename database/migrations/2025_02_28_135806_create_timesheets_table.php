<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/{timestamp}_create_timesheets_table.php

    public function up()
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->date('date');
            $table->integer('hours');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relation to User
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Relation to Project
            $table->timestamps();
        });
    }

};
