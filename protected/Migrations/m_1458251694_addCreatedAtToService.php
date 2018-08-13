<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1458251694_addCreatedAtToService
    extends Migration
{

    public function up()
    {
        $this->addColumn('service', [
            'created_at' => ['type' => 'string'],

        ]);
    }

    public function down()
    {
        $this->dropColumn('service', ['created_at']);
    }


}