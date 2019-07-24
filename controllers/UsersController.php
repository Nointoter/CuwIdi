<?php


namespace app\controllers;


use app\models\ChangePasswordForm;
use app\models\LoginForm;
use app\models\SingUpForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UsersController extends Controller
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
     * Displays profile.
     *
     * @return string
     */

    public function actionProfile($id)
    {
        //$user = User::findIdentity(Yii::$app->user->id);
        $user = User::findIdentity($id);
        if ($user->users_image != null){
            $image = Html::img('@web/images/' . $user->users_image, [
                'width' => '80px',
                'height' => '80px'
            ]);
        }
        return $this->render('profile', [
            'user' => $user,
            'image' => $image,
        ]);
    }

    /**
     * Displays change-password form.
     *
     * @return string|array
     */

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();
        if(Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            /*echo "<pre>";
            var_dump($model);
            die();*/
            $user = User::findIdentity(Yii::$app->user->id);
            if (($model->newPassword != '') && $model->load(Yii::$app->request->post()))
            {
                $user->password = $model->newPassword;
                $user->save();
                return $this->redirect('profile?id=' . strval(Yii::$app->user->id));
            }
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return $this->renderAjax('change-password', [
            'model' => $model,
        ]);
        /*if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            var_dump($model->newPassword);
            $user = User::findIdentity(Yii::$app->user->id);
            $user->password = $model->newPassword;
            if ($user->save())
                return $this->redirect('profile?id=' . strval(Yii::$app->user->id));
            else
                return $this->renderAjax('change-password', [
                    'model' => $model,
                ]);
        }
        else
            return $this->renderAjax('change-password', [
                'model' => $model,
            ]);*/
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
            $user->users_name = $model->users_name;
            $user->password = $model->password;
            $model = new LoginForm();
            $model->username = $user->username;
            $model->password = $user->password;
            $user->users_role = 'user';
            $user->save(false);
            $model->login();
            return $this->redirect('profile?id='.strval(Yii::$app->user->id));
        }
        else
        {
            return $this->render('sing-up', compact('model'));
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

}