<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1458246841_addVisitsToSong
    extends Migration
{

    public function up()
    {
        $this->addColumn('songs', [
            'visits' => ['type' => 'char']

        ]);
    }

    public function down()
    {
        $this->dropColumn('songs', ['visits']);
    }
    
}