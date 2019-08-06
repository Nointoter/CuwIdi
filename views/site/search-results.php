<?php

use app\models\Ideas;
use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $ideasProvider \yii\data\ActiveDataProvider*/
/* @var $ideasModel \app\models\SearchIdeas*/
/* @var $usersProvider \yii\data\ActiveDataProvider*/
/* @var $usersModel \app\models\SearchUsers*/
/* @var $commentsProvider \yii\data\ActiveDataProvider*/
/* @var $commentsModel \app\models\SearchComments*/



$this->title = 'Результаты поиска: '.strval($target);
$this->params['breadcrumbs'][] = $this->title;

?>
<?php if ($ideasProvider->totalCount > 0) : ?>
    <h2>Идеи</h2>
<div class="view-ideas-results">
    <?= GridView::widget([
        'dataProvider' => $ideasProvider,
        'filterModel' => $ideasModel,
        'columns' => [
            [
                'attribute' => 'id_ideas',
                'label' => 'Id',
                'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'ideas_name',
                'label' => 'Имя',
                'contentOptions'=>['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'info_short',
                'label' => 'Описание',
                'contentOptions'=>['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'creators_id',
                'label' => 'Создатель',
                'contentOptions'=>['style'=>'white-space: normal; width : 150px; background-color: #FFFFFF; color: #000000'],
                'value' => function ($data) {
                    return Html::a(Html::encode($data->getAuthorsName()), Url::toRoute(['/users/profile', 'id' => $data->creators_id]));
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Тэги',
                'contentOptions'=>['style'=>'width : 150px; background-color: #FFFFFF; color: #000000'],
                'format' => 'raw',
                'value' => function ($data) {
                    $array_tags = [];
                    foreach($data->ideas_tags as $tag) {
                        $array_tags[] = strval($tag->tag).' ';
                    }
                    return implode(", ", $array_tags);
                },
            ],
            [
                'attribute' => 'creations_day',
                'label' => 'День',
                'contentOptions'=>['style'=>'width : 90px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'creations_month',
                'label' => 'Месяц',
                'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'attribute' => 'creations_year',
                'label' => 'Год',
                'contentOptions'=>['style'=>'width : 90px; background-color: #FFFFFF; color: #000000'],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width : 60px; background-color: #FFFFFF; color: #000000'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                    },
                    'delete' => function ($url, $model, $key){
                        $user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
                        if ($user->users_role == 'admin'){
                            return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                        } else {
                            if (Yii::$app->user->id != $model->creators_id) {
                                return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key), 'bool' => false]), ['class' => '']);
                            } else {
                                return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key), 'bool' => false]), ['class' => 'glyphicon glyphicon-trash']);
                            }
                        }
                    }
                ]
            ],
        ],
    ])?>
</div>
<?php else: ?>
    <h2>Идей нет</h2>
<?php endif; ?>
<?php if ($usersProvider->totalCount > 0) : ?>
    <h2>Пользователи</h2>
    <div class="view-users-results">
        <?= GridView::widget([
            'dataProvider' => $usersProvider,
            'filterModel' => $usersModel,
            'columns' => [
                [
                    'attribute' => 'id_users',
                    'label' => 'Id',
                    'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
                ],
                [
                    'label' => 'Имя',
                    'contentOptions'=>['style'=>'white-space: normal; width : 150px; background-color: #FFFFFF; color: #000000'],
                    'value' => function ($data) {
                        return Html::a(Html::encode($data->users_name), Url::toRoute(['/users/profile', 'id' => $data->id_users]));
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Информация',
                    'contentOptions'=>['style'=>'width : 250px; background-color: #FFFFFF; color: #000000'],
                    'value' => function ($model) {
                        if ($model->users_info != null)
                            return $model->users_info;
                        else
                            return '';
                    },
                ],
                [
                    'label' => 'Изображение',
                    'format' => 'html',
                    'contentOptions' => ['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
                    'value' => function ($model) {
                        if ($model->users_image != null)
                            return Html::img($model->getImageUrl(), [
                                'width' => '140px',
                                'height' => '140px'
                            ]);
                        else
                            return '';
                    },
                ],
                [
                    'attribute' => 'users_role',
                    'label' => 'Роль',
                    'contentOptions' => ['style'=>'width : 170px; background-color: #FFFFFF; color: #000000'],
                    'visible' => ((User::find()->where(['id_users' => Yii::$app->user->id])->one())->users_role == 'admin'),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width : 60px; background-color: #FFFFFF; color: #000000'],
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('', Url::toRoute(['/users/profile' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                        },
                        'delete' => function ($url, $model, $key){
                            $ideas = Ideas::find()->where(['creators_id' => $key])->all();
                            if ($ideas) {
                                return Html::a('', '', [
                                    'class' => 'glyphicon glyphicon-trash',
                                    'name' => 'delete-user-button',
                                    'id' => 'modalButton5']);
                            } else {
                                return Html::a('', Url::toRoute(['/users/delete', 'id' => strval($key),]), [
                                    'data-confirm' => 'Вы уверены, что хотите удалить профиль?',
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'class' => 'glyphicon glyphicon-trash',
                                    'name' => 'delete-user-button',]);
                            }
                        }
                    ],
                    'visible' => ((User::find()->where(['id_users' => Yii::$app->user->id])->one())->users_role == 'admin'),
                ],
            ],
        ])?>
    </div>
    <?php
        Modal::begin([
            'header' => '<h4>Невозможно удалить пользователя</h4>',
            'id' => 'modal5',
            'size' => 'modal-lg',
        ]);
        echo "<div id='modalContent5'>У пользователя остались идеи</div>";
        Modal::end();
    ?>
<?php else: ?>
    <h2>Пользователей нет</h2>
<?php endif; ?>
<?php if ($commentsProvider->totalCount > 0) : ?>
    <h2>Комментарии</h2>
    <div class="view-comments-results">
        <?= GridView::widget([
            'dataProvider' => $commentsProvider,
            'filterModel' => $commentsModel,
            'columns' => [
                [
                    'attribute' => 'id_comments',
                    'label' => 'Id',
                    'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
                ],
                [
                    'label' => 'Комментрарий',
                    'contentOptions'=>['style'=>'width : 250px; background-color: #FFFFFF; color: #000000'],
                    'value' => function ($model) {
                        if ($model->comment != null)
                            return $model->comment;
                        else
                            return '';
                    },
                ],
                [
                    'attribute' => 'creators_id',
                    'label' => 'Комментатор',
                    'contentOptions'=>['style'=>'width : 100px; background-color: #FFFFFF; color: #000000'],
                    'value' => function ($data) {
                        return Html::a(Html::encode($data->getAuthorsName()), Url::toRoute(['/users/profile', 'id' => $data->users_id]));
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width : 60px; background-color: #FFFFFF; color: #000000'],
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($model->ideas_id),]), ['class' => 'glyphicon glyphicon-eye-open']);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                        },
                        'delete' => function ($url, $model, $key){
                            return Html::a('',  Url::toRoute(['/site/delete-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                        }
                    ],
                ],
            ],
        ])?>
    </div>
<?php else: ?>
    <h2>Комментариев нет</h2>
<?php endif; ?>
