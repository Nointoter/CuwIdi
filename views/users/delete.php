<?php

/* @var $form yii\bootstrap\ActiveForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();
/*$this->title = 'Добавить идею';
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="delete-user">
    <div class="row">
        <div class="col-lg-12">
            <?php if (!$bool) : ?>
                <div class="form-group">
                    <?= Html::submitButton('Удалить', ['class' => 'btn btn-primary', 'name' => 'deleteUser']) ?>
                    <?= Html::resetButton('Отмена', ['class' => 'btn btn-warning', 'data-dismiss' => 'modal', 'name' => 're-pass-cancel-button']) ?>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <h2>Удаление невозможно</h2>
                    <h3>У пользователя остались идеи</h3>
                    <?= Html::resetButton('Отмена', ['class' => 'btn btn-warning', 'data-dismiss' => 'modal', 'name' => 're-pass-cancel-button']) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>