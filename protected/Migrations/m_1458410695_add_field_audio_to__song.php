<?php

namespace App\Migrations;

use T4\Orm\Migration;

class m_1458410695_add_field_audio_to__song
    extends Migration
{

    public function up()
    {
        $this->addColumn('songs', [
            'audio' => ['type' => 'string'],
        ]);
    }

    public function down()
    {
        $this->dropColumn('songs', ['audio']);
    }

}