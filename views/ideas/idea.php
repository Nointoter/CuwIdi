<?php

use yii\helpers\Html;

$this->title = 'Просмотр идеи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-5">
        <h1>Idea : <?= Html::encode($model->ideas_name) ?></h1>
    </div>
    <div class="col-lg-1">
        <p></p>
    </div>
    <!--<div class="col-lg-5">
        <h2><?/*= $image */?></h2>
    </div>-->
    <h4><?= Html::encode($model->info_short) ?></h4>

    <h4><?= Html::encode($model->info_long) ?></h4>


    <?/*= $form->field($model, 'info_short')->textarea(['rows' => 1, 'cols' => 4]) */?>

    <?/*= $form->field($model, 'info_long')->textarea(['rows' => 8,'cols' => 5]) */?>

</div>

