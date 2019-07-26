<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Carousel;

$this->title = 'Просмотр идеи '.strval($model->ideas_name);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div>
        <?php
            $form = ActiveForm::begin();
            if (Yii::$app->user->id != $model->creators_id) {
                echo '<h1>Идея : '. Html::encode($model->ideas_name).'</h1>';
            } else {
                echo '<h1>' . $form->field($nameModel, 'name')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label('Название') . '</h1>'.
                    Html::submitButton('Изменить <br> имя', ['class' => 'btn btn-primary', 'name' => 'change-idea-name-button']);
            }
            ActiveForm::end();
        ?>
    </div>
    <div>
        <h1>Создатель идеи : <a href="/users/profile?id=<?= strval($model->creators_id) ?>" class="" role="button"><?php echo $model->getAuthorsName() ?></a></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <?php
            $form = ActiveForm::begin();
            if (Yii::$app->user->id == $model->creators_id) {
                echo '<h1>' . $form->field($tagModel, 'tag')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label(false) . '</h1>'.
                    Html::submitButton('Добавить <br> тэг', ['class' => 'btn btn-primary', 'name' => 'add-idea-tag-button']);
            }
            ActiveForm::end();
        ?>
    </div>
</div>
<div class="row">
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
    <?php $form = ActiveForm::begin(); ?>
    <div>
        <div class="col-lg-3">
            <h3>Краткое описание : </h3>
        </div>
        <div class="col-lg-9">
            <?php
                if (Yii::$app->user->id != $model->creators_id) {
                    echo '<h3><textarea readonly rows="2" cols="65">' . Html::encode($model->info_short) .'</textarea></h3>';
                } else {
                    echo $form->field($infoModel, 'short')->textarea(['autofocus' => true, 'rows' => 2, 'cols' => 65]);
                }
            ?>
        </div>
    </div>
    <div>
        <div class="col-lg-3">
            <h3>Описание идеи : <br><br><br> </h3>
            <?php if (Yii::$app->user->id == $model->creators_id) {
                echo Html::submitButton('Изменить <br> информацию', ['class' => 'btn btn-primary', 'name' => 'change-idea-info-button']);
            }
            ?>
        </div>
        <div class="col-lg-9">
            <?php
            if (Yii::$app->user->id != $model->creators_id) {
                echo '<h3><textarea readonly rows="10" cols="65">' . Html::encode($model->info_long) . '</textarea></h3>';
            } else {
                echo $form->field($infoModel, 'long')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 65]);
            }
            ?>
        </div>
    </div>
    <?php
        ActiveForm::end()
    ?>
</div>