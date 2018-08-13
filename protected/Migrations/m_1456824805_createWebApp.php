<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1456824805_createWebApp
    extends Migration
{

    public function up()
    {
        if (!$this->existsTable('artists')) {
            $this->createTable('artists',
                [
                    'name' => ['type' => 'string']
                ]);
        }
        if (!$this->existsTable('songs')) {
            $this->createTable('songs',
                [
                    'title' => ['type' => 'string'],
                    'text' => ['type' => 'text'],
                    '__artist_id' => ['type' => 'link']
                ],
                [
                    'song' => ['columns' => ['__artist_id']]
                ]
                );
        }

    }

    public function down()
    {
        $this->dropTable('artists');
        $this->dropTable('songs');
    }
    
}