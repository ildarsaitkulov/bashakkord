<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1457091932_createTableService
    extends Migration
{

    public function up()
    {

        if (!$this->existsTable('service')) {
            $this->createTable('service',
                [
                    'title' => ['type' => 'string'],
                    'text' => ['type' => 'text'],
                    'artist' => ['type' => 'string']
                ]
            );
        }
    }

    public function down()
    {
        $this->dropTable('service');

    }
    
}