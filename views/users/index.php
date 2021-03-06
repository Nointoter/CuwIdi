<?php

use app\models\Comments;
use app\models\Ideas;
use app\models\SearchUsers;
use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var yii\web\View $this */
/* @var ActiveForm $form */
/* @var Ideas $model*/
/* @var SearchUsers[] $usersProvider */
/* @var User[] $allUsers */

$this->title = 'Пользователи';
?>
<div class="search-users">
    <div class="row">
        <div class="col-lg-6">
            <?php $form = ActiveForm::begin(['action' => '/users', 'method' => 'get']); ?>
            <?= $form->field($model, 'usersSearch')->label('Поиск пользователей') ?>
            <div class="form-group">
                <?= Html::submitButton(
                    'Поиск',
                    ['class' => 'btn btn-primary', 'name' => 'search-users-button']
                ) ?>
                <?php ActiveForm::end(); ?>
                <a href="users" class="btn btn-default" role="button">Очистить</a>
            </div>
        </div>
    </div>
</div>
<div class="view-users">
    <?php Pjax::begin(['id' => 'userListPjax']); ?>
    <?= GridView::widget([
        'dataProvider' => $usersProvider,
        'filterModel' => $model,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'label' => 'Имя',
                'contentOptions' => [
                    'style'=>'white-space: normal; width : 150px;',
                    'class' => 'users-index-style'
                ],
                'value' => function ($data) {
                    return Html::a(
                        Html::encode($data->users_name),
                        Url::toRoute(['/users/profile', 'id' => $data->id_users])
                    );
                },
                'format' => 'raw',
            ],
            [
                'label' => 'Информация',
                'contentOptions' => [
                    'style' => 'width : 250px;',
                    'class' => 'users-index-style'
                ],
                'value' => function ($model) {
                    if ($model->users_info != null) {
                        return $model->users_info;
                    } else {
                        return '';
                    }
                },
            ],
            [
                'label' => 'Изображение',
                'format' => 'html',
                'contentOptions' => [
                    'style' => 'width : 170px;',
                    'class' => 'users-index-style'
                ],
                'value' => function ($model) {
                    if ($model->users_image != null) {
                        return Html::img($model->getImageUrl(), [
                            'width' => '140px',
                            'height' => '140px'
                        ]);
                    } else {
                        return '';
                    }
                },
            ],
            [
                'attribute' => 'users_role',
                'label' => 'Роль',
                'filter' => Select2::widget([
                    'name' => 'users_role',
                    'model' => $model,
                    'attribute' => 'users_role',
                    'data' => ArrayHelper::map($allUsers, 'users_role', 'users_role'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $model->users_role,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
                'contentOptions' => [
                    'style' => 'width : 170px;',
                    'class' => 'users-index-style'
                ],
                'visible' => ((User::find()->where(['id_users' => Yii::$app->user->id])
                    ->one())->users_role == 'admin'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => [
                    'style' => 'width : 60px;',
                    'class' => 'users-index-style'
                ],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '',
                            Url::toRoute(['/users/profile', 'id' => strval($key)]),
                            ['class' => 'glyphicon glyphicon-eye-open']
                        );
                    },
                    'update' => function ($url, $model, $key) {
                        if (!(User::findIdentity($key))->isActive()) {
                            return Html::a(
                                '',
                                Url::toRoute([
                                    '/users/re-status',
                                    'id' => strval($key),
                                    'bool' => strval(true)
                                ]),
                                [
                                    'data-confirm' => 'Вы уверены, что хотите востановить профиль?',
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'class' => 'glyphicon glyphicon-off',
                                    'name' => 're-status-user-button',
                                ]
                            );
                        } else {
                            return Html::a(
                                '',
                                Url::toRoute(['/users/freeze', 'id' => strval($key), 'bool' => strval(true)]),
                                [
                                    'data-confirm' => 'Вы уверены, что хотите заморзить профиль?',
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                    'class' => 'glyphicon glyphicon-time',
                                    'name' => 'freeze-user-button',
                                ]
                            );
                        }
                    },
                    'delete' => function ($url, $model, $key) {
                        $ideas = Ideas::find()->where(['creators_id' => $key])->all();
                        $comments = Comments::find()->where(['users_id' => $key])->all();
                        if ($ideas || $comments) {
                            return Html::a(
                                '<span class="glyphicon glyphicon-trash">
                                </span>',
                                '',
                                [
                                    'class' => 'modalButtonDeleteUserUsersIndex',
                                    'name' => 'delete-user-button',
                                ]
                            );
                        } else {
                            return Html::a(
                                '',
                                false,
                                [
                                    'class' => 'glyphicon glyphicon-trash pjax-delete-link',
                                    'delete-url' => Url::toRoute(['/users/delete', 'id' => strval($key),]),
                                    'pjax-confirm' => 'Вы уверены, что хотите удалить профиль?',
                                    'pjax-container' => 'userListPjax',
                                    'title' => Yii::t('yii', 'Delete'),
                                ]
                            );
                        }
                    },
                ],
                'visible' => ((User::find()->where(['id_users' => Yii::$app->user->id])
                    ->one())->users_role == 'admin'),
            ],
        ],
    ])?>
    <?php Pjax::end(); ?>
</div>
<?php
    Modal::begin([
        'header' => '<h4>
                        Невозможно удалить пользователя
                    </h4>',
        'id' => 'modalDeleteUserUsersIndex',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContentDeleteUserUsersIndex'>
            У пользователя остались идеи
         </div>";
    Modal::end();
?>

