<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1458859764_addCustomerToService
    extends Migration
{

    public function up()
    {
        $this->addColumn('service', [
            'customer' => ['type' => 'string'],

        ]);
    }

    public function down()
    {
        $this->dropColumn('service', ['customer']);
    }
    
}