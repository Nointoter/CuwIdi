<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$this->title = 'Поиск проекта';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="index">
    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['action' => '/site/search-results', 'method' => 'get']); ?>

            <?= $form->field($model, 'target')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'search-project-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
