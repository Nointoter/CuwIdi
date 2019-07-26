<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $image  */
/* @var $user app\models\User */

use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$form = ActiveForm::begin();

$this->title = 'Профиль ' . strval($user->users_name);
?>
    <div class="row">
        <div class="col-lg-3">
            <h2>Профиль <?= Html::encode($user->users_name) ?></h2>
            <?php
                if (Yii::$app->user->id == $user->id_users){
                    echo '<h4>Логин : '.Html::encode($user->username).'</h4>
                          <h4>Пароль : '.Html::encode($user->password).'</h4>';
                    echo Html::button('Сменить пароль',['value' => Url::to('/users/change-password'),'class' => 'btn btn-success', 'name' => 'change-password-button', 'id' => 'modalButton2']);
                    Modal::begin([
                        'header' => '<h4>Сменить пароль</h4>',
                        'id' => 'modal2',
                        'size' => 'modal-lg',
                    ]);
                    echo "<div id='modalContent2'></div>";
                    Modal::end();
                }
            ?>
        </div>
        <div class="col-lg-3">
            <h2><?= $image ?></h2>
        </div>
        <div class="col-lg-3">
            <?= $form->field($image_model, 'imageFile')->fileInput(['autofocus' => true]) ?>

        </div>
        <div class="col-lg-3">
            <?php
                if (Yii::$app->user->id == $user->id_users) {
                    echo '<h1><br></h1>';
                    echo '<html><body><a href="re-profile?id=' . strval($user->id_users) . '" class="btn btn-primary" role="button">Редактировать<br> информацию</a></body></html>';
                }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <h2>Информация : </h2>
            <h4><?php
                if (Yii::$app->user->id == $user->id_users)
                    echo Html::submitButton('Изменить <br> информацию', ['class' => 'btn btn-info', 'name' => 'change-user-info-button']);
                ?>
            </h4>
        </div>
        <div class="col-lg-9">
            <?php
            if (Yii::$app->user->id != $user->id) {
                echo '<h2><textarea readonly rows="10" cols="50">' . Html::encode($user->users_info) . '</textarea></h2>';
            } else {
                echo '<h2>'.$form->field($infoModel, 'info')->textarea(['autofocus' => true, 'rows' => 10, 'cols' => 50])->label(false).'</h2>';
            }
            ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>
<div class="row">
    <div class="col-lg-4">
        <h2>
            Идеи пользователя
        </h2>
    </div>
</div>
<div class="view-ideas">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items}{pager}',
        'columns' => [
            [
                'attribute' => 'id_ideas',
                'label' => 'Id',
                'contentOptions'=>['style'=>'width : 200px;'],
                'filter' => Select2::widget([
                    'name' => 'id_ideas',
                    'model' => $searchModel,
                    'attribute' => 'id_ideas',
                    'data' => $id_ideas,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->id_ideas,
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
                //'contentOptions'=>['style'=>'white-space: normal;'],
                'contentOptions'=>['style'=>'width : 300px;'],
                'filter' => Select2::widget([
                    'name' => 'ideas_name',
                    'model' => $searchModel,
                    'attribute' => 'ideas_name',
                    'data' => $ideas_name,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->ideas_name,
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
                'label' => 'Тэги',
                'contentOptions'=>['style'=>'width : 150px;'],
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
                'contentOptions'=>['style'=>'width : 180px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_day',
                    'model' => $searchModel,
                    'attribute' => 'creations_day',
                    'data' => $creations_day,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_day,
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
                'contentOptions'=>['style'=>'width : 200px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_month',
                    'model' => $searchModel,
                    'attribute' => 'creations_month',
                    'data' => $creations_month,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_month,
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
                'contentOptions'=>['style'=>'width : 180px;'],
                'filter' => Select2::widget([
                    'name' => 'creations_year',
                    'model' => $searchModel,
                    'attribute' => 'creations_year',
                    'data' => $creations_year,
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'value' => $searchModel->creations_year,
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
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('', Url::toRoute(['/ideas/idea' , 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-eye-open']);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('',  Url::toRoute(['/site/re-project', 'id' => strval($key), 'bool' => 'false']), ['class' => '']);
                    },
                    'delete' => function ($url, $model, $key){
                        return Html::a('', Url::toRoute(['/ideas/delete-idea', 'id' => strval($key),]), ['class' => 'glyphicon glyphicon-trash']);
                    }
                ]
            ],
        ],
    ])?>
</div>
