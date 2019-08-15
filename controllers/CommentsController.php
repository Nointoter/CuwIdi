<?php

namespace app\controllers;

use app\models\Comments;
use Yii;
use yii\web\Controller;

class CommentsController extends Controller
{
    /**
     * @param $id
     * @param $bool
     * @return array|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteComment($id)
    {
        $model = Comments::find()->where(['id_comments' => $id])->one();

        if (Yii::$app->user->id == $model->users_id) {
            $model->delete();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['success' => true];
        }

        return $this->redirect(['/ideas/index']);
    }
}
