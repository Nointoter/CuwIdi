<?php


namespace app\controllers;


use app\models\Comments;
use app\models\Ideas;
use Yii;
use yii\web\Controller;

class CommentsController extends Controller
{
    /**
     * Displays DeleteCommentForm
     *
     * @return string
     */

    public function actionDeleteComment($id, $bool)
    {
        $model = Comments::find()->where(['id_comments' => $id])->one();
        $ideasModel = Ideas::find()->where(['id_ideas' => $model->ideas_id])->one();
        if (Yii::$app->user->id == $model->users_id){
            $model->delete();
            if ($bool == '1') {
                return $this->redirect('/ideas/idea?id=' . strval($ideasModel->id_ideas));
            } else {
                return $this->redirect('/users/profile?id=' . strval(Yii::$app->user->id));
            }
        }
        return $this->redirect('idea?id='.strval($ideasModel->id_ideas));
    }
}