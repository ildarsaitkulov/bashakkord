<?php

namespace App\Models;

use T4\Orm\Model;

class Topic extends Model
{
    static protected $schema = [
        'table'   => 'news_topics',
        'columns' => [
            'title' => ['type'=>'string'],
        ],
        'relations' => [
            'news' => ['type' => self::HAS_MANY, 'model' => News::class]
        ]
    ];

    static protected $extensions = ['tree'];
}