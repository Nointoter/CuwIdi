<?php

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $ideasModel app\models\Ideas */
/* @var $ideasModelName app\models\Ideas */
/* @var $tagModel app\models\AddTagForm */
/* @var $imageModel app\models\ImagesForm */
/* @var $commentModel app\models\AddCommentForm */
/* @var $commentsProvider \yii\data\ActiveDataProvider */
/* @var $carousel []*/

$user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
$this->title = 'Просмотр идеи '.strval($model->ideas_name);
?>
<?php Pjax::begin(['id' => 'new_name']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'newNameForm'])?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>Название:</h3>
                </div>
                <div class="col-lg-9">
                    <?php
                    if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                        echo '<h3>'
                            . $form->field(
                                $ideasModelName,
                                'ideas_name'
                            )->textarea(
                                [
                                    'autofocus' => true,
                                    'cols' => 1,
                                    'rows' => 1
                                ]
                            )->label(false)
                            . '</h3>';
                    } else {
                        echo '<h3>'. Html::encode($model->ideas_name).'</h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>Создатель идеи:</h3>
                </div>
                <div class="col-lg-9">
                    <h3>
                        <a
                            href="/users/profile?id=<?= strval($model->creators_id) ?>"
                            class=""
                            role="button">
                            <?php
                            echo $model->getAuthorsName()
                            ?>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php Pjax::begin(['id' => 'new_tag']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'newTagForm'])?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>
                        Теги:
                    </h3>
                </div>
                <div class="col-lg-9">
                    <?php
                    $array_tags = [];
                    foreach ($model->tags as $tag) {
                        $array_tags[] = strval($tag->tag).' ';
                    }
                    ?>
                    <h3>
                        <?= implode(", ", $array_tags) ?>
                    </h3>
                </div>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-9 col-lg-offset-3">
                    <?php if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') : ?>
                        <?php
                        echo '<h1>'
                            . $form->field(
                                $tagModel,
                                'tag'
                            )->textarea(
                                [
                                    'autofocus' => true,
                                    'cols' => 1,
                                    'rows' => 1
                                ]
                            )->label(false) . '</h1>'; ?>
                        <?php
                        echo Html::submitButton(
                            'Добавить Тэг',
                            [
                                'class' => 'btn btn-primary',
                                'name' => 'add-idea-tag-button'
                            ]
                        ); ?>
                        <div class="pull-right">
                        <?php
                        if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                            echo Html::a(
                                'Удаление Тэгов',
                                Url::toRoute(['/ideas/delete-idea-tags', 'id' => strval($model->id_ideas)]),
                                [
                                    'class' => 'btn btn-danger',
                                ]
                            );
                        }   ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<div class="row idea-style">
    <div class="form-group">
        <p>
        </p>
    </div>
