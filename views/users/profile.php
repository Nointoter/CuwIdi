<?php

use app\models\Comments;
use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $user app\models\User */
/* @var $commentsProvider \yii\data\ActiveDataProvider*/
/* @var $commentsSearch \app\models\SearchComments*/
/* @var $ideasProvider \yii\data\ActiveDataProvider*/
/* @var $ideasSearch \app\models\SearchIdeas*/

$form = ActiveForm::begin();

$this->title = 'Профиль ' . strval($user->users_name);
?>
<?php if ($user->isActive()) : ?>
    <div class="row profile-style">
        <div class="col-lg-5">
            <h2>Профиль <?= Html::encode($user->users_name) ?></h2>
            <?php if (Yii::$app->user->id == $user->id_users) : ?>
                <a href="re-profile?id=<?= strval($user->id_users) ?>" class="btn btn-primary" role="button">
                    Редактировать
                </a>
                <h4>
                    Логин : <?= Html::encode($user->username) ?>
                </h4>
                <h4>
                    <?= Html::button('Сменить пароль', [
                        'value' => Url::to('/users/change-password'),
                        'class' => 'btn btn-success',
                        'name' => 'change-password-button',
                        'id' => 'modalButtonChangePassword'
                    ]) ?>
                </h4>
            <?php endif; ?>
        </div>
        <div class="col-lg-4">
            <h2>
                <?= Html::img('@web/images/' . $user->users_image, [
                    'width' => '160px',
                    'height' => '160px'
                ]); ?>
            </h2>
        </div>
    </div>
    <div class="row profile-style">
        <?php if ($user->users_info) : ?>
            <div class="col-lg-3">
                <h3>
                    Информация:
                </h3>
            </div>
            <div class="col-lg-9">
                <?php
                    echo '<h4><br>' . Html::encode($user->users_info) . '</h4>';
                ?>
            </div>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>
    <div class="row profile-style">
        <div class="col-lg-12">
            <?php if ($ideasProvider->totalCount > 0) : ?>
                <h2>
                    Идеи пользователя
                </h2>
            <?php endif ?>
        </div>
    </div>
    <?php if ($ideasProvider->totalCount > 0) : ?>
        <div class="view-ideas profile-style">
            <?= GridView::widget([
                'dataProvider' => $ideasProvider,
                'filterModel' => $ideasSearch,
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'id_ideas',
                        'label' => 'Id',
                        'contentOptions'=>[
                            'style'=>'width : 100px;', 'profile-style'
                        ],
                    ],
                    [
                        'attribute' => 'ideas_name',
                        'label' => 'Имя',
                        'contentOptions'=>[
                            'style'=>'width : 300px;', 'profile-style'
                        ],
                    ],
                    [
                        'label' => 'Тэги',
                        'contentOptions'=>[
                            'style'=>'width : 250px;', 'profile-style'
                        ],
                        'format' => 'raw',
                        'value' => function ($data) {
                            $array_tags = [];
                            foreach ($data->tags as $tag) {
                                $array_tags[] = strval($tag->tag) . ' ';
                            }
                            return implode(", ", $array_tags);
                        },
                    ],
                    [
                        'attribute' => 'creations_day',
                        'label' => 'День',
                        'contentOptions'=>[
                            'style'=>'width : 100px;', 'profile-style'
                        ],
                    ],
                    [
                        'attribute' => 'creations_month',
                        'label' => 'Месяц',
                        'contentOptions'=>[
                            'style'=>'width : 150px;', 'profile-style'
                        ],
                    ],
                    [
                        'attribute' => 'creations_year',
                        'label' => 'Год',
                        'contentOptions'=>[
                            'style'=>'width : 130px;', 'profile-style'
                        ],
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions'=>[
                            'style'=>'width : 50px;', 'profile-style'
                        ],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(['/ideas/idea' , 'id' => strval($key),]),
                                    ['class' => 'glyphicon glyphicon-eye-open']
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']),
                                    ['class' => '']
                                );
                            },
                            'delete' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(['/ideas/delete-idea', 'id' => strval($key)]),
                                    ['class' => 'glyphicon glyphicon-trash']
                                );
                            }
                        ],
                        'visible' => (Yii::$app->user->id == $user->id_users),
                    ],
                ],
            ])?>
        </div>
    <?php endif; ?>
    <div class="row profile-style">
        <div class="col-lg-12">
            <?php if ($commentsProvider->totalCount > 0) : ?>
            <h2>
                Комментарии пользователя
            </h2>
            <?php endif ?>
        </div>
    </div>
    <?php if ($commentsProvider->totalCount > 0) : ?>
        <div class="view-idea-comments">
            <?php Pjax::begin(['id' => 'commentListPjax']); ?>
            <?= GridView::widget([
                'dataProvider' => $commentsProvider,
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'comment',
                        'label' => 'Комментарий',
                        'contentOptions'=>[
                            'style'=>'width : 500px;', 'profile-style'
                        ],
                    ],
                    [
                        'attribute' => 'ideas_id',
                        'label' => 'Идея',
                        'contentOptions'=>[
                            'style'=>'width : 100px;', 'profile-style'
                        ],
                        'value' => function ($data) {
                            /** @var Comments $data */
                            return Html::a(
                                Html::encode($data->getIdeasName()),
                                Url::toRoute(['/ideas/idea', 'id' => $data->ideas_id])
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'style' => 'width : 50px;', 'profile-style'
                        ],
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(['/ideas/idea' , 'id' => strval($key),])
                                );
                            },
                            'update' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(['/comments/re-comment', 'id' => strval($key), 'bool' => 'false']),
                                    ['class' => '']
                                );
                            },
                            'delete' => function ($url, $model, $key) {
                                if (Yii::$app->user->id != $model->users_id) {
                                    return Html::a(
                                        '',
                                        Url::toRoute(['/comments/delete-comment', 'id' => strval($key),
                                            'bool' => strval(false)]),
                                        ['class' => '']
                                    );
                                } else {
                                    return Html::a(
                                        '',
                                        false,
                                        [
                                            'class' => 'glyphicon glyphicon-trash pjax-delete-link',
                                            'delete-url' => Url::toRoute([
                                                '/comments/delete-comment',
                                                'id' => strval($key),
                                                'bool' => strval(false)
                                            ]),
                                            'pjax-confirm' => 'Вы уверены, что хотите удалить изображение?',
                                            'pjax-container' => 'commentListPjax',
                                            'title' => Yii::t('yii', 'Delete'),
                                        ]
                                    );
                                }
                            },
                        ],
                        'visible' => (Yii::$app->user->id == $user->id_users),
                    ],
                ],
            ])?>
            <?php
            Pjax::end(); ?>
        </div>
    <?php endif; ?>
<?php else : ?>
    <h1>
        Аккаунт временно заблокирован
    </h1>
    <?php if (($user->id_users == Yii::$app->user->id) && (!$user->isAdminFreeze())) : ?>
        <?php
            echo Html::a(
                'Востановить профиль',
                Url::toRoute(['/users/re-status', 'id' => strval($user->id_users), 'bool' => strval(false)]),
                [
                    'data-confirm' => 'Вы уверены, что хотите востановить профиль?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-primary',
                    'name' => 'delete-user-button',
                ]
            );
        ?>
    <?php endif; ?>
<?php endif; ?>
<?php
    Modal::begin([
        'header' => '<h4>
                        Сменить пароль
                    </h4>',
        'id' => 'modalChangePassword',
        'size' => 'modal-lg',
    ]);
        echo "<div id='modalContentChangePassword'></div>";
    Modal::end();
    ?>
