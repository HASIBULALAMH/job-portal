<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending','reviewed','shortlisted','accepted','rejected') DEFAULT 'pending'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE job_applications MODIFY COLUMN status ENUM('pending','reviewed','accepted','rejected') DEFAULT 'pending'");
    }
};
