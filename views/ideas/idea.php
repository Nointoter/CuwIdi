<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Carousel;

$this->title = 'Просмотр идеи '.strval($model->ideas_name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div>
        <h1>Идея : <?= Html::encode($model->ideas_name) ?></h1>
    </div>
    <div>
        <h1>Создатель идеи : <a href="/users/profile?id=<?= strval($model->creators_id) ?>" class="" role="button"><?php echo $model->getAuthorsName() ?></a></h1>
    </div>
    <div>

        <div class="col-lg-1">
            <p></p>
        </div>
        <div class="col-lg-11">

        <?php
        echo Carousel::widget([
            'items' => $carousel,
            'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
            'controls' => [
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
            ]
            ]);
        ?>
        </div>
        <div class="col-lg-12">
            <p></p>
        </div>
        <?php
        ?>
    </div>
    <div>
        <div class="col-lg-2">
            <p></p>
        </div>
        <div class="col-lg-10">
        <?php
        if (Yii::$app->user->id == $model->creators_id){
            $form = ActiveForm::begin();
            echo $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true])->label('Добавить изображение');
            echo Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'idea-button']);
            ActiveForm::end();
        }
        ?>
        </div>
    </div>
</div>
<div class="row">
    <div>
        <div class="col-lg-3">
            <h3>Краткое описание : </h3>
        </div>
        <div class="col-lg-9">
            <h3><textarea readonly rows="2" cols="65"><?= Html::encode($model->info_short) ?></textarea></h3>
        </div>
    </div>
    <div>
        <div class="col-lg-3">
            <h3>Описание идеи : </h3>
        </div>
        <div class="col-lg-9">
            <h3><textarea readonly rows="10" cols="65"><?= Html::encode($model->info_long) ?></textarea></h3>
        </div>
    </div>
</div>