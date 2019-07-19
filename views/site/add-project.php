<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image_model app\models\ImageForm */

use app\models\ContactForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Добавить проект';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-add-project">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Для добавления проекта заполните данную форму.
    </p>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(/*['action' => "/site/add-project?bool=".strval(true)]*/); ?>

            <?= $form->field($image_model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($image_model, 'info')->textInput(['autofocus' => true]) ?>

            <?= $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'add-project-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>