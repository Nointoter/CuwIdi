<?php


namespace app\controllers;

use app\models\AddCommentForm;
use app\models\AddTagForm;
use app\models\Comments;
use app\models\Ideas;
use app\models\IdeasForm;
use app\models\ImagesForm;
use app\models\SearchComments;
use app\models\SearchIdeas;
use app\models\SearchImages;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\imagine\Image;
use app\models\Images;
use app\models\User;
use app\models\Tags;


class IdeasController extends Controller
{
    /**
     * Displays index
     *
     * @return string
     */

    public function actionIndex()
    {
        $model = new SearchIdeas();
        $model->load(Yii::$app->request->get());
        $allIdeas = new Ideas();
        $searchModel = new SearchIdeas();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), NULL, Null);
        return $this->render('index',[
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'allIdeas' => $allIdeas,
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
        if (($model->getUser())->status) {
            $this->redirect('/ideas');
        }
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

        $searchModel = new SearchComments();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), $id, true, Null);

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
        $commentModel = new AddCommentForm();
        if ($commentModel->load(Yii::$app->request->post())) {
            if ($commentModel->comment != '') {
                $comment = new Comments();
                $comment->ideas_id = $id;
                $comment->users_id = Yii::$app->user->id;
                $comment->comment = $commentModel->comment;
                $comment->save(false);
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
            'commentModel' => $commentModel,
            'carousel' => $carousel,
            'image_model' => $image_model,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays AddProjectForm
     *
     * @return string
     */

    public function actionAddIdea($bool)
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('/site');
        }
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
                return $this->redirect('/ideas');
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

    public function actionDeleteIdea($id, $bool)
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('/site');
        }
        $model = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($model != null) {
            if (Yii::$app->user->id != $model->creators_id){
                return $this->redirect('idea?id='.strval($id));
            } else {
                $model->delete();
            }
        }
        if ($bool) {
            return $this->redirect('index');
        } else {
            return $this->redirect('/users/profile?id='.strval(Yii::$app->user->id));
        }
    }

    /**
     * Displays DeleteIdeaImagesForm
     *
     * @return string
     */

    public function actionDeleteIdeaImages($id)
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('/site');
        }
        $ideasModel = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($ideasModel != null) {
            if (Yii::$app->user->id != $ideasModel->creators_id){
                return $this->redirect('idea?id='.strval($id));
            } else {
                $model = Images::find()->where(['ideas_id' => $id])->all();
                $searchModel = new SearchImages();
                $dataProvider = $searchModel->search(Yii::$app->request->get(), $id);
                $id_ideas_images = ArrayHelper::map($ideasModel,'id_ideas_images', 'id_ideas_images');
                $images_name = ArrayHelper::map($ideasModel,'images_name', 'images_name');
                $ideas_id = ArrayHelper::map($ideasModel,'ideas_id', 'ideas_id');
                return $this->render('delete-idea-images',[
                    'ideasModel' => $ideasModel,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'id_ideas_images' => $id_ideas_images,
                    'images_name' => $images_name,
                    'ideas_id' => $ideas_id,
                ]);
            }
        }
        return $this->redirect('ideas');
    }

}