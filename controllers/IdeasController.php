<?php

namespace app\controllers;

use app\models\AddCommentForm;
use app\models\AddTagForm;
use app\models\Comments;
use app\models\Ideas;
use app\models\IdeasForm;
use app\models\Images;
use app\models\ImagesForm;
use app\models\SearchComments;
use app\models\SearchIdeas;
use app\models\SearchImages;
use app\models\SearchTags;
use app\models\Tags;
use app\models\User;
use Yii;
use yii\helpers\Html;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\UploadedFile;

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
        $allIdeas = Ideas::find()->joinWith('user')->where(['status' => 0])->orderBy('id_ideas')->all();

        $ideasSearch = new SearchIdeas();
        $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), null, $model->ideasSearch, null);

        return $this->render('index', [
            'model' => $model,
            'ideasSearch' => $ideasSearch,
            'ideasProvider' => $ideasProvider,
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
        if (!$model->user->isActive()) {
            $this->redirect('/ideas');
        }
        $imageModel = new ImagesForm();
        $images = $model->images;
        $carousel = [];
        foreach ($images as $image) {
            $newImage = Yii::getAlias('@app/web/images/' . $image->images_name);
            Image::resize($newImage, 1400, 400)
                ->save(
                    Yii::getAlias(
                        '@app/web/images/' . $model->ideas_name . '.' . $image->images_name
                    ),
                    ['quality' => 80]
                );
            $carousel[] = [
                'content' => Html::img('@web/images/' . $model->ideas_name . '.' .$image->images_name, [
                    'width' => '1400px',
                    'height' => '400px'
                ]),
            ];
        };

        $commentsSearch = new SearchComments();
        $commentsProvider = $commentsSearch->search(
            Yii::$app->request->get(),
            null,
            $id
        );

        $ideasModel = new IdeasForm();
        $ideasModelName = new IdeasForm();
        $ideasModelName->ideas_name = $model->ideas_name;
        $ideasModel->info_short = $model->info_short;
        $ideasModel->info_long = $model->info_long;
        if ($ideasModel->load(Yii::$app->request->post()) && $ideasModel->load(Yii::$app->request->post())) {
            $model->ideas_name = $ideasModelName->ideas_name;
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
                $tagModel = new AddTagForm();
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
                $commentModel = new AddCommentForm();
            }
        }
        if ($imageModel->load(Yii::$app->request->post())) {
            $imageModel->imageFile = UploadedFile::getInstance($imageModel, 'imageFile');
            if ($imageModel->imageFile != null) {
                $idea_image = new Images();
                $idea_image->ideas_id = $id;
                $idea_image->images_name = $model->ideas_name . $imageModel->imageFile->baseName . '.jpg';
                $imageModel->imageFile->name = $idea_image->images_name;
                $idea_image->save(false);
                $imageModel->imageFile->saveAs('images/' . $imageModel->imageFile->baseName . '.jpg');
                return $this->redirect('idea?id='.strval($id));
            }
        }
        return $this->render(
            'idea',
            [
                'model' => $model,
                'ideasModelName' => $ideasModelName,
                'ideasModel' => $ideasModel,
                'tagModel' => $tagModel,
                'carousel' => $carousel,
                'imageModel' => $imageModel,
                'commentModel' => $commentModel,
                'commentsProvider' => $commentsProvider,
            ]
        );
    }

    /**
     * Displays AddProjectForm
     *
     * @param $bool
     * @return string
     */

    public function actionAddIdea($bool)
    {
        if (!Yii::$app->user->isGuest) {
            if (!(User::findIdentity(Yii::$app->user->id))->isActive()) {
                return $this->redirect('/site');
            }
        } else {
            return $this->redirect('/site');
        }
        $ideasModel = new IdeasForm();
        if ($ideasModel->load(Yii::$app->request->post()) && $ideasModel->validate()) {
            $model = new Ideas();
            $model->ideas_name = $ideasModel->ideas_name;
            $model->info_short = $ideasModel->info_short;
            $model->info_long = $ideasModel->info_long;
            $model->creations_day = date('d');
            $model->creations_month = date('M');
            $model->creations_year = date('y');
            $model->creators_id = Yii::$app->user->id;
            $model->save(false);

            return $this->redirect('/ideas');
        } else {
            return $this->renderAjax(
                'add-idea',
                [
                    'ideasModel' => $ideasModel,
                ]
            );
        }
    }

    /**
     * @param $id
     * @return array|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteIdea($id)
    {
        if (Yii::$app->user->isGuest || !User::findOne(Yii::$app->user->id)->isActive()) {
            return $this->redirect('/site');
        } else {
            $model = Ideas::find()->where(['id_ideas' => $id])->one();
            if ($model == null
                || (Yii::$app->user->id != $model->creators_id
                && !(User::findIdentity(Yii::$app->user->id))->isAdmin())) {
                return $this->redirect('idea?id=' . strval($id));
            }

            $tags = Tags::find()->where(['ideas_id' => $id])->all();
            $comments = Comments::find()->where(['ideas_id' => $id])->all();
            $images = Images::find()->where(['ideas_id' => $id])->all();
            foreach ($tags as $tag) {
                $tag->delete();
            }
            foreach ($comments as $comment) {
                $comment->delete();
            }
            foreach ($images as $image) {
                $image->delete();
            }

            $model->delete();

            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['success' => true];
            }

            return $this->redirect('index');
        }
    }

    /**
     * Displays DeleteIdeaImagesForm
     *
     * @return string
     */

    public function actionDeleteIdeaImages($id)
    {
        if (!Yii::$app->user->isGuest) {
            if (!(User::findIdentity(Yii::$app->user->id))->isActive()) {
                return $this->redirect('/site');
            }
        } else {
            return $this->redirect('/site');
        }
        $ideasModel = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($ideasModel != null) {
            $user = User::findIdentity(Yii::$app->user->id);
            if (Yii::$app->user->id != $ideasModel->creators_id && !$user->isAdmin()) {
                return $this->redirect('idea?id='.strval($id));
            } else {
                $imagesSearch = new SearchImages();
                $imagesProvider = $imagesSearch->search(Yii::$app->request->get(), $id);
                return $this->render(
                    'delete-idea-images',
                    [
                        'ideasModel' => $ideasModel,
                        'imagesProvider' => $imagesProvider,
                    ]
                );
            }
        }
        return $this->redirect('/ideas');
    }

    /**
     * Displays DeleteIdeaImagesForm
     *
     * @return string
     */

    public function actionDeleteIdeaTags($id)
    {
        if (!Yii::$app->user->isGuest) {
            if (!(User::findIdentity(Yii::$app->user->id))->isActive()) {
                return $this->redirect('/site');
            }
        } else {
            return $this->redirect('/site');
        }
        $ideasModel = Ideas::find()->where(['id_ideas' => $id])->one();
        if ($ideasModel != null) {
            $user = User::findIdentity(Yii::$app->user->id);
            if (Yii::$app->user->id != $ideasModel->creators_id && !$user->isAdmin()) {
                return $this->redirect('idea?id='.strval($id));
            } else {
                $tagsSearch = new SearchTags();
                $tagsProvider = $tagsSearch->search(Yii::$app->request->get(), $id);
                return $this->render(
                    'delete-idea-tags',
                    [
                        'ideasModel' => $ideasModel,
                        'tagsProvider' => $tagsProvider,
                    ]
                );
            }
        }
        return $this->redirect('/ideas');
    }
}