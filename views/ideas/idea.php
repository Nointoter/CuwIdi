<?php

use yii\helpers\Html;

$this->title = 'Просмотр идеи '.strval($model->ideas_name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <h1>Idea : <?= Html::encode($model->ideas_name) ?></h1>

    <p></p>
    <!--<div class="col-lg-5">
        <h2><?/*= $image */?></h2>
    </div>-->
    <h4><?= Html::encode($model->info_short) ?></h4>
    <p>Полное описание идеи</p>
    <h3><textarea readonly rows="10" cols="97"><?= Html::encode($model->info_long) ?></textarea></h3>

</div>