</div>
<?php Pjax::begin(['id' => 'new_image']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'newImageForm'])?>
        <?php if ($carousel != null) : ?>
            <div class="row idea-style">
                <div class="form-group">
                    <table class="table table-hover">
                        <div class="col-lg-12">
                            <body>
                                <tr>
                                    <td>
                                        <div style="height: 500px; overflow:auto;">
                                            <?php
                                                echo Carousel::widget([
                                                    'items' => $carousel,
                                                    'options' => [
                                                        'class' => 'carousel slide',
                                                        'data-interval' => '12000'
                                                    ],
                                                    'controls' => [
                                                        '<span class="glyphicon glyphicon-chevron-left"
                                                        aria-hidden="true">
                                                        </span>',
                                                        '<span class="glyphicon glyphicon-chevron-right"
                                                        aria-hidden="true">
                                                        </span>'
                                                    ]
                                                ]);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </body>
                        </div>
                    </table>
                </div>
            </div>
        <?php endif ?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <?php if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') : ?>
                    <h3>Изображения:</h3>
                    <?php else : ?>
                    <h3></h3>
                    <?php endif ?>
                </div>
                <div class="col-lg-2">
                    <?php
                    if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                        echo $form->field(
                            $imageModel,
                            'imageFile'
                        )->fileInput(
                            [
                                'autofocus' => true
                            ]
                        )->label('Добавить изображение');
                        echo Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'idea-button']);
                    }
                    ?>
                </div>
                <div class="pull-right">
                    <p>
                    </p>
                    <?php
                    if ((Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin')
                        && $carousel != null) {
                            echo
                                '<a 
                                    href="delete-idea-images?id=' . strval($model->id_ideas) . '" 
                                    class="btn btn-danger" 
                                    role="button">
                                    Удалить изображения
                                </a>';
                    }   ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php Pjax::begin(['id' => 'new_info']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'newInfoForm'])?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>Описание:</h3>
                </div>
                <div class="col-lg-9">
                    <?php
                    if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                        echo '<h3>' .
                            $form->field(
                                $ideasModel,
                                'info_short'
                            )->textarea(
                                [
                                   'autofocus' => true,
                                   'rows' => 2,
                                   'cols' => 65
                                ]
                            )->label(false)
                            . '</h3>';
                    } else {
                        echo '<h3>' .
                             Html::encode($model->info_short)
                             . '</h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>Информация:</h3>
                </div>
                <div class="col-lg-9">
                    <?php
                    if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                        echo '<h3>' .
                            $form->field(
                                $ideasModel,
                                'info_long'
                            )->textarea(
                                [
                                    'autofocus' => true,
                                    'rows' => 10,
                                    'cols' => 65
                                ]
                            )->label(false)
                            . '</h3>';
                    } else {
                        echo '<h3>' .
                             Html::encode($model->info_long)
                             . '</h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="pull-right">
                    <?php
                    if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') {
                        echo Html::submitButton(
                            'Созранить изменения',
                            [
                                'class' => 'btn btn-primary',
                                'name' => 'change-idea-info-button'
                            ]
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php Pjax::begin(['id' => 'commentListPjax']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'commentsForm'])?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>
                        Комментарии:
                    </h3>
                </div>
                <?php if (!Yii::$app->user->isGuest) : ?>
                <div class="col-lg-9">
                    <h3>
                        <?= $form->field(
                            $commentModel,
                            'comment'
                        )->textarea(
                            [
                                'autofocus' => true,
                                'rows' => 10,
                                'cols' => 65
                            ]
                        )->label(false) ?>
                    </h3>
                </div>
                <?php else : ?>
                <div class="col-lg-9">
                    <h3>
                        Для добавления комментариев войдите в аккаунт
                    </h3>
                </div>
                <?php endif ?>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="pull-right">
                    <?php if (!Yii::$app->user->isGuest) {
                        echo Html::submitButton(
                            'Добавить комментарий',
                            [
                                'class' => 'btn btn-primary',
                                'name' => 'add-ideas-comment-button'
                            ]
                        );
                        echo '<h3>
                                <br>
                             </h3>';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
    <?php if ($commentsProvider->totalCount > 0) : ?>
        <div class="view-idea-comments">
            <?= GridView::widget([
                'dataProvider' => $commentsProvider,
                'layout' => '{items}{pager}',
                'columns' => [
                    [
                        'attribute' => 'comment',
                        'label' => 'Комментарий',
                        'contentOptions'=>[
                            'style'=>'width : 500px;',
                            'class' => 'idea-style'
                        ],
                    ],
                    [
                        'attribute' => 'creators_id',
                        'label' => 'Комментатор',
                        'contentOptions'=>[
                            'style'=>'width : 100px;',
                            'class' => 'idea-style'
                        ],
                        'value' => function ($data) {
                            return Html::a(
                                Html::encode(
                                    $data->getAuthorsName()
                                ),
                                Url::toRoute(
                                    [
                                        '/users/profile',
                                        'id' => $data->users_id
                                    ]
                                )
                            );
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'style' => 'width : 50px;',
                            'class' => 'idea-style'
                        ],
                        'template' => '{view} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model, $key) {
                                return Html::a(
                                    '',
                                    Url::toRoute(
                                        [
                                             '/ideas/idea',
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
                        ]
                    ],
                ],
            ])?>
        </div>
    <?php endif; ?>
<?php Pjax::end(); ?>
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if (Yii::$app->user->id == $model->creators_id || (User::findIdentity(Yii::$app->user->id))->isAdmin()) : ?>
        <div class="pull-right">
        <?php
            echo Html::a(
                'Удалить Идею',
                Url::toRoute(['/ideas/delete-idea', 'id' => strval($model->id_ideas)]),
                [
                  'data-confirm' => 'Вы уверены, что хотите удалить идею?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-danger btn-lg',
                    'name' => 'delete-idea-button',
                ]
            );
        ?>
    </div>
    <?php endif; ?>
<?php endif; ?>

