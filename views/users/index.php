<?php

use app\models\Comments;
use app\models\Ideas;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;
use app\models\SearchUsers;

/* @var yii\web\View $this */
/* @var ActiveForm $form */
/* @var Ideas $model*/
/* @var SearchUsers[] $dataProvider */
/* @var SearchUsers $searchModel */
/* @var User[] $allUsers */

$this->title = 'Пользователи';
?>
<div class="search-users">
    <div class="row">
        <div class="col-lg-6">

            <?php $form = ActiveForm::begin(['action' => '/users', 'method' => 'get']); ?>

            <?= $form->field($model, 'usersSearch')->label('Поиск пользователей') ?>

            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary', 'name' => 'search-users-button']) ?>
                <?php ActiveForm::end(); ?>
                <a href="users" class="btn btn-default" role="button">Очистить</a>
            </div>
        </div>
    </div>
</div>
<div class="view-users">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id_users',
                'label' => 'Id',
                'contentOptions'=>['style'=>'width : 95px; background-color: #FFFFFF; color: #000000'],
                'filter' => Select2::widget([
                    'name' => 'id_users',
                    'model' => $searchModel,
                    'attribute' => 'id_users',
                    'data' => ArrayHelper::map($allUsers,'id_users', 'id_users'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->id_users,
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
                'filter' => Select2::widget([
                    'name' => 'users_role',
                    'model' => $searchModel,
                    'attribute' => 'users_role',
                    'data' => ArrayHelper::map($allUsers, 'users_role', 'users_role'),
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->users_role,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => ''
                    ],
                    'pluginOptions' => [
                        'selectOnClose' => true,
                        'allowClear' => true,
                    ]
                ]),
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
                    'update' => function ($url, $model, $key){
                        if ((User::findIdentity($key))->status) {
                            return Html::a('', Url::toRoute(['/users/re-status', 'id' => strval($key), 'bool' => strval(true)]), [
                                'data-confirm' => 'Вы уверены, что хотите востановить профиль?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'glyphicon glyphicon-off',
                                'name' => 're-status-user-button',]);
                        } else {
                            return Html::a('', Url::toRoute(['/users/freeze', 'id' => strval($key), 'bool' => strval(true)]), [
                                'data-confirm' => 'Вы уверены, что хотите заморзить профиль?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'glyphicon glyphicon-time',
                                'name' => 'freeze-user-button',]);
                        }
                    },
                    'delete' => function ($url, $model, $key){
                        $ideas = Ideas::find()->where(['creators_id' => $user->id_users])->all();
                        $comments = Comments::find()->where(['users_id' => $user->id_users])->all();
                        if ($ideas || $comments) {
                            return Html::a('', '', [
                                'class' => 'glyphicon glyphicon-trash',
                                'name' => 'delete-user-button',
                                'id' => 'modalButton3']);
                        } else {
                            return Html::a('', Url::toRoute(['/users/delete', 'id' => strval($key),]), [
                                'data-confirm' => 'Вы уверены, что хотите удалить профиль?',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'glyphicon glyphicon-trash',
                                'name' => 'delete-user-button',]);
                        }
                    },
                ],
                'visible' => ((User::find()->where(['id_users' => Yii::$app->user->id])->one())->users_role == 'admin'),
            ],
        ],
    ])?>
</div>
<?php
    Modal::begin([
        'header' => '<h4>Невозможно удалить пользователя</h4>',
        'id' => 'modal3',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent3'>У пользователя остались идеи</div>";
    Modal::end();
?>
