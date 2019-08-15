<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $ideasModel app\models\Ideas */
/* @var $imagesProvider \yii\data\ActiveDataProvider*/

$this->title = 'Удаление тэгов идеи : '.strval($ideasModel->ideas_name);

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
    <?php Pjax::begin(['id' => 'tagListPjax']); ?>
    <div class="col-lg-8 col-lg-offset-2">
        <?= GridView::widget([
            'dataProvider' => $tagsProvider,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'label' => 'Тэги',
                    'attribute' => 'tag',
                    'contentOptions'=>[
                        'class' => 'delete-idea-tags-style'
                    ],
                ],
                [
                    'contentOptions'=>[
                        'style'=>'width : 50px;',
                        'class' => 'delete-idea-tags-style'
                    ],
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',
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
                        'delete' => function ($url, $model, $key) {
                            return Html::a(
                                '',
                                false,
                                [
                                    'class' => 'glyphicon glyphicon-trash pjax-delete-link',
                                    'delete-url' => Url::toRoute(
                                        [
                                            '/tags/delete-tag',
                                            'tag' => '',
                                            'tags_id' => strval($key),
                                            'bool' => 'true'
                                        ]
                                    ),
                                    'pjax-confirm' => 'Вы уверены, что хотите удалить тэг?',
                                    'pjax-container' => 'tagListPjax',
                                    'title' => Yii::t('yii', 'Delete'),
                                ]
                            );
                        }
                    ]
                ],
            ],
        ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>
