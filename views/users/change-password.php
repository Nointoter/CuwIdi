<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
        'validationUrl' => 'change-password',
        'enableAjaxValidation' => true,
        //'enableClientValidation' => false,
        'id' => 'change-password-form',
    ]);

echo $form->field($model, 'password', ['enableAjaxValidation' => true])->passwordInput();

echo $form->field($model, 'newPassword')->passwordInput();

echo $form->field($model, 'reNewPassword')->passwordInput();

?>
    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 're-pass-button']) ?>
    </div>
<?php ActiveForm::end(); ?>