<?php

use app\models\SearchIdeas;
use app\models\User;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Ideas;
use yii\helpers\Url;

/* @var $idea \app\models\Tags*/

$this->title = 'Тэги';

?>
<div class="row">
    <?php foreach ($tags as $tag) : ?>
        <?php

        /*if (($idea->getUser())->isActive()) : */?>
        <div class="row">
            <h2>
                <?= $tag->tag ?>
            </h2>
        </div>
        <?php
        $ideasSearch = new SearchIdeas();
        $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), null, $model->ideasSearch, $tag->tag);
        $allIdeas = Ideas::find()->all();
        ?>
        <div class="view-ideas">
            <?= GridView::widget(
                [
                    'dataProvider' => $ideasProvider,
                    'filterModel' => $ideasSearch,
                    'layout' => '{items}{pager}',
                    'columns' => [
                    [
                        'attribute' => 'id_ideas',
                        'label' => 'Id',
                        'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
                        'filter' => Select2::widget([
                            'name' => 'id_ideas',
                            'model' => $ideasSearch,
                            'attribute' => 'id_ideas',
                            'data' => ArrayHelper::map($allIdeas, 'id_ideas', 'id_ideas'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'value' => $ideasSearch->id_ideas,
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
                        'contentOptions'=>['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
                        'filter' => Select2::widget([
                            'name' => 'ideas_name',
                            'model' => $ideasSearch,
                            'attribute' => 'ideas_name',
                            'data' =>  ArrayHelper::map($allIdeas, 'ideas_name', 'ideas_name'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'value' => $ideasSearch->ideas_name,
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
                        'contentOptions'=>['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
                    ],
                    [
                        'attribute' => 'users_name',
                        'label' => 'Создатель',
                        'contentOptions' => [
                            'style' => 'white-space: normal; width : 150px; background-color: #FFFFFF; color: #000000'
                        ],
                        'value' => function ($data) {
                            if ((User::findIdentity($data->creators_id))->isActive()) {
                                return Html::a(
                                    $data->getUser()->users_name,
                                    Url::toRoute(['/users/profile', 'id' => $data->creators_id])
                                );
                            } else {
                                return "заблокирован";
                            }
                        },
                        'format' => 'raw',
                    ],
                    [
                        'label' => 'Тэги',
                        'contentOptions' => [
                            'style' => 'width : 150px; background-color: #FFFFFF; color: #000000'
                        ],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $array_tags = [];
                            foreach ($data->ideas_tags as $tag) {
                                $array_tags[] = strval($tag->tag) . ' ';
                            }
                            return implode(", ", $array_tags);
                        },
                    ],
                    [
                        'attribute' => 'creations_day',
                        'label' => 'День',
                        'contentOptions' => [
                            'style' => 'width : 90px; background-color: #FFFFFF; color: #000000'
                        ],
                        'filter' => Select2::widget([
                            'name' => 'creations_day',
                            'model' => $ideasSearch,
                            'attribute' => 'creations_day',
                            'data' => ArrayHelper::map($allIdeas, 'creations_day', 'creations_day'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'value' => $ideasSearch->creations_day,
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
                        'contentOptions' => [
                            'style' => 'width : 95px; background-color: #FFFFFF; color: #000000'
                        ],
                        'filter' => Select2::widget([
                            'name' => 'creations_month',
                            'model' => $ideasSearch,
                            'attribute' => 'creations_month',
                            'data' =>  ArrayHelper::map($allIdeas, 'creations_month', 'creations_month'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'value' => $ideasSearch->creations_month,
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
                        'label' => 'Год',
                        'contentOptions' => [
                            'style' => 'width : 90px; background-color: #FFFFFF; color: #000000'
                        ],
                        'filter' => Select2::widget([
                            'name' => 'creations_year',
                            'model' => $ideasSearch,
                            'attribute' => 'creations_year',
                            'data' => ArrayHelper::map($allIdeas, 'creations_year', 'creations_year'),
                            'theme' => Select2::THEME_BOOTSTRAP,
                            'value' => $ideasSearch->creations_year,
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
                        'contentOptions' => [
                            'style' => 'width : 60px; background-color: #FFFFFF; color: #000000'
                        ],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(
                                        ['/ideas/idea', 'id' => strval($key), ]
                                    ),
                                    ['class' => 'glyphicon glyphicon-eye-open']
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
                                    ['class' => '']
                                );
                            },
                            'delete' => function ($url, $model, $key){
                                $user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
                                if ($user->users_role == 'admin'){
                                    return Html::a(
                                        '',
                                        Url::toRoute(
                                            [
                                                '/ideas/delete-idea',
                                                'id' => strval($key),
                                            ]
                                        ),
                                        ['class' => 'glyphicon glyphicon-trash']
                                    );
                                } else {
                                    if (Yii::$app->user->id != $model->creators_id) {
                                        return Html::a(
                                            '',
                                            Url::toRoute(
                                                [
                                                    '/ideas/delete-idea',
                                                    'id' => strval($key),
                                                ]
                                            ),
                                            ['class' => '']
                                        );
                                    } else {
                                        return Html::a(
                                            '',
                                            Url::toRoute(
                                                [
                                                    '/ideas/delete-idea',
                                                    'id' => strval($key),
                                                    'bool' => strval(false),
                                                ]
                                            ),
                                            ['class' => 'glyphicon glyphicon-trash']
                                        );
                                    }
                                }
                            }
                        ]
                    ],
                    ],
                ]
            ) ?>
        </div>
    <?php endforeach; ?>
</div>
