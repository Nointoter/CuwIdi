<?php

?>

<h1>Пять последних идей</h1>
<div class="row">
    <?php
        foreach ($items as $item)
        {
            echo '<html> 
                    <body> 
                        <div class="col-lg-1">
                        </div>
                        <div class="col-lg-4">
                            <h2>Idea : ' . $item->ideas_name . '</h2>
                            <h4>Info : ' . $item->info_short . '</h4>
                            <h4>Description : ' . $item->info_long . '</h4>
                        </div> 
                        <div class="col-lg-12">
                        </div>
                    </body> 
                </html>';
        }
    ?>
</div>
