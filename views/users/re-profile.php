<?php

use app\models\Comments;
use app\models\Ideas;
use app\models\ReUsersForm;
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var View $this */
/* @var ActiveForm $form */
/* @var $image */
/* @var User $user*/
/* @var ReUsersForm $profileModel*/

$form = ActiveForm::begin();
$this->title = 'Профиль ' . strval($user->users_name);
?>
<div class="row">
    <div class="col-lg-3">
        <h3>Имя:</h3>
    </div>
    <div class="col-lg-9">
        <h3>
            <?= $form->field($profileModel, 'users_name')->textInput(['autofocus' => true])->label(false) ?>
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Изображение:</h3>
    </div>
    <div class="col-lg-6">
        <h3><?= $image ?></h3>
        <?= $form->field($profileModel, 'imageFile')->fileInput(['autofocus' => true])->label(false) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Информация:</h3>
    </div>
    <div class="col-lg-9">
        <?php
        echo '<h2>'.$form->field($profileModel, 'users_info')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 50])->label(false).'</h2>';
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Удаление профиля:</h3>
    </div>
    <div class="col-lg-6">
        <br>
        <?php
            $ideas = Ideas::find()->where(['creators_id' => $user->id_users])->all();
            $comments = Comments::find()->where(['users_id' => $user->id_users])->all();
            if ($ideas || $comments) {
                echo Html::button('Удалить профиль', [
                    'class' => 'btn btn-warning',
                    'name' => 'add-idea-button',
                    'id' => 'modalButton4'
                ]);
            } else {
                echo Html::a('Удалить профиль', Url::toRoute(['/users/delete', 'id' => strval($user->id_users),]), [
                    'data-confirm' => 'Вы уверены, что хотите удалить профиль?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-danger',
                    'name' => 'delete-user-button',
                ]);
            }
        ?>
        <?php
            echo Html::a('Заморозить профиль', Url::toRoute(['/users/freeze', 'id' => strval($user->id_users), 'bool' => false]), [
                    'data-confirm' => 'Вы уверены, что хотите заморозить профиль?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-warning',
                    'name' => 'delete-user-button',
                ]);
        ?>
    </div>
</div>
<div class="row">
    <div class="pull-right">
        <?php
            echo Html::submitButton('Сохранить', ['class' => 'btn btn-info btn-lg', 'name' => 'save-profile-changes-button']);
        ?>
        <?php
            echo '<html><body><a href="profile?id=' . strval($user->id_users) . '" class="btn btn-primary btn-lg" role="button">Отменить</a></body></html>';
        ?>

    </div>
</div>
<?php /*if( Yii::$app->session->hasFlash('success') ): */?><!--
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php /*echo Yii::$app->session->getFlash('success'); */?>
            </div>
--><?php /*endif;*/?>
<?php
    Modal::begin([
        'header' => '<h4>Невозможно удалить пользователя</h4>',
        'id' => 'modal4',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent4'>У пользователя остались идеи или комментарии</div>";
    Modal::end();
?>
<?php ActiveForm::end(); ?>
