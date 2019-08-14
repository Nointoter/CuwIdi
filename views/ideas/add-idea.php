<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $form yii\bootstrap\ActiveForm */
/* @var $ideasModel app\models\IdeasForm */

/*$this->title = 'Добавить идею';
$this->params['breadcrumbs'][] = $this->title;*/

?>
<div class="ideas-add-idea">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        Для добавления идеи заполните данную форму.
    </p>
    <div class="row">
        <div class="col-lg-12">
            <?php /*Pjax::begin(['id' => 'add-idea']) */?>
                <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true], 'id' => 'addNewIdeaForm']); ?>
                    <?= $form->field(
                        $ideasModel,
                        'ideas_name'
                    )->textInput(['autofocus' => true])->label('Имя') ?>
                    <?= $form->field(
                        $ideasModel,
                        'info_short'
                    )->textInput(['autofocus' => true])->label('Описание') ?>
                    <?= $form->field(
                        $ideasModel,
                        'info_long'
                    )->textarea(['rows' => 8, 'autofocus' => true])->label('Информация') ?>
                    <?= $form->field($ideasModel, 'imageFile')
                        ->fileInput(['autofocus' => true])
                        ->label('Изображение') ?>
                    <div class="form-group">
                        <?= Html::submitButton(
                            'Добавить',
                            [
                                'class' => 'btn btn-primary',
                                'name' => 'add-project-button'
                            ]
                        ) ?>
                        <?= Html::resetButton(
                            'Отмена',
                            [
                                'class' => 'btn btn-warning',
                                'data-dismiss' => 'modal',
                                'name' => 'add-project-cancel-button'
                            ]
                        ) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            <?php /*Pjax::end(); */?>
        </div>
    </div>
</div>