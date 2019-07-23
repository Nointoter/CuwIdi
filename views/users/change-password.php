<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();

echo $form->field($model, 'password')->passwordInput();

echo $form->field($model, 'newPassword')->passwordInput();

echo $form->field($model, 'reNewPassword')->passwordInput();
?>
    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 're-pass-button']) ?>
    </div>

<?php ActiveForm::end(); ?>