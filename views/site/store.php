<?php

/* @var $this yii\web\View */

use app\models\Options;
use app\models\SearchOptions;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use app\models\Projects;


$this->title = 'Магазин';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store">
    <?php
    foreach ($ids as $id) {
        $Project = Projects::find()->where(['id' => $id])->one();
        echo '<html> 
                <body> 
                    <h2>Project : ' . $Project->name . '</br> </h2> 
                </body> 
               </html>';
        echo $Project->info;
        $model = Options::find()->where(['projects_id' => $id])->all();
        $searchModel = new SearchOptions();
        $dataProvider =$searchModel->search(Yii::$app->request->get(), $id);
        $options_name = ArrayHelper::map($model,'options_name', 'options_name');
        $options_value = ArrayHelper::map($model,'options_value', 'options_value');
        $projects_id = ArrayHelper::map($model,'projects_id', 'projects_id');
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'attribute' => 'projects_id',
                    'filter' => Select2::widget([
                        'name' => 'projects_id',
                        'model' => $searchModel,
                        'attribute' => 'projects_id',
                        'data' => $projects_id,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'value' => $searchModel->projects_id,
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
                    'attribute' => 'options_name',
                    'filter' => Select2::widget([
                        'name' => 'options_name',
                        'model' => $searchModel,
                        'attribute' => 'options_name',
                        'data' => $options_name,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'value' => $searchModel->options_name,
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
                    'attribute' => 'options_value',
                    'filter' => Select2::widget([
                        'name' => 'options_value',
                        'model' => $searchModel,
                        'attribute' => 'options_value',
                        'data' => $options_value,
                        'theme' => Select2::THEME_BOOTSTRAP,
                        'value' => $searchModel->options_value,
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
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('', Url::toRoute(['/site/option' , 'options_id' => strval($key),]), ['class' => 'glyphicon glyphicon glyphicon-ruble']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('', [], ['class' => '']);
                        },
                        'delete' => function ($url, $model, $key){
                            return Html::a('', [], ['class' => '']);
                        }
                    ]
                ],
            ],
        ]);
    }
    ?>
</div>