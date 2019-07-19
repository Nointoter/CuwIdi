<?php
$this->title = 'Результаты запроса id';
$this->params['breadcrumbs'][] = $this->title;

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;

?>

<div class="reques-ids-results">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('', ['/site/project?id='.strval($key),], ['class' => 'glyphicon glyphicon-eye-open']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('', [], []);
                        },
                        'delete' => function ($url, $model, $key){
                            return Html::a('', [], []);
                        }
                    ]
                ],
        ],
    ])?>
</div>

