<?php

/* @var $carousel 'array' */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;


$this->title = 'Стартовая страница';

$carousels = Carousel::widget([
        'items' => $carousel,
        'options' => ['class' => 'carousel slide', 'data-interval' => '12000'],
        'controls' => [
            //Html::tag('span', '', ['class' => "glyphicon glyphicon-chevron-left"]),
            //Html::tag('span', '', ['class' => "glyphicon glyphicon-chevron-right"]),
            '<span class="glyphicon glyphicon-chevron-left" aria-hidden="false"></span>',
            '<span class="glyphicon glyphicon-chevron-right" aria-hidden="false"></span>'
        ]
    ]);

echo $carousels;

?>


