<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image  */
/* @var $user app\models\User */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin();

$this->title = 'Профиль ' . strval($user->users_name);
?>
    <div class="row">
        <div class="col-lg-10">
            <h2>Профиль <?= Html::encode($user->users_name) ?></h2>
            <h2><?= $image ?></h2>
        </div>
        <div class="col-lg-2">
            <?php if (Yii::$app->user->id === $user->id_users)
            {
                echo '<html>
                            <body>
                                <h4>Логин : '.Html::encode($user->username).'</h4>
                                <h4>Пароль : '.Html::encode($user->password).'</h4>
                            </body>
                        </html>';
                echo Html::button('Сменить пароль',['value' => Url::to('/users/change-password'),'class' => 'btn btn-success', 'name' => 'change-password-button', 'id' => 'modalButton2']);
                Modal::begin([
                    'header' => '<h4>Сменить пароль</h4>',
                    'id' => 'modal2',
                    'size' => 'modal-lg',
                ]);
                echo "<div id='modalContent2'></div>";
                Modal::end();
            }
            ?>
        </div>
    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="col-lg-2">
            <h2>Информация</h2>
            <h4><?php
                if (Yii::$app->user->id === $user->id_users)
                    echo Html::a('Редактировать информацию',[Url::toRoute(['/users/re-profile', 'id' => ($user->id_users)/*, 'bool' => ('1')*/])]);
                ?></h4>
        </div>
        <div class="col-lg-5">
            <h2><textarea readonly rows="10" cols="50"><?= Html::encode($user->users_info) ?></textarea></h2>
        </div>
    </div>

<?php ActiveForm::end(); ?>