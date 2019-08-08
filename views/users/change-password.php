<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
        'validationUrl' => 'change-password',
        'enableAjaxValidation' => true,
        //'enableClientValidation' => false,
        'id' => 'change-password-form',
    ]);
?>
<div class="form-group">
    <?php
        echo $form->field($model, 'password')->passwordInput();
        echo $form->field($model, 'newPassword')->passwordInput();
        echo $form->field($model, 'reNewPassword')->passwordInput();
    ?>
    <?= Html::submitButton(
        'Подтвердить',
        ['class' => 'btn btn-primary', 'name' => 're-pass-button']
    ) ?>
    <?= Html::resetButton(
        'Отмена',
        ['class' => 'btn btn-warning', 'data-dismiss' => 'modal', 'name' => 're-pass-cancel-button']
    ) ?>
</div>
<?php ActiveForm::end(); ?>