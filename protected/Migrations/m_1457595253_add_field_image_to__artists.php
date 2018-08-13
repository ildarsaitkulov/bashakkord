<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1457595253_add_field_image_to__artists
    extends Migration
{

    public function up()
    {
        $this->addColumn('artists', [
            'image' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('artists', ['image']);
    }


}