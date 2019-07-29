<?php

use yii\helpers\Html;

$this->title = 'CuwIdi';

?>

<h1>Пять последних идей</h1>
<div class="row">
    <?php
        foreach ($ideas as $idea){
            $image = array_shift($idea->getImages());
            echo '<html> 
                    <body>
                        <div class="row">
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-4">
                                <h2>Идея : ' . $idea->ideas_name . '</h2>
                                <h4>Описание : <textarea readonly rows="1" cols="65">' . $idea->info_short .'</textarea></h4>
                                <h4>Информация :<textarea readonly rows="5" cols="65">' . $idea->info_long .'</textarea></h4>
                            </div> 
                        </div>
                    </body> 
                </html>';
            if ($image != Null) {
                echo Html::img($image->getImageUrl(), [
                    'width' => '160px',
                    'height' => '160px'
                ]);
            }
        }
    ?>
</div>
