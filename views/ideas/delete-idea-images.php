<?php

$this->title = 'Удаление изображений идеи : '.strval($model->ideas_name);
$this->params['breadcrumbs'][] = $this->title;


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url; ?>

<div class="view-ideas">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'label' => 'Изображения',
                'format' => 'html',
                'value' => function ($model) {
                    if ($model->images_name != null)
                    return Html::img($model->getImageUrl(), [
                        'width' => '80px',
                        'height' => '80px'
                    ]);
                    else
                        return '';
                    },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/site/project' , 'id' => strval($key),]), ['class' => '']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                    },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/site/delete-project', 'id' => $model->id_ideas, 'delId' => strval($key)]), ['class' => 'glyphicon glyphicon-trash']);
                    }
                ]
            ],
            ],
        ]);
    ?>
</div>
