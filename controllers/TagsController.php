<?php

namespace app\controllers;

use app\models\Ideas;
use app\models\SearchIdeas;
use app\models\Tags;
use app\models\User;
use Yii;
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

    /**
     * Displays tag
     *
     * @param $tag
     * @return string
     */

    public function actionTag($tag)
    {
        $ideasSearch = new SearchIdeas();
        $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), null, null, $tag);
        $allIdeas = Ideas::find()->joinWith('ideas_tags')->where(['tag' => $tag])->all();
        return $this->render('tag', [
            'tag' => $tag,
            'ideasSearch' => $ideasSearch,
            'ideasProvider' => $ideasProvider,
            'allIdeas' => $allIdeas,
        ]);
    }

    /**
     * Displays delete_tag
     *
     * @param $tag
     * @return string
     */

    public function actionDeleteTag($tag, $bool)
    {
        if (!(User::findIdentity(Yii::$app->user->id))->isAdmin()) {
            if ($bool) {
                return $this->redirect('/tags/tag?tag=' . $tag);
            } else {
                return $this->redirect('/tags');
            }
        }
        $tags = Tags::find()->where(['tag' => $tag])->all();
        foreach ($tags as $tag) {
            $tag->delete(false);
        }
        return $this->redirect('/tags');
    }
}