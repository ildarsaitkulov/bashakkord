<?php

namespace App\Modules\News\Controllers;

use App\Models\News;
use App\Models\Topic;
use T4\Http\E404Exception;
use T4\Mvc\Controller;

class Index extends Controller
{
    const PAGE_SIZE = 5;

    public function actionDefault($page = 1)
    {

        $this->data->itemsCount = News::countAll();
        $this->data->pageSize = self::PAGE_SIZE;
        $this->data->activePage = $page;

        $this->data->items = News::findAll([
            'order' => 'published DESC',
            'offset'=> ($page-1)*self::PAGE_SIZE,
            'limit'=> self::PAGE_SIZE
        ]);
    }

    public function actionOne($id)
    {
        if (empty($this->data->item = News::findByPK($id))) {
            throw new E404Exception('Яңылыҡ табылманы');
        }
    }

    public function actionTopicsAll()
    {
        $this->data->items = Topic::findAll();
    }
    public function actionTopicOne($id)
    {
        $this->data->items = Topic::findByPK($id)->news;
        $this->data->topic = Topic::findByPK($id);
    }
}
