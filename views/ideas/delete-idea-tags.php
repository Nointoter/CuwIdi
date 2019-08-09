<?php

use app\models\Ideas;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $ideasModel app\models\Ideas */
/* @var $imagesProvider \yii\data\ActiveDataProvider*/

$this->title = 'Удаление тэгов идеи : '.strval($ideasModel->ideas_name);

?>
<div class="row">
    <h2><?= $this->title ?></h2>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="col-lg-4 col-lg-offset-4">
            <?php
            echo '<br>
                      <br>
                      <br>
                      <br>
                      <br>
                      <a href="idea?id=' . strval($ideasModel->id_ideas) . '" class="btn btn-primary" role="button">
                        Вернуться на<br>страницу идеи
                      </a>';
            ?>
        </div>
    </div>
    <div class="col-lg-6">
        <?= GridView::widget([
            'dataProvider' => $tagsProvider,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'label' => 'Тэги',
                    'attribute' => 'tag',
                ],
                [
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
                                        '/tags/delete-tag',
                                        'id' => strval($key),
                                        'bool' => 'true',
                                        'tag' => null
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
                                        '/tags/delete-tag',
                                        'tag' => '',
                                        'id' => strval($key),
                                        'bool' => 'true'
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