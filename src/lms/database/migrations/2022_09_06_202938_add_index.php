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
        DB::statement('ALTER TABLE question_translations ADD FULLTEXT search(content)');
        DB::statement('ALTER TABLE test_translations ADD FULLTEXT search(name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE question_translations DROP INDEX search');
        DB::statement('ALTER TABLE test_translations DROP INDEX search');
    }
};
