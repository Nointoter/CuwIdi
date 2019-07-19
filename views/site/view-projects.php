<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $gmodel app\models\GlobalSearchForm */
/* @var $pmodel app\models\Projects */


use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-add-project">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <h3>
                Добавление проекта
            </h3>
            <div class="form-group">
                <?= Html::button('Добавить проект',['value' => Url::to('/site/add-project?bool='.strval(false)) ,'class' => 'btn btn-success', 'name' => 'add-project-button', 'id' => 'modalButton']) ?>
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
        <div class="col-lg-6">
            <h3>
                Для поиска проекта заполните данную форму.
            </h3>
            <?php $form = ActiveForm::begin(['action' => '/site/search-results', 'method' => 'get']); ?>
            <?= $form->field($gmodel, 'target')->textInput(['autofocus' => true]) ?>
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'search-project-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<div class="view-projects">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id',
                'filter' => Select2::widget([
                    'name' => 'id',
                    'model' => $searchModel,
                    'attribute' => 'id',
                    'data' => $id,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->id,
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
                'attribute' => 'name',
                'filter' => Select2::widget([
                    'name' => 'name',
                    'model' => $searchModel,
                    'attribute' => 'name',
                    'data' => $name,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->name,
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
                'attribute' => 'info',
                'filter' => Select2::widget([
                    'name' => 'info',
                    'model' => $searchModel,
                    'attribute' => 'info',
                    'data' => $info,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->info,
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
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/site/project' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                        },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => 'glyphicon glyphicon-pencil']);
                        },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/site/delete-project', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                        }
                ]
            ],
        ],
    ])?>
</div>


