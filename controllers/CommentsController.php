<?php

namespace app\controllers;

use app\models\Comments;
use app\models\Ideas;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CommentsController extends Controller
{


    public function actionDeleteComment($id, $bool)
    {
        $model = Comments::find()->where(['id_comments' => $id])->one();
        $ideasModel = Ideas::find()->where(['id_ideas' => $model->ideas_id])->one();
        if (Yii::$app->user->id == $model->users_id) {
            $model->delete();
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->redirect(['/ideas/index']);
    }

    /**
     * Displays DeleteCommentForm
     *
     * @return string array
     */
}