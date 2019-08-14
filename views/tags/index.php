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
                $ideasProvider = $ideasSearch->search(Yii::$app->request->get(), null, null, $tag->tag);
                ?>
                <?php
                echo Html::a(
                    $tag->tag . '(' . $ideasProvider->totalCount . ')',
                    Url::toRoute(['/tags/tag', 'tag' => $tag->tag])
                );
                ?>
                &nbsp;
                <?php
                if (!Yii::$app->user->isGuest) {
                    if ((User::findIdentity(Yii::$app->user->id))->isAdmin()) {
                        echo Html::a(
                            'Удалить',
                            Url::toRoute(
                                [
                                    '/tags/delete-tag',
                                    'tag' => $tag->tag,
                                    'bool' => strval(false),
                                    'tags_id' => 0,
                                ]
                            ),
                            ['class' => 'btn btn-warning']
                        );
                    }
                }
                ?>
            </h2>
        </div>
    <?php endforeach; ?>
</div>
