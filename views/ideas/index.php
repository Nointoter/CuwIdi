<?php

use app\models\Ideas;
use app\models\User;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Ideas */
/* @var Ideas[] $allIdeas */
/* @var Ideas[] $ideasProvider */
/* @var $ideasSearch \app\models\SearchIdeas*/

$this->title = 'Идеи';
?>
<div class="search-ideas">
    <div class="row ideas-index-style">
        <div class="col-lg-6">
            <?php
            $form = ActiveForm::begin(
                [
                    'options' => [
                        'data-pjax' => true
                    ],
                    'action' => '/ideas',
                    'method' => 'get',
                    'id' => 'searchInIndex'
                ]
            );
            ?>
            <?= $form->field($model, 'ideasSearch')->label('Поиск Идей') ?>
            <div class="form-group">
                <?=
                Html::submitButton(
                    'Поиск',
                    [
                        'class' => 'btn btn-primary',
                        'name' => 'search-ideas-button'
                    ]
                ) ?>
                <a href="ideas" class="btn btn-default" role="button">Очистить</a>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="add-ideas">
    <div class="row ideas-index-style">
        <div class="col-lg-6">
            <div class="form-group">
                <?php
                if (!Yii::$app->user->isGuest) {
                    if (User::findIdentity(Yii::$app->user->id)->isActive()) {
                        echo Html::button(
                            'Добавить идею',
                            [
                                'value' => Url::to('/ideas/add-idea?bool=' . strval(false)),
                                'class' => 'btn btn-success',
                                'name' => 'add-idea-button',
                                'id' => 'modalButtonAddIdea'
                            ]
                        );
                    } else {
                        echo '<html> 
                                 <body> 
                                     <h4>Для добавления идеи востановите свой аккаунт </h4> 
                                 </body> 
                             </html>';
                    }
                } else {
                    echo '<html>
                             <body> 
                                 <h4>Для добавления идеи войдите в аккаунт </h4> 
                             </body> 
                         </html>';
                }
                ?>
                </div>
            <?php
            Modal::begin(
                [
                    'header' => '<h4>Добавить идею</h4>',
                    'id' => 'modalAddIdea',
                    'size' => 'modal-lg',
                ]
            );
            echo "<div id='modalContentAddIdea'></div>";
            Modal::end();
            ?>
        </div>
    </div>
</div>
<div class="view-ideas">
    <?php Pjax::begin(['id' => 'ideaListPjax']); ?>
    <?= GridView::widget(
        [
            'dataProvider' => $ideasProvider,
            'filterModel' => $ideasSearch,
            'layout' => '{items}{pager}',
            'columns' => [
                [
                    'attribute' => 'id_ideas',
                    'label' => 'Id',
                    'contentOptions'=>[
                        'style'=>'width : 95px;',
                        'class' => 'ideas-index-style',
                    ],
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
                    'contentOptions'=>[
                        'style' => 'width : 170px;',
                        'class' => 'ideas-index-style',
                    ],
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
                    'contentOptions'=>[
                        'style'=>'width : 170px;',
                        'class' => 'ideas-index-style',
                    ],
                ],
                [
                    'attribute' => 'users_name',
                    'label' => 'Создатель',
                    'contentOptions' => [
                        'style' => 'white-space: normal; width : 150px;',
                        'class' => 'ideas-index-style',
                    ],
                    'value' => function ($data) {
                        if ((User::findIdentity($data->creators_id))->isActive()) {
                            return Html::a(
                                $data->user->users_name,
                                Url::toRoute(['/users/profile', 'id' => $data->creators_id])
                            );
                        } else {
                            return "заморожен";
                        }
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Тэги',
                    'contentOptions' => [
                        'style' => 'width : 150px;',
                        'class' => 'ideas-index-style',
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
                    'contentOptions' => [
                        'style' => 'width : 90px;',
                        'class' => 'ideas-index-style',
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
                        'style' => 'width : 95px;',
                        'class' => 'ideas-index-style',
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
                        'style' => 'width : 90px;',
                        'class' => 'ideas-index-style',
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
                        'style' => 'width : 60px;',
                        'class' => 'ideas-index-style',
                    ],
                    'template' => '{view}{delete}',
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
                        'delete' => function ($url, $model, $key) {
                            $user = User::find()->where(['id_users' => Yii::$app->user->id])->one();
                            if ($user->users_role == 'admin' || Yii::$app->user->id == $model->creators_id) {
                                return Html::a(
                                    '',
                                    false,
                                    [
                                        'class' => 'glyphicon glyphicon-trash pjax-delete-link',
                                        'delete-url' => Url::toRoute(
                                            [
                                                '/ideas/delete-idea',
                                                'id' => strval($key),
                                            ]
                                        ),
                                        'pjax-confirm' => 'Вы уверены, что хотите удалить идею?',
                                        'pjax-container' => 'ideaListPjax',
                                        'title' => Yii::t('yii', 'Delete')
                                    ]
                                );
                            }
                        }
                    ]
                ],
            ],
        ]
    ) ?>
    <?php Pjax::end(); ?>
</div>

