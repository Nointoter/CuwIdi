<?php

namespace app\controllers;


use app\models\ContactForm;
use app\models\GlobalSearchForm;
use app\models\Ideas;
use app\models\SearchComments;
use app\models\SearchIdeas;
use app\models\SearchUsers;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage
     *
     * @return string
    */

    public function actionIndex()
    {
        $ideas = Ideas::find()->orderBy('id_ideas DESC')->limit(5)->all();

        return $this->render('index', [
            'ideas' => $ideas,
        ]);
    }

    /**
     * Displays search-results.
     *
     * @return string
     */

    public function actionSearchResults()
    {
        $model = new GlobalSearchForm();
        $model->load(Yii::$app->request->get());
        $target = $model->target;

        $ideasModel = new SearchIdeas();
        $ideasProvider = $ideasModel->search(
            Yii::$app->request->get(),
            null,
            $target,
            null
        );
        $usersModel = new SearchUsers();
        $usersProvider = $usersModel->search(
            Yii::$app->request->get(),
            null,
            $target,
            true
        );
        $commentsModel = new SearchComments();
        $commentsProvider = $commentsModel->search(
            Yii::$app->request->get(),
            null,
            null,
            $target
        );

        return $this->render(
            'search-results',
            [
                'target' => $target,
                'ideasProvider'=> $ideasProvider,
                'ideasModel' => $ideasModel,
                'usersProvider'=> $usersProvider,
                'usersModel' => $usersModel,
                'commentsProvider' => $commentsProvider,
                'commentsModel' => $commentsModel,
            ]
        );
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
