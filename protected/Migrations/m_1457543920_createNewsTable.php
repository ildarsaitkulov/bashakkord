<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1457543920_createNewsTable
    extends Migration
{

    public function up()
    {
        $this->createTable('news',
            [
                'title' => ['type' => 'string', 'length' => 1024],
                'lead' => ['type' => 'text'],
                'text' => ['type' => 'text'],
                'published' => ['type' => 'date'],
                'image' => ['type' => 'string'],
                '__topic_id' => ['type' => 'link'],
            ], [
                'topic' => ['columns' => ['__topic_id']]
            ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }

}