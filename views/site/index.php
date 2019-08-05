<?php

use yii\helpers\Html;

$this->title = 'CuwIdi';
$i = 0;
?>

<h1>Пять последних идей</h1>
<div class="row">
    <?php foreach (array_reverse($ideas) as $idea) :  ?>
        <?php
            if ($i == 5) {
                break;
            }
        ?>
        <?php if (!($idea->getUser())->status) : ?>
        <?php $image = array_shift($idea->getImages()); ?>
            <div class="row" style="border: 2px solid #000000;">
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <h2>Идея : <a href="/ideas/idea?id=<?= strval($idea->id_ideas) ?>" class="" role="button"><?= $idea->ideas_name ?></a></h2>
                    <h4>Описание : <?= $idea->info_short ?></h4>
                    <h4>Информация : <?= $idea->info_long ?></h4>
                </div>
                <div class="col-lg-4">
                    <h2>Тэги :
                        <h3>
                            <?php
                                $tags = $idea->getTags();
                                foreach ($tags as $tag) {
                                    echo $tag->tag . ', ';
                                }
                            ?>
                        </h3>
                    </h2>
                </div>
                <div class="col-lg-3">
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
        <?php $i++; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
