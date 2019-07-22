<?php

namespace app\controllers;


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
     * Displays view-projects
     *
     * @return string
     */

    public function actionViewProjects()
    {
        $pmodel = new Projects();
        $gmodel = new GlobalSearchForm();
        $searchModel = new SearchProjects();
        $dataProvider = $searchModel->search(Yii::$app->request->get(),NULL);
        $name = ArrayHelper::map(\app\models\Projects::find()->all(),'name', 'name');
        $id = ArrayHelper::map(\app\models\Projects::find()->all(),'id', 'id');
        $info = ArrayHelper::map(\app\models\Projects::find()->all(),'info', 'info');
        return $this->render('view-projects',[
            'pmodel' => $pmodel,
            'gmodel' => $gmodel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
            'name' => $name,
            'info' => $info,
        ]);
    }

    /**
     * Displays projects
     *
     * @return string
     */

    public function actionProjects()
    {
        $query = Projects::find();

        $pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);

        $projects = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('projects', [
            'projects' => $projects,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays DeleteProjectForm
     *
     * @return string
     */

    public function actionDeleteProject($id)
    {
        $model = Projects::find()->where(['id' => $id])->one();
        if ($model != null) {
            $model->delete();
        }
        return $this->redirect('view-projects');
    }

    /**
     * Displays DeleteOptionForm
     *
     * @return string
     */

    public function actionDeleteOption($id, $mainid)
    {
        $model = Options::find()->where(['options_id' => $id])->one();
        if ($model != null) {
            $model->delete();
        }
        return $this->redirect('project?id='.strval($mainid));
    }

    /**
     * Displays ReProjectForm
     *
     * @return string
     */

    public function actionReProject($id, $bool)
    {
        $image_model = new ImageForm();
        $model = Projects::find()->where(['id' => $id])->one();
        $image_model->name = $model->name;
        $image_model->info = $model->info;
        $image_model->id = $model->id;
        $image_model->images_name = $model->images_name;

        if ($image_model->load(Yii::$app->request->post()))
        {
            $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            $model->images_name = $image_model->imageFile->name;
            $model->info = $image_model->info;
            $model->name = $image_model->name;
            $image_model->upload();
            $model->save(false);
            if ($bool != 'false')
                return $this->redirect('project?id=' . strval($model->id));
            else
                return $this->redirect('view-projects');
        }
        else
        {
            return $this->render('re-project', [
                'image_model' => $image_model,
                'bool' => $bool,
                'id' => $id,
            ]);
        }


    }

    /**
     * Displays AddProjectForm
     *
     * @return string
     */

    public function actionAddProject($bool)
    {
        $image_model = new ImageForm();

        if ($image_model->load(Yii::$app->request->post()))
        {
            $model = new Projects();
            $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            $model->images_name = $image_model->imageFile->name;
            $model->info = $image_model->info;
            $model->name = $image_model->name;
            $model->save(false);
            $image_model->upload();
            if ($bool = strval(true))
                return $this->redirect('project?id=' . strval($model->id));
            else
                return $this->redirect('view-projects');
        }
        else
            {
                return $this->renderAjax('add-project',[
                        'image_model' => $image_model,
                    ]);
            }
    }

    /**
     * Displays project.
     *
     * @return string
     */
    public function actionProject($id)
    {
        $project = Projects::find()->where(['id' => $id])->one();
        $model = Options::find()->where(['projects_id' => $id])->all();
        $image = Html::img('@web/images/' . $project->images_name, [
            'width' => '80px',
            'height' => '80px'
        ]);
        $searchModel = new SearchOptions();
        $dataProvider =$searchModel->search(Yii::$app->request->get(), $id);
        $options_name = ArrayHelper::map($model,'options_name', 'options_name');
        $options_value = ArrayHelper::map($model,'options_value', 'options_value');
        $projects_id = ArrayHelper::map($model,'projects_id', 'projects_id');
        $formModel = new Options();
        return $this->render('project',[
            'formModel' => $formModel,
            'project' => $project,
            'image' => $image,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'options_name' => $options_name,
            'options_value' => $options_value,
            'projects_id' => $projects_id,
        ]);
    }

    /**
     * Displays option.
     *
     * @return string
     */
    public function actionOption($options_id)
    {
        $option = Options::find()->where(['options_id' => $options_id])->one();
        $project = Projects::find()->where(['id' => $option->projects_id])->one();
        return $this->render('option',[
            'option' => $option,
            'project' => $project,
        ]);
    }

    /**
     * Displays AddOptionsProjectForm
     *
     * @return string
     */

    public function actionAddOptionsProject($id)
    {
        $model = new Options();
        if ($model->load(Yii::$app->request->post()))
        {
            $model->projects_id = $id;
            $model->save(false);
        }
        return $this->redirect('project?id=' . strval($id));
    }

    /**
     * Displays message
     *
     * @return string
    */
    public function actionSay($target)
    {
        return $this->render('say', [
            'target' => $target,
            ]);
    }

    /**
     * Displays homepage
     *
     * @return string
    */
    public function actionIndex()
    {
        $projects = Projects::find()->all();
        $carousel = [];
        foreach($projects as $project) {
            $options = Options::find()->where(['projects_id' => $project->id])->all();
            $searchModel = new SearchOptions();
            $dataProvider =$searchModel->search(Yii::$app->request->get(), $project->id);
            $options_name = ArrayHelper::map($options,'options_name', 'options_name');
            $options_value = ArrayHelper::map($options,'options_value', 'options_value');
            foreach($options as $option){
                $rows[] = [$option->options_name, $option->options_value];
            }
            $image = Yii::getAlias('@webroot/images/' . $project->images_name);
            $image = Image::resize($image, 300, 300);
            Image::crop($image, 300, 200)
                ->save(Yii::getAlias('@webroot/images/' . $project->images_name . 'resize.jpg'), ['quality' => 100]);
            $carousel[] = [
                'content' => Html::img('@web/images/' . $project->images_name . 'resize.jpg', [
                    'width' => '100%',
                    'height' => '100%'
                ]),
                'caption' => GridView::widget([
                    'dataProvider' => $dataProvider,
                    //'filterModel' => $searchModel,
                    'rowOptions' => ['style'=>'color: #000000; background-color: #FFFFFF;'],
                    'headerRowOptions' => ['style'=>'color: #000000; background-color: #FFFFFF;'],
                    'layout' => '{items}{pager}',
                    'columns' => [
                        'options_name',
                        'options_value',
                    ],
                ]),
            ];
        };

        return $this->render('index', [
            'carousel' => $carousel,
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
        $model->load(Yii::$app->request->get());
        $target = $model->target;

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
     * Displays request-ids.
     *
     * @return string
     */

    public function actionRequestIds()
    {
        $model = new RequestIdsForm();
        return $this->render('request-ids', [
            'model' => $model,
        ]);
    }

    /**
     * Displays request-ids-results.
     *
     * @return string
     */

    public function actionRequestIdsResults()
    {
        $searchModel = new RequestIds();
        $model = new RequestIdsForm();
        $model->load(Yii::$app->request->post());
        $dataProvider =$searchModel->search(Yii::$app->request->post(), $model);
        $id = ArrayHelper::map(Options::find()
            ->where(['options_name' => $model->options_name])
            ->andWhere(['options_value' => $model->options_value])
            ->all(), 'projects_id', 'projects_id');
        return $this->render('request-ids-results',[
            'dataProvider'=> $dataProvider,
            'seacrhModel' => $searchModel,
            'id' => $id,
        ]);
    }

    /**
     * Displays products.
     *
     * @return string
     */

    public function actionProducts()
    {
        return $this->render('products');
    }

    /**
     * Displays store.
     *
     * @return string
     */

    public function actionStore()
    {
        $ids = Projects::find()->all();
        $ids = ArrayHelper::map($ids, 'id', 'id');
        return $this->render('store', [
            'ids' => $ids,
            ]);
    }

    /**
     * Displays profile.
     *
     * @return string
     */

    public function actionProfile()
    {
        $user = User::findIdentity(Yii::$app->user->id);
        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Displays SingUp.
     *
     * @return Response|string
     */
    public function actionSingUp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SingUpForm();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->username = $model->username;
            $user->password = $model->password;
            $user->save(false);
            return $this->redirect('profile');
        }
        else
        {
            return $this->render('sign-up', compact('model'));
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
