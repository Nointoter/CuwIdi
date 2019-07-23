<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Ideas */


use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Идеи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="search-ideas">
    <div class="row">
        <div class="col-lg-6">

            <?php $form = ActiveForm::begin(['action' => '/ideas/ideas', 'method' => 'get']); ?>

            <?= $form->field($model, 'ideasSearch') ?>

            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary', 'name' => 'search-ideas-button']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default', 'action' => '/ideas/ideas','name' => 'reset-ideas-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="add-ideas">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?= Html::button('Добавить идею',['value' => Url::to('/ideas/add-idea?bool='.strval(false)) ,'class' => 'btn btn-success', 'name' => 'add-project-button', 'id' => 'modalButton']) ?>
            </div>
            <?php
            Modal::begin([
                //'header' => '<h4>Добавить идею</h4>',
                'id' => 'modal',
                'size' => 'modal-lg',
            ]);

            echo "<div id='modalContent'></div>";

            Modal::end();
            ?>
        </div>
    </div>
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
            [
                'attribute' => 'creations_day',
                'filter' => Select2::widget([
                    'name' => 'creations_day',
                    'model' => $searchModel,
                    'attribute' => 'creations_day',
                    'data' => $creations_day,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_day,
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
                'attribute' => 'creations_month',
                'filter' => Select2::widget([
                    'name' => 'creations_month',
                    'model' => $searchModel,
                    'attribute' => 'creations_month',
                    'data' => $creations_month,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_month,
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
                'attribute' => 'creations_year',
                //'header' => 'Year',
                'filter' => Select2::widget([
                    'name' => 'creations_year',
                    'model' => $searchModel,
                    'attribute' => 'creations_year',
                    'data' => $creations_year,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_year,
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
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => 'glyphicon glyphicon-pencil']);
                    },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                    }
                ]
            ],
        ],
    ])?>
</div>
