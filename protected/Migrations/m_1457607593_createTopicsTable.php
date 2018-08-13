<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1457607593_createTopicsTable
    extends Migration
{

    public function up()
    {
        $this->createTable('news_topics', [
            'title' => ['type'=>'string']
        ], [

        ], [
            'tree'
        ]);
    }

    public function down()
    {
        $this->dropTable('news_topics');
    }
    
}