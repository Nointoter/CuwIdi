<?php

use yii\helpers\Html;

/* @var $idea \app\models\Ideas*/

$this->title = 'CuwIdi';

?>
<h1>Пять последних идей</h1>
<div class="row">
    <?php foreach ($ideas as $idea) : ?>
        <?php
            if ($idea->user->isActive()) : ?>
            <?php
                $image = array_shift($idea->images);
            ?>
            <div class="row" style="border: 1px solid #000;"></div>
            <div class="row">
                <div class="col-lg-5">
                    <h2>
                        Идея:
                        <a href="/ideas/idea?id=<?= strval($idea->id_ideas) ?>" class="" role="button">
                            <?= $idea->ideas_name ?>
                        </a>
                    </h2>
                    <h4>Описание : <?= $idea->info_short ?></h4>
                    <h4>Информация : <?= $idea->info_long ?></h4>
                </div>
                <div class="col-lg-4">
                    <?php if ($tags = $idea->tags) : ?>
                    <h3>
                        Тэги:
                        <?php foreach ($tags as $tag) : ?>
                            <?= $tag->tag . ', ' ?>
                        <?php endforeach; ?>
                    </h3>
                    <?php endif; ?>
                </div>
                <div class="col-lg-3">
                    <p>
                        <br>
                        <br>
                        <?php
                        if ($image != null) {
                            echo Html::img($image->getImageUrl(), [
                                'width' => '160px',
                                'height' => '160px'
                            ]);
                        }
                        ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
