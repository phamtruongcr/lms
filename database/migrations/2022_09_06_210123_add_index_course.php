<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE course_translations ADD FULLTEXT search(name)');
        DB::statement('ALTER TABLE chapter_translations ADD FULLTEXT search(name)');
        DB::statement('ALTER TABLE lesson_translations ADD FULLTEXT search(name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE course_translations DROP INDEX search');
        DB::statement('ALTER TABLE chapter_translations DROP INDEX search');
        DB::statement('ALTER TABLE lesson_translations DROP INDEX search');
    }
};
