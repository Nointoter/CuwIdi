<?php

?>

<h1>Пять последних идей</h1>
<div class="row">
    <?php
        foreach ($items as $item)
        {
            echo '<html> 
                    <body> 
                        <h2>Idea : ' . $item->ideas_name . '</br> </h2> 
                    </body> 
                </html>';
            echo '<html> 
                    <body> 
                        <h4>Info : ' . $item->info_short . '</br> </h4> 
                    </body> 
                </html>';
            echo '<html> 
                    <body> 
                        <h4>Description : ' . $item->info_long . '</br> </h4> 
                    </body> 
                </html>';
        }
    ?>
</div>
