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
        $allIdeas = Ideas::find()->joinWith('tags')->where(['tag' => $tag])->all();
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

    public function actionDeleteTag($tag, $bool, $tags_id)
    {
        if (!Yii::$app->user->isGuest) {
            if ($tags_id != 0) {
                $intag = Tags::find()->where(['id_tags' => $tags_id])->one();
                $idea = Ideas::find()->where(['id_ideas' => $intag->ideas_id])->one();
                if (Yii::$app->user->id != $idea->creators_id || !(User::findIdentity(Yii::$app->user->id))->isAdmin()) {
                    return $this->redirect('/ideas');
                }
            } elseif (!(User::findIdentity(Yii::$app->user->id))->isAdmin()) {
                if ($tag != null) {
                    if ($bool) {
                        return $this->redirect('/tags/tag?tag=' . $tag);
                    } else {
                        return $this->redirect('/tags');
                    }
                } elseif ($tags_id != null) {
                    if ($bool) {
                        $tag = Tags::find()->where(['id_tags' => $tags_id])->one();
                        return $this->redirect('/ideas/delete-idea-tags?id=' . $tag->ideas_id);
                    } else {
                        return $this->redirect('/ideas');
                    }
                } else {
                    return $this->redirect('/site');
                }

            }
        } else {
            return $this->redirect('site');
        }

        if ($tag != null) {
            $tags = Tags::find()->where(['tag' => $tag])->all();
            foreach ($tags as $tag) {
                $tag->delete();
            }
        }
        if ($tags_id != 0) {
            $tag = Tags::find()->where(['id_tags' => $tags_id])->one();
            $tag->delete();
            return $this->redirect('/ideas/delete-idea-tags?id=' . $idea->id_ideas);
        }
        return $this->redirect('/tags');
    }
}