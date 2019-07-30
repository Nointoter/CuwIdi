<?php

use yii\helpers\Html;

$this->title = 'CuwIdi';

?>

<h1>Пять последних идей</h1>
<div class="row">
    <?php foreach ($ideas as $idea) :  ?>
    <?php $image = array_shift($idea->getImages()); ?>
        <div class="row">
            <div class="col-lg-1">
            </div>
            <div class="col-lg-7">
                <h2>Идея : <a href="/ideas/idea?id=<?= strval($idea->id_ideas) ?>" class="" role="button"><?= $idea->ideas_name ?></a></h2>
                <h4>Описание : <?= $idea->info_short ?></h4>
                <h4>Информация : <?= $idea->info_long ?></h4>
            </div>
            <div class="col-lg-4">
                <p><br><br>
                    <?php
                        if ($image != Null) {
                            echo Html::img($image->getImageUrl(), [
                                'width' => '160px',
                                'height' => '160px'
                            ]);
                        }
                    ?>
                </p>
            </div>
        </div>
    <?php   endforeach; ?>
</div>
