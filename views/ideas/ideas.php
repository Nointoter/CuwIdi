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
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default', 'name' => 'reset-ideas-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="add-ideas">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <?php if (!Yii::$app->user->isGuest)
                        {
                            echo Html::button('Добавить идею',['value' => Url::to('/ideas/add-idea?bool='.strval(false)) ,'class' => 'btn btn-success', 'name' => 'add-idea-button', 'id' => 'modalButton1']);
                        }
                        else
                        {
                            echo '<html> 
                                    <body> 
                                        <h4>Для добавления идеи войдите в аккаунт </h4> 
                                    </body> 
                                  </html>';
                        }
                            ?>
            </div>
            <?php
            Modal::begin([
                'header' => '<h4>Добавить идею</h4>',
                'id' => 'modal1',
                'size' => 'modal-lg',
            ]);

            echo "<div id='modalContent1'></div>";

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
                'label' => 'Id',
                'contentOptions'=>['style'=>'width : 100px;'],
                'filter' => Select2::widget([
                    'name' => 'id_ideas',
                    'model' => $searchModel,
                    'attribute' => 'id_ideas',
                    'data' => $id_ideas,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->id_ideas,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'attribute' => 'ideas_name',
                'label' => 'Имя',
                //'contentOptions'=>['style'=>'white-space: normal;'],
                'contentOptions'=>['style'=>'width : 200px;'],
                'filter' => Select2::widget([
                    'name' => 'ideas_name',
                    'model' => $searchModel,
                    'attribute' => 'ideas_name',
                    'data' => $ideas_name,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->ideas_name,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => '',
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'attribute' => 'info_short',
                'label' => 'Описание',
                'contentOptions'=>['style'=>'width : 300px;'],
            ],
            [
                'attribute' => 'creators_id',
                'label' => 'Создатель',
                'contentOptions'=>['style'=>'white-space: normal;'],
                'value' => function ($data) {
                    return Html::a(Html::encode($data->getAuthorsName()), Url::toRoute(['/users/profile', 'id' => $data->creators_id]));
                },
                'format' => 'raw',
            ],
            [

                'attribute' => 'creations_day',
                'label' => 'День',
                'contentOptions'=>['style'=>'width : 95px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_day',
                    'model' => $searchModel,
                    'attribute' => 'creations_day',
                    'data' => $creations_day,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_day,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'attribute' => 'creations_month',
                'label' => 'Месяц',
                'contentOptions'=>['style'=>'width : 100px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_month',
                    'model' => $searchModel,
                    'attribute' => 'creations_month',
                    'data' => $creations_month,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_month,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
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
                'label' => 'Год',
                'contentOptions'=>['style'=>'width : 95px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_year',
                    'model' => $searchModel,
                    'attribute' => 'creations_year',
                    'data' => $creations_year,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_year,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                    },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => '']);
                    }
                ]
            ],
        ],
    ])?>
</div>
