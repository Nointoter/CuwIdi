<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $user app\models\User */


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

$this->title = 'Профиль ' . strval($user->username);
?>
<div class="store">

    <div class="jumbotron">
        <h2>Профиль <?= Html::encode($user->username) ?></h2>
    </div>
</div>