<?php

namespace App\Models;

use T4\Orm\Model;

class News extends Model
{
    const IMAGE_UPLOAD_PATH = '/public/news/images';
    const IMAGE_PROPERTY = 'image';
    use THasImage;

    static protected $schema = [
        'table' => 'news',
        'columns' => [
            'title' => ['type'=>'string'],
            'published' => ['type'=>'datetime'],
            'image' => ['type'=>'string', 'default'=>''],
            'lead' => ['type'=>'text'],
            'text' => ['type'=>'text'],
        ],
        'relations' => [
            'topic' => ['type'=>self::BELONGS_TO, 'model'=>Topic::class],
        ]
    ];

    public function beforeSave()
    {
        if ($this->isNew()) {
            $this->published = date('Y-m-d H:i:s', time());
        }
        return true;
    }
}
