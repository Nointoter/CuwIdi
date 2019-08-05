<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image  */
/* @var $user app\models\User */

use app\models\Ideas;
use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$form = ActiveForm::begin();

$this->title = 'Профиль ' . strval($user->users_name);
?>
<div class="row">
    <div class="col-lg-3">
        <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Имя : </h2>
    </div>
    <div class="col-lg-9">
        <h2>
            <?= $form->field($profileModel, 'users_name')->textInput(['autofocus' => true])->label(false) ?>
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h2>Изображение : </h2>
    </div>
    <div class="col-lg-6">
        <h2><?= $image ?></h2>
        <?= $form->field($profileModel, 'imageFile')->fileInput(['autofocus' => true])->label(false) ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h2>Информация : </h2>
    </div>
    <div class="col-lg-9">
        <?php
            echo '<h2>'.$form->field($profileModel, 'users_info')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 50])->label(false).'</h2>';
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-4">
        <?php
            $ideas = Ideas::find()->where(['creators_id' => $user->id_users])->all();
            if ($ideas) {
                echo Html::button('Удалить профиль', [
                        //'value' => Url::to('/ideas/add-idea?bool='.strval(false)),
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
    </div>
    <div class="col-lg-4">
        <?php
            echo Html::submitButton('Созранить<br>изменения', ['class' => 'btn btn-info', 'name' => 'save-profile-changes-button']);
        ?>
    </div>
    <div class="col-lg-4">
        <?php
            echo '<html><body><a href="profile?id=' . strval($user->id_users) . '" class="btn btn-primary" role="button">Закончить<br>редактироавние</a></body></html>';
        ?>
    </div>
</div>
<?php
Modal::begin([
    'header' => '<h4>Невозможно удалить пользователя</h4>',
    'id' => 'modal4',
    'size' => 'modal-lg',
]);
echo "<div id='modalContent4'>У пользователя остались идеи</div>";
Modal::end();
?>
<?php ActiveForm::end(); ?>

