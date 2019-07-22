<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Ideas */


use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Идеи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="add-ideas">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::button('Добавить идею',['value' => Url::to('/site/add-project?bool='.strval(false)) ,'class' => 'btn btn-success', 'name' => 'add-project-button', 'id' => 'modalButton']) ?>
            </div>
            <?php
            Modal::begin([
                'header' => '<h4>Projects</h4>',
                'id' => 'modal',
                'size' => 'modal-lg',
            ]);

            echo "<div id='modalContent'></div>";

            Modal::end();
            ?>
        </div>

<div class="view-ideas">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id_ideas',
                'filter' => Select2::widget([
                    'name' => 'id',
                    'model' => $searchModel,
                    'attribute' => 'id_ideas',
                    'data' => $id_ideas,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->id_ideas,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'attribute' => 'ideas_name',
                'filter' => Select2::widget([
                    'name' => 'name',
                    'model' => $searchModel,
                    'attribute' => 'ideas_name',
                    'data' => $ideas_name,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->ideas_name,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'attribute' => 'info_short',
                /*'filter' => Select2::widget([
                    'name' => 'info',
                    'model' => $searchModel,
                    'attribute' => 'info_short',
                    'data' => $info_short,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->info_short,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => 'Выберите значение'
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),*/
            ],
            /*[
                'label' => 'Author',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->creators_id != null)
                        return $model->getAuthorsName();
                    else
                        return '';
                },
            ],
            [
                'label' => 'Image',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->images_name != null)
                        return Html::img($model->getImageUrl(),
                            ['width' => '80px',
                                'height' => '80px']);
                    else
                        return '';
                },
            ],*/
            /*[
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/site/delete-project', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                    }
                ]
            ],*/
        ],
    ])?>
</div>
