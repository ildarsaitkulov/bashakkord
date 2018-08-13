<?php

namespace App\Models;

use T4\Orm\Model;
use T4\Core\Exception;

class Service extends Model
{
    static protected $schema = [
        'table'   => 'service',
        'columns' => [
            'title'      => ['type' => 'string'],
            'text'       => ['type' => 'text'],
            'artist'     => ['type' => 'string'],
            'customer'   => ['type' => 'string'],
            'created_at' => ['type' => 'string'],
        ]
    ];

    public function validateTitle($value)
    {
        if (empty($value)) {
            throw new Exception('Йырҙың исемен яҙырға оноттоғоҙ');
        }
        return true;
    }

    public function validateText($value)
    {
        if (empty($value)) {
            throw new Exception('Йырҙың һүҙҙәрен яҙырға оноттоғоҙ');
        }
        return true;
    }

    public function validateArtist($value)
    {
        if (empty($value)) {
            throw new Exception('Йырҙың башҡарыусыһын яҙырғаоноттоғоҙ');
        }
        return true;
    }

    public function beforeSave()
    {
        if ($this->isNew()) {
            $this->created_at = date('Y-m-d H:i:s', time());
        }
        return true;
    }
}
