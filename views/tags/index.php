<?php

use app\models\SearchIdeas;
use app\models\User;
use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\models\Ideas;
use yii\helpers\Url;

/* @var $tags array*/

$this->title = 'Тэги';

?>
<div class="row">
    <h1>
        <?= $this->title ?>
    </h1>
</div>
<div class="row">
    <?php foreach ($tags as $tag) : ?>
        <div class="row">
            <h2>
                <?php
                $ideasSearch = new SearchIdeas();
                $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), null, null, $tag);
                ?>
                <?php
                echo Html::a(
                    $tag->tag . '(' . $ideasProvider->totalCount . ')',
                    Url::toRoute(['/tags/tag', 'tag' => $tag->tag])
                ) ?>
            </h2>
        </div>
    <?php endforeach; ?>
</div>
