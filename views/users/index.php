<?php

/* @var $this yii\web\View */
/* @var $form \yii\bootstrap\ActiveForm */
/* @var $model app\models\Ideas */

use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\models\User;

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
                <?/*= Html::a('Reset', ['class' => 'btn btn-default', 'name' => 'reset-ideas-button']) */?>
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
                    'data' => $id_users,
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
                        return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => '']);
                        /*$user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
                        if ($user->users_role == 'admin'){
                            return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                        } else {
                            if (Yii::$app->user->id != $model->creators_id) {
                                return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => '']);
                            } else {
                                return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                            }
                        }*/
                    }
                ]
            ],
        ],
    ])?>
</div>