<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $ideasModel app\models\Ideas */
/* @var $imagesProvider \yii\data\ActiveDataProvider*/

$this->title = 'Удаление изображений идеи : '.strval($ideasModel->ideas_name);

 ?>
<div class="row">
    <div class="col-lg-5 col-lg-offset-2">
        <h2>
            <?= $this->title ?>
        </h2>
    </div>
    <div class="col-lg-5 pull-right">
        <?php
        echo '<br>
            <a href="idea?id=' . strval($ideasModel->id_ideas) . '" class="btn btn-primary" role="button">
                Вернуться на страницу идеи
            </a>';
        ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <?= GridView::widget([
            'dataProvider' => $imagesProvider,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'label' => 'Изображения',
                    'format' => 'html',
                    'value' => function ($model) {
                        if ($model->images_name != null) {
                            return Html::img($model->getImageUrl(), [
                                'width' => '300px',
                                'height' => '300px'
                            ]);
                        } else {
                            return '';
                        }
                    },
                    'contentOptions'=>[
                        'class' => 'delete-idea-images-style'
                    ],
                ],
                [
                    'contentOptions' => [
                        'style'=>'width : 50px;',
                        'class' => 'delete-idea-images-style'
                    ],
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(
                                '',
                                Url::toRoute(
                                    [
                                        '/site/project',
                                        'id' => strval($key),
                                    ]
                                ),
                                [
                                    'class' => ''
                                ]
                            );
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a(
                                '',
                                Url::toRoute(
                                    [
                                        '/site/re-project',
                                        'id' => strval($key),
                                        'bool' => 'false'
                                    ]
                                ),
                                [
                                     'class' => ''
                                ]
                            );
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a(
                                '',
                                Url::toRoute(
                                    [
                                        '/images/delete-image',
                                        'id' => strval($key)
                                    ]
                                ),
                                [
                                    'class' => 'glyphicon glyphicon-trash'
                                ]
                            );
                        }
                    ]
                ],
                ],
            ]);
        ?>
    </div>
</div>