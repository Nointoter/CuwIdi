<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image_model app\models\ImageForm */
/* @var $bool 'bool' */

use app\models\ImageForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Редактирование проекта';
?>
<div class="site-re-project">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['action' => '/users/re-profile?id='.strval($image_model->id_users).'&bool=2']); ?>

            <?= $form->field($image_model, 'users_name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($image_model, 'users_info')->textInput(['autofocus' => true, 'rows'=>8, 'cols'=>5]) ?>

            <?= $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 're-profile-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>