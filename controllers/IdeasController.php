<?php


namespace app\controllers;

use app\models\Ideas;
use app\models\IdeasForm;
use app\models\ImagesForm;
use app\models\SearchIdeas;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\imagine\Image;
use app\models\Images;
use app\models\ChangeIdeasInfoForm;

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
        $image_model = new ImagesForm();
        $images = $model->getImages();
        $carousel = [];
        foreach($images as $image) {
            $nimage = Yii::getAlias('@app/web/images/' . $image->images_name);
            Image::resize($nimage, 1200, 400)
                ->save(Yii::getAlias('@app/web/images/' . $model->ideas_name . '.' . $image->images_name), ['quality' => 80]);
            $carousel[] = [
                'content' => Html::img('@web/images/' . $model->ideas_name . '.' .$image->images_name, [
                    'width' => '1200px',
                    'height' => '400px'
                ]),
                //'caption'
            ];
        };
        $nmodel = new ChangeIdeasInfoForm();
        $nmodel->short = $model->info_short;
        $nmodel->long = $model->info_long;
        if ($nmodel->load(Yii::$app->request->post())) {
            $model->info_short = $nmodel->short;
            $model->info_long = $nmodel->long;
            $model->save();
        }
        if ($image_model->load(Yii::$app->request->post())) {
            $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            //$image_model->imageFile->name = $model->ideas_name . $image_model->imageFile->name;
            $idea_image = new Images();
            $idea_image->ideas_id = $id;
            $idea_image->images_name = $model->ideas_name . $image_model->imageFile->baseName . '.jpg';
            $image_model->imageFile->name = $idea_image->images_name;
            //var_dump($image_model);
            //$image_model->upload();
            $idea_image->save(false);
            $image_model->imageFile->saveAs('images/' . $image_model->imageFile->baseName . '.jpg');
            return $this->redirect('idea?id='.strval($id));
        }
        return $this->render('idea',[
            'model' => $model,
            'nmodel' => $nmodel,
            'carousel' => $carousel,
            'image_model' => $image_model,
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