<?php

namespace app\controllers;


use app\models\Ideas;
use app\models\ImageForm;
use kartik\select2\Select2;
use Yii;
use yii\filters\AccessControl;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use app\models\Projects;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use app\models\SearchProjects;
use app\models\Options;
use app\models\SearchOptions;
use app\models\GlobalSearchForm;
use app\models\Search;
use app\models\RequestIds;
use app\models\RequestIdsForm;
use app\models\SingUpForm;
use app\models\User;
use yii\console\widgets\Table;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
        $ideas = Ideas::find()->all();
        $ideas =  array_slice($ideas, -5);
        return $this->render('index', [
            'ideas' => $ideas,
        ]);
    }

    /**
     * Displays global-search.
     *
     * @return string
     */

    public function actionGlobalSearch()
    {
        $model = new GlobalSearchForm();
        return $this->render('global-search', [
            'model' => $model,
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
        $model->load(Yii::$app->request->getParam('term'), '%_');
        $target = $model->target;
        var_dump($target);
        $projects = Projects::find()
            ->joinWith('options')
            ->where(['name' => $target])
            ->orWhere(['info' => $target])
            ->orWhere(['options_name' => $target])
            ->orWhere(['options_value' => $target]);

        $options = Options::find()
            ->joinWith('projects')
            ->where(['options_name' => $target])
            ->orWhere(['options_value' => $target])
            ->orWhere(['name' => $target])
            ->orWhere(['info' => $target]);

        $searchModel = new Search();
        $dataProvider = $searchModel->search(Yii::$app->request->get(),$target);

        $id = ArrayHelper::map($projects->all(),'id', 'id');
        $name = ArrayHelper::map($projects->all(),'name', 'name');
        $info = ArrayHelper::map($projects->all(),'info', 'info');
        $options_name = ArrayHelper::map($options->all(),'options_name', 'options_name');
        $options_value = ArrayHelper::map($options->all(),'options_value', 'options_value');
        return $this->render('search-results',[
            'dataProvider'=> $dataProvider,
            'searchModel' => $searchModel,
            'options_name' => $options_name,
            'options_value' => $options_value,
            'name' => $name,
            'info' => $info,
            'id' => $id,
        ]);
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
