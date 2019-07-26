<?php


namespace app\controllers;


use app\models\ChangePasswordForm;
use app\models\ImageForm;
use app\models\LoginForm;
use app\models\SingUpForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use app\models\ChangeUsersInfoForm;
use app\models\UsersForm;

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
     * Displays reProfile.
     *
     * @return string
     */

    public function actionReProfile($id)
    {
        if (Yii::$app->user->id != $id) {
            $this->redirect('profile?id=' . strval($id));
        }
        $user = User::findIdentity($id);
        $image = Html::img('@web/images/' . $user->users_image, [
            'width' => '80px',
            'height' => '80px'
        ]);
        $image_model = new UsersForm();
        $image_model->imageFile = $image;
        $image_model->users_name = $user->users_name;
        $image_model->users_info = $user->users_info;
        if ($image_model->load(Yii::$app->request->post()))
        {
            if ($image_model->imageFile != Null) {
                $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
                $image_model->imageFile->name = $user->users_name . '_image.jpg';
                $user->users_image = $image_model->imageFile->name;
                $image_model->upload();
            }
            $user->users_name = $image_model->users_name;
            $user->users_info = $image_model->users_info;
            $user->save(false);
            return $this->redirect('profile?id='.strval($id));
        } else {
            return $this->render('re-profile', [
                'image_model' => $image_model,
            ]);
        }
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
        $image = Html::img('@web/images/' . $user->users_image, [
            'width' => '160px',
            'height' => '160px'
        ]);
        $infoModel = new ChangeUsersInfoForm();
        $infoModel->info = $user->users_info;
        if ($infoModel->load(Yii::$app->request->post()))
        {
            $user->users_info = $infoModel->info;
            $user->save(false);
        }
        return $this->render('profile', [
            'user' => $user,
            'image' => $image,
            'infoModel' => $infoModel,
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findIdentity(Yii::$app->user->id);
            $user->password = $model->newPassword;
            if ($user->save()) {
                return $this->redirect('profile?id=' . strval(Yii::$app->user->id));
            }
        } elseif (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii\widgets\ActiveForm::validate($model);
        }

        return $this->renderAjax('change-password', [
            'model' => $model,
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
            $user->users_name = $model->users_name;
            $user->password = $model->password;
            $model = new LoginForm();
            $model->username = $user->username;
            $model->password = $user->password;
            $user->users_role = 'user';
            $user->users_image = 'first_log_pic.jpg';
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