<?php

namespace app\controllers;

use app\models\Tags;
use yii\web\Controller;

class TagsController extends Controller
{
    /**
     * Displays index
     *
     * @return string
     */

    public function actionIndex()
    {
        $tags = Tags::find()->select('tag')->orderBy('id_tags')->distinct()->all();
        return $this->render('index', [
            'tags' => $tags,
        ]);
    }
}