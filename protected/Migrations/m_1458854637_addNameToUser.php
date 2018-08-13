<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1458854637_addNameToUser
    extends Migration
{

    public function up()
    {
        $this->addColumn('__users', [
            'firstName' => ['type' => 'string', 'length' => 50],
        ]);
        $this->addColumn('__users', [
            'lastName'  => ['type' => 'string', 'length' => 50],
        ]);
    }

    public function down()
    {
        $this->dropColumn('__users', ['firstName']);
        $this->dropColumn('__users', ['lastName']);
    }

}