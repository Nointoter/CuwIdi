<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\Comments;
use app\models\Ideas;
use app\models\ImagesForm;
use app\models\LoginForm;
use app\models\ReUsersForm;
use app\models\SearchComments;
use app\models\SearchIdeas;
use app\models\SearchUsers;
use app\models\SingUpForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;

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
     * Displays index
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new SearchUsers();
        $model->load(Yii::$app->request->get());
        $allUsers = User::find()->all();

        $usersSearch = new SearchUsers();
        $usersProvider = $usersSearch->search(Yii::$app->request->get(), NULL, Null, true);

        return $this->render('index',[
            'model' => $model,
            'usersSearch' => $usersSearch,
            'usersProvider' => $usersProvider,
            'allUsers' => $allUsers,
        ]);
    }

    /**
     * Displays profile.
     *
     * @return string
     */
    public function actionProfile($id)
    {
        $user = User::findIdentity($id);
        if(!$user){
            return $this->redirect('/users/index');
        }

        $ideasSearch = new SearchIdeas();
        $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), $id, Null);

        $image = Html::img('@web/images/' . $user->users_image, [
            'width' => '160px',
            'height' => '160px'
        ]);

        $commentsSearch = new SearchComments();
        $commentsProvider = $commentsSearch->search(Yii::$app->request->get(), $id, false, Null);

        $image_model = new ImagesForm();
        if ($image_model->load(Yii::$app->request->post()))
        {
            $image_model->imageFile = UploadedFile::getInstance($image_model, 'imageFile');
            $image_model->imageFile->name = $user->users_name . '_image.jpg';
            $user->users_image = $image_model->imageFile->name;
            $image_model->upload();
        }
        return $this->render('profile', [
            'user' => $user,
            'image' => $image,
            'image_model' => $image_model,
            'ideasSearch' => $ideasSearch,
            'ideasProvider' => $ideasProvider,
            'commentsProvider' => $commentsProvider,
            'commentsSearch' => $commentsSearch,
        ]);
    }

    /**
     * Displays reProfile.
     *
     * @return string
     */
    public function actionReProfile($id)
    {
        $user = User::findIdentity($id);
        if(!$user){
            return $this->redirect('/users/index');
        }
        if (Yii::$app->user->id != $id || (User::findIdentity($id))->status != 0) {
            return $this->redirect('profile?id=' . strval($id));
        }
        $image = Html::img('@web/images/' . $user->users_image, [
            'width' => '140px',
            'height' => '140px'
        ]);
        $profileModel = new ReUsersForm();
        $profileModel->imageFile = $image;
        $profileModel->users_name = $user->users_name;
        $profileModel->users_info = $user->users_info;
        if ($profileModel->load(Yii::$app->request->post()))
        {
            $profileModel->imageFile = UploadedFile::getInstance($profileModel, 'imageFile');
            if ($profileModel->imageFile != null) {
                $profileModel->imageFile->name = $user->users_name . '_image.jpg';
                $user->users_image = $profileModel->imageFile->name;
                $profileModel->upload();
            }
            $user->users_name = $profileModel->users_name;
            $user->users_info = $profileModel->users_info;
            $user->save(false);
            return $this->redirect('re-profile?id='.strval($id));
        } else {
            return $this->render('re-profile', [
                'image' => $image,
                'user' => $user,
                'profileModel' => $profileModel,
            ]);
        }
    }

    /**
     * Delete User
     *
     * @param $id
     * @return Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('profile?id=' . strval($id));
        }
        $ideas = Ideas::find()->where(['creators_id' => $id])->all();
        $comments = Comments::find()->where(['users_id' => $id])->all();
        if ((User::findIdentity(Yii::$app->user->id)->users_role == 'admin' || Yii::$app->user->id == $id) && !$ideas && !$comments) {
            $user = User::find()->where(['id_users' => $id])->one();
            $user->delete();
        }
        return $this->redirect('/users');
    }

    /**
     * Freeze User
     *
     * @param $id
     * @param $bool
     * @return Response
     */
    public function actionFreeze($id, $bool)
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('profile?id=' . strval($id));
        }
        if ((User::findIdentity(Yii::$app->user->id)->users_role == 'admin') || (Yii::$app->user->id == $id)) {
            $user = User::find()->where(['id_users' => $id])->one();
            $user->status = 1;
            $user->save(false);
            if ($bool){
                return $this->redirect('/users');
            } else {
                return $this->redirect('/users/profile?id='.strval($id));
            }
        }
        return $this->redirect('/users');
    }

    /**
     * Displays reProfile.
     *
     * @return string
     */
    public function actionReStatus($id, $bool)
    {
        if ((User::findIdentity(Yii::$app->user->id)->users_role == 'admin') || (Yii::$app->user->id == $id)) {
            $user = User::find()->where(['id_users' => $id])->one();
            $user->status = 0;
            $user->save(false);
            if ($bool){
                return $this->redirect('/users');
            } else {
                return $this->redirect('/users/profile?id='.strval($id));
            }
        }
        return $this->redirect('/users');
    }

    /**
     * Displays change-password form.
     *
     * @return string|array
     */
    public function actionChangePassword()
    {
        if((User::findIdentity(Yii::$app->user->id))->status) {
            return $this->redirect('profile?id=' . strval(Yii::$app->user->id));
        }
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
            $user->status = 0;
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