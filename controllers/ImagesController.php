<?php


namespace app\controllers;


use app\models\Ideas;
use app\models\Images;
use Yii;
use yii\web\Controller;

class ImagesController extends Controller
{
    /**
     * Displays DeleteImagesForm
     *
     * @return string
     */

    public function actionDeleteImage($id)
    {
        $model = Images::find()->where(['id_ideas_images' => $id])->one();
        $ideasModel = Ideas::find()->where(['id_ideas' => $model->ideas_id])->one();
        if (Yii::$app->user->id == $ideasModel->creators_id){
            $model->delete();
            return $this->redirect('/ideas/delete-idea-images?id='.strval($ideasModel->id_ideas));
        }
        return $this->redirect('/ideas/idea?id='.strval($ideasModel->id_ideas));
    }
}