<?php

use app\models\User;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Carousel;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $commentModel app\models\AddCommentForm */
/* @var $commentsProvider \yii\data\ActiveDataProvider */
/* @var $carousel []*/

$user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
$this->title = 'Просмотр идеи '.strval($model->ideas_name);
?>
<div class="row idea-style pull-right">
    <?php if (Yii::$app->user->id == $model->creators_id || $user->users_role == 'admin') : ?>
    <a href="re-idea?id=<?= strval($model->id_ideas) ?>" class="btn btn-primary" role="button">
        Редактировать
    </a>
    <?php endif; ?>
</div>
<?php Pjax::begin(['id' => 'new_name']); ?>
    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'newNameForm'])?>
        <div class="row idea-style">
            <div class="form-group">
                <div class="col-lg-3">
                    <h3>Название:</h3>
                </div>
                <div class="col-lg-9">
                    <?php
                    echo '<h3>'. Html::encode($model->ideas_name).'</h3>';
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
                        $array_tags[] = strval($tag->tag);
                    }
                    ?>
                    <h3>
                        <?= implode(", ", $array_tags) ?>
                    </h3>
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
                </div>
                <div class="col-lg-2">
                </div>
                <div class="pull-right">
                    <p>
                    </p>
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
                    echo '<h3>' .
                         Html::encode($model->info_short)
                         . '</h3>';
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
                    echo '<h3>' .
                         Html::encode($model->info_long)
                         . '</h3>';
                    ?>
                </div>
            </div>
        </div>
        <div class="row idea-style">
            <div class="form-group">
                <div class="pull-right">
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


