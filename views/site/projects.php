<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = "Projects";
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1>Projects</h1>
    <ul>
        <?php foreach ($projects as $project): ?>
            <li><a class="btn-link" href="project?id=<?php echo ($project->id)?>">
                <?= Html::encode("({$project->name})") ?>:
                <?= $project->info ?>
            </li>
        <?php endforeach; ?>
    </ul>

<?= LinkPager::widget(['pagination' => $pagination]) ?>