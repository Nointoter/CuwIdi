<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

$this->title = "Project $project->name ";
$this->params['breadcrumbs'][] = $this->title;
Pjax::begin();
$form = ActiveForm::begin([
    'action' => '/site/add-options-project?id='.strval($project->id),
]) ?>

    <div class="row">
        <div class="col-lg-5">
            <h1>Project : <?= Html::encode($project->name) ?></h1>
        </div>
        <div class="col-lg-1">
            <p></p>
        </div>
        <div class="col-lg-5">
            <h2><?= $image ?></h2>
        </div>
    </div>
    <p><?= Html::encode($project->info) ?></p>
    <h3>Добавить опции </h3>
    <div class="row">
        <div class="col-lg-5">
            <?= $form->field($formModel, 'options_name')->textInput(['autofocus' => true]) ?>
        </div>
        <div class="col-lg-1">
            <p></p>
        </div>
        <div class="col-lg-5">
            <?= $form->field($formModel, 'options_value')->textInput(['autofocus' => true]) ?>
        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary', 'name' => 'add-projects-options-button']) ?>
    </div>
<?php ActiveForm::end() ?>
<div class="view-options">

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'projects_id',
            'filter' => Select2::widget([
                'name' => 'projects_id',
                'model' => $searchModel,
                'attribute' => 'projects_id',
                'data' => $projects_id,
                'theme' => Select2::THEME_BOOTSTRAP,
                'value' => $searchModel->projects_id,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Выберите значение'
                ],
                'pluginOptions' => [
                    'selectOnClose' => true,
                    'allowClear' => true,
                ]
            ]),
        ],
        [
            'attribute' => 'options_name',
            'filter' => Select2::widget([
                'name' => 'options_name',
                'model' => $searchModel,
                'attribute' => 'options_name',
                'data' => $options_name,
                'theme' => Select2::THEME_BOOTSTRAP,
                'value' => $searchModel->options_name,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Выберите значение'
                ],
                'pluginOptions' => [
                    'selectOnClose' => true,
                    'allowClear' => true,
                ]
            ]),
        ],
        [
            'attribute' => 'options_value',
            'filter' => Select2::widget([
                'name' => 'options_value',
                'model' => $searchModel,
                'attribute' => 'options_value',
                'data' => $options_value,
                'theme' => Select2::THEME_BOOTSTRAP,
                'value' => $searchModel->options_value,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => 'Выберите значение'
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
                    return Html::a('', ['/site/option?options_id='.strval($model->options_id)], ['class' => 'glyphicon glyphicon-eye-open']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('', [], ['class' => '']);
                },
                'delete' => function ($url, $model, $key){
                    return Html::a('', ['/site/delete-option?id='.\strval($key).'&mainid='.strval($model->projects_id),], ['class' => 'glyphicon glyphicon-trash']);
                }
            ]
        ],
    ],
])?>
<?php Pjax::end(); ?>
</div>



