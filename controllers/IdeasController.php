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
        $creations_day = ArrayHelper::map($model,'creations_day', 'creations_day');
        $creations_month = ArrayHelper::map($model,'creations_month', 'creations_month');
        $creations_year = ArrayHelper::map($model,'creations_year', 'creations_year');
        $model = new SearchIdeas();
        $model->load(Yii::$app->request->get());
        return $this->render('ideas',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_ideas' => $id_ideas,
            'ideas_name' => $ideas_name,
            'info_short' => $info_short,
            'creations_day' => $creations_day,
            'creations_month' => $creations_month,
            'creations_year' => $creations_year,
        ]);
    }

    /**
     * Displays idea
     *
     * @return string
     */

    public function actionIdea($id)
    {
        $model = Ideas::find()->where(['id_ideas' => $id])->one();
        return $this->render('idea',[
            'model' => $model,
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
        if ($image_model->load(Yii::$app->request->post()) && $image_model->validate())
        {
            $model = new Ideas();
            //$image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            //$model->images_name = $image_model->imageFile->name;
            $model->ideas_name = $image_model->ideas_name;
            $model->info_short = $image_model->info_short;
            $model->info_long = $image_model->info_long;
            $model->creations_day = date('d');
            $model->creations_month = date('M');
            $model->creations_year = date('y');
            $model->creators_id = Yii::$app->user->id;
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

    /**
     * Displays DeleteProjectForm
     *
     * @return string
     */

    public function actionDeleteIdea($id)
    {
        $model = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($model != null) {
            $model->delete();
        }
        return $this->redirect('ideas');
    }
}