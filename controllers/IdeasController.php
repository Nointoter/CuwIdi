<?php


namespace app\controllers;

use app\models\Ideas;
use app\models\IdeasForm;
use app\models\SearchIdeas;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;

class IdeasController extends Controller
{
    /**
     * Displays ideas
     *
     * @return string
     */
    public function actionIdeas()
    {
        $model = Ideas::find()->all();
        $searchModel = new SearchIdeas();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), NULL);
        $id_ideas = ArrayHelper::map($model,'id_ideas', 'id_ideas');
        $ideas_name = ArrayHelper::map($model,'ideas_name', 'ideas_name');
        $info_short = ArrayHelper::map($model,'info_short', 'info_short');
        return $this->render('ideas',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_ideas' => $id_ideas,
            'ideas_name' => $ideas_name,
            'info_short' => $info_short,
        ]);
    }

    /**
     * Displays AddProjectForm
     *
     * @return string
     */

    public function actionAddIdea($bool)
    {
        $image_model = new IdeasForm();

        if ($image_model->load(Yii::$app->request->post()))
        {
            $model = new Ideas();
            //$image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            //$model->images_name = $image_model->imageFile->name;
            $model->ideas_name = $image_model->ideas_name;
            $model->info_short = $image_model->info_short;
            $model->save(false);
            //$image_model->upload();
            /*if ($bool = strval(true))
                return $this->redirect('project?id=' . strval($model->id));
            else*/
                return $this->redirect('ideas');
        }
        else
        {
            return $this->renderAjax('add-idea',[
                'image_model' => $image_model,
            ]);
        }
    }
}