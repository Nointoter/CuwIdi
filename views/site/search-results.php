<?php
$this->title = 'Результаты поиска';
$this->params['breadcrumbs'][] = $this->title;

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>

<div class="view-results">
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
                    'data' => $name,
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
                'label' => 'Options',
                'format' => 'raw',
                'value' => function ($data) {
                    $options = [];
                    foreach($data->options as $Option) {
                        $options[] = strval($Option->options_name).' : '.strval($Option->options_value);
                    }
                    return implode(", <br/>", $options);
                },
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
