<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\Url;

$form = ActiveForm::begin();

$this->title = 'Просмотр идеи '.strval($model->ideas_name);
?>
<div class="row">
    <div class="col-lg-12">
        <?php

            if (Yii::$app->user->id != $model->creators_id) {
                echo '<h1>Идея : '. Html::encode($model->ideas_name).'</h1>';
            } else {
                echo '<h1>' . $form->field($ideasModel, 'ideas_name')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label('Название') . '</h1>';
            }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h1>Создатель идеи : <a href="/users/profile?id=<?= strval($model->creators_id) ?>" class="" role="button"><?php echo $model->getAuthorsName() ?></a></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php
            $array_tags = [];
            foreach($model->getTags() as $tag) {
                $array_tags[] = strval($tag->tag).' ';
            }
            implode(", ", $array_tags);
        ?>
        <h2>Теги : <?= implode(", ", $array_tags) ?></h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <?php
        if (Yii::$app->user->id == $model->creators_id) {
            echo '<h1>' . $form->field($tagModel, 'tag')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label(false) . '</h1>'.
                Html::submitButton('Добавить <br> тэг', ['class' => 'btn btn-primary', 'name' => 'add-idea-tag-button']);
        }
        ?>
    </div>
</div>
<div class="row">
    <p></p>
</div>
<div class="row">
    <div class="col-lg-1">
        <p></p>
    </div>
    <div class="col-lg-10">
        <?php
            if ($carousel != Null) {
                echo Carousel::widget([
                    'items' => $carousel,
                    'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                    ]
                ]);
            }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
        <p></p>
    </div>
    <div class="col-lg-2">
        <?php
        if (Yii::$app->user->id == $model->creators_id){
            echo $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true])->label('Добавить изображение');
            echo Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'idea-button']);
        }
        ?>
    </div>
    <div class="col-lg-2">
        <p></p>
    </div>
    <div class="col-lg-2">
        <p></p>
    </div>
    <div class="col-lg-2">
        <p>
        </p>
        <?php
        if (Yii::$app->user->id == $model->creators_id) {
            echo '<a href="delete-idea-images?id=' . strval($model->id_ideas) . '" class="btn btn-danger" role="button">Удалить <br> изображения</a>';
        }
        ?>
    </div>
    <div class="col-lg-2">
        <p></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Краткое описание : </h3>
    </div>
    <div class="col-lg-9">
        <?php
        if (Yii::$app->user->id != $model->creators_id) {
            echo '<h3><textarea readonly rows="2" cols="65">' . Html::encode($model->info_short) .'</textarea></h3>';
        } else {
            echo '<h3>'.$form->field($ideasModel, 'info_short')->textarea(['autofocus' => true, 'rows' => 2, 'cols' => 65]).'</h3>';
        }
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-3">
        <h3>Описание идеи : <br><br><br> </h3>
        <?php if (Yii::$app->user->id == $model->creators_id) {
            echo Html::submitButton('Созранить <br> изменения', ['class' => 'btn btn-primary', 'name' => 'change-idea-info-button']);
        }
        ?>
    </div>
    <div class="col-lg-9">
        <?php
        if (Yii::$app->user->id != $model->creators_id) {
            echo '<h3><textarea readonly rows="10" cols="65">' . Html::encode($model->info_long) . '</textarea></h3>';
        } else {
            echo '<h3>'.$form->field($ideasModel, 'info_long')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 65]).'</h3>';
        }
        ?>
    </div>
    <?php
        ActiveForm::end()
    ?>
</div>