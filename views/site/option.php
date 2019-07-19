<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $option app\models\Options */
/* @var $project app\models\Projects */

use yii\helpers\Html;

$this->title = ' Option '.strval($option->options_name);
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="form">
    <?php echo Html::beginForm(); ?>
    <table border="толщина">
        <tr>
            <th>Relative project </th>
            <th>Option name </th>
            <th>Value </th></tr>
        <tr>
            <td><?= Html::encode($project->name) ?></td>
            <td><?= Html::encode($option->options_name) ?></td>
            <td><?= Html::encode($option->options_value) ?></td>
        </tr>
    </table>
</div>
