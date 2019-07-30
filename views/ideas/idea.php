<?php

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Carousel;
use yii\helpers\Url;

$form = ActiveForm::begin();

$this->title = 'Просмотр идеи '.strval($model->ideas_name);
?>

<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <div class="col-lg-12">
        <?php

            if (Yii::$app->user->id != $model->creators_id) {
                echo '<h1>Название : '. Html::encode($model->ideas_name).'</h1>';
            } else {
                echo '<h1>' . $form->field($ideasModel, 'ideas_name')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label('Название') . '</h1>';
            }
        ?>
    </div>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <div class="col-lg-12">
        <h1>Создатель идеи : <a href="/users/profile?id=<?= strval($model->creators_id) ?>" class="" role="button"><?php echo $model->getAuthorsName() ?></a></h1>
    </div>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
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
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <div class="col-lg-6">
        <?php
        if (Yii::$app->user->id == $model->creators_id) {
            echo '<h1>' . $form->field($tagModel, 'tag')->textarea(['autofocus' => true, 'cols' => 1, 'rows' => 1])->label(false) . '</h1>'.
                Html::submitButton('Добавить <br> тэг', ['class' => 'btn btn-primary', 'name' => 'add-idea-tag-button']);
        }
        ?>
    </div>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <p></p>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <table class="table table-hover">
        <body>
            <tr>
                <td>
                    <div style="height: 500px; overflow:auto;">
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
                </td>
            </tr>
        </body>
    </table>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
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
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <div class="col-lg-3">
        <h3>Краткое описание : </h3>
    </div>
    <div class="col-lg-9">
        <?php
        if (Yii::$app->user->id != $model->creators_id) {
            echo '<h3><textarea readonly rows="2" cols="65">' . Html::encode($model->info_short) .'</textarea></h3>';
        } else {
            echo '<h3>'.$form->field($ideasModel, 'info_short')->textarea(['autofocus' => true, 'rows' => 2, 'cols' => 65])->label(false).'</h3>';
        }
        ?>
    </div>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
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
            echo '<h3>'.$form->field($ideasModel, 'info_long')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 65])->label(false).'</h3>';
        }
        ?>
    </div>
</div>
<div class="row" STYLE="background-color: #FFFFFF; color: #000000">
    <h1>Комментарии</h1>
    <?php if (!Yii::$app->user->isGuest) : ?>
    <div class="col-lg-10">
        <h3><?= $form->field($commentModel, 'comment')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 65])->label(false) ?></h3>
    </div>
    <div class="col-lg-2">
        <?php
            echo '<h1><br></h1>';
            echo Html::submitButton('Добавить <br> комментарий', ['class' => 'btn btn-primary', 'name' => 'add-ideas-comment-button']);
        ?>
    </div>
    <?php else : ?>
        <h3>Для добавления комментариев войдите в аккаунт</h3>
    <?php endif ?>
<?php ActiveForm::end() ?>
</div>
<?php if ($dataProvider->totalCount > 0) : ?>
<div class="view-idea-comments">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'comment',
                'label' => 'Комментарий',
                'contentOptions'=>['style'=>'width : 500px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'creators_id',
                'label' => 'Комментатор',
                'contentOptions'=>['style'=>'white-space: normal; background-color: #FFFFFF; color: #000000'],
                'value' => function ($data) {
                    return Html::a(Html::encode($data->getAuthorsName()), Url::toRoute(['/users/profile', 'id' => $data->users_id]));
                },
                'format' => 'raw',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'background-color: #FFFFFF; color: #000000'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => '/*glyphicon glyphicon-eye-open*/']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/comments/re-comment', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                    },
                    'delete' => function ($url, $model, $key){
                        if (Yii::$app->user->id != $model->users_id){
                            return Html::a('', Url::toRoute(['/comments/delete-comment', 'id' => strval($key),]), ['class' => '']);
                        } else {
                            return Html::a('', Url::toRoute(['/comments/delete-comment', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                        }
                    }
                ]
            ],
        ],
    ])?>
</div>
<?php endif; ?>