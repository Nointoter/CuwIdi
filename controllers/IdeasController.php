<?php


namespace app\controllers;

use app\models\AddTagForm;
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
use app\models\ChangeIdeaNameForm;
use app\models\Tags;


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
            Image::resize($nimage, 1400, 400)
                ->save(Yii::getAlias('@app/web/images/' . $model->ideas_name . '.' . $image->images_name), ['quality' => 80]);
            $carousel[] = [
                'content' => Html::img('@web/images/' . $model->ideas_name . '.' .$image->images_name, [
                    'width' => '1400px',
                    'height' => '400px'
                ]),
            ];
        };
        $ideasModel = new IdeasForm();
        $ideasModel->ideas_name = $model->info_short;
        $ideasModel->info_short = $model->info_short;
        $ideasModel->info_long = $model->info_long;
        if ($ideasModel->load(Yii::$app->request->post())) {
            $model->ideas_name = $ideasModel->ideas_name;
            $model->info_short = $ideasModel->info_short;
            $model->info_long = $ideasModel->info_long;
            $model->save();
        }
        $tagModel = new AddTagForm();
        if ($tagModel->load(Yii::$app->request->post())) {
            $tag = new Tags();
            $tag->ideas_id = $id;
            if ($tagModel->tag != '') {
                $tag->tag = $tagModel->tag;
                $tag->save(false);
            }
        }
        if ($image_model->load(Yii::$app->request->post())) {
            $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            if ($image_model->imageFile != Null)
            {
                $idea_image = new Images();
                $idea_image->ideas_id = $id;
                $idea_image->images_name = $model->ideas_name . $image_model->imageFile->baseName . '.jpg';
                $image_model->imageFile->name = $idea_image->images_name;
                $idea_image->save(false);
                $image_model->imageFile->saveAs('images/' . $image_model->imageFile->baseName . '.jpg');
                return $this->redirect('idea?id='.strval($id));
            }
        }
        return $this->render('idea',[
            'model' => $model,
            'ideasModel' => $ideasModel,
            'tagModel' => $tagModel,
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
            $model->ideas_name = $image_model->ideas_name;
            $model->info_short = $image_model->info_short;
            $model->info_long = $image_model->info_long;
            $model->creations_day = date('d');
            $model->creations_month = date('M');
            $model->creations_year = date('y');
            $model->creators_id = Yii::$app->user->id;
            $model->save(false);
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
     * Displays DeleteIdeaForm
     *
     * @return string
     */

    public function actionDeleteIdea($id)
    {
        $model = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($model != null) {
            if (Yii::$app->user->id != $model->creators_id){
                return $this->redirect('idea?id='.strval($id));
            } else {
                $model->delete();
            }
        }
        return $this->redirect('ideas');
    }

    /**
     * Displays DeleteIdeaForm
     *
     * @return string
     */

    public function actionDeleteIdeaImages($id)
    {
        $model = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($model != null) {
            if (Yii::$app->user->id != $model->creators_id){
                return $this->redirect('idea?id='.strval($id));
            } else {
                $model->delete();
            }
        }
        return $this->redirect('ideas');
    }
}