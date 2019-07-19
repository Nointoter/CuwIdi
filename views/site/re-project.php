<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image_model app\models\ImageForm */
/* @var $bool 'bool' */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\web\View;

$this->title = 'Редактирование проекта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-re-project">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(/*['action' => '/site/re-project-save?oldid='.strval($image_model->id).'&bool='.strval($bool)]*/); ?>

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