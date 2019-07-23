<?php


use yii\helpers\Html;$form->field($model, 'password')->passwordInput();

$form->field($model, 'newPassword')->passwordInput();

$form->field($model, 'reNewPassword')->passwordInput();
?>
    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 're-pass-button']) ?>
    </div>