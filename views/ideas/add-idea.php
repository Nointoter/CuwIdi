<?php

/* @var $form yii\bootstrap\ActiveForm */
/* @var $image_model app\models\IdeasForm */

use app\models\ImageForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/*$this->title = 'Добавить идею';
$this->params['breadcrumbs'][] = $this->title;*/

?>
<div class="ideas-add-idea">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Для добавления идеи заполните данную форму.
    </p>

    <div class="row">
        <div class="col-xs-12">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($image_model, 'ideas_name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($image_model, 'info_short')->textInput(['autofocus' => true]) ?>

            <?= $form->field($image_model, 'info_long')->textarea(['rows' => 8, 'autofocus' => true]) ?>

            <?/*= $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true]) */?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'add-project-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div