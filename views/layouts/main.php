<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'CuwIdi',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'style' => 'color: #FFFFFF; background-color: #000000;'
        ],
    ]);
    echo Nav::widget([
        'options' => [
                'class' => 'navbar-nav navbar-left',
                'style' => 'color: #FFFFFF; background-color: #000000;',
        ],
        'items' => [
            ['label' => 'Идеи', 'url' => ['/ideas/ideas']],
        ],
    ]);
    echo Nav::widget([
        'options' => [
            'class' => 'navbar-nav navbar-right',
            'style' => 'color: #FFFFFF; background-color: #000000;',
        ],
        'items' => [
            Yii::$app->user->isGuest ? (
            ['label' => 'Зарегистрироваться', 'url' => ['/users/sing-up']]
            ) : (
            ['label' => 'Профиль', 'url' => ['/users/profile?id='.strval(Yii::$app->user->id)]]
            ),
            Yii::$app->user->isGuest ? (
            ['label' => 'Войти', 'url' => ['/users/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/users/logout'], 'post')
                . Html::submitButton(
                    'Выйти (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            ),
        ],
    ]);
    ?>
    <form class="navbar-form navbar-right" action="/site/search-results" method="get" id="main-global-search-form">
        <div class="form-group has-feedback search">
            <input type="text" class="form-control" placeholder="Search" />
            <i class="glyphicon glyphicon-search form-control-feedback"></i>
        </div>
    </form>
    <?php

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="modal-footer">
    <div class="containe">
        <p class="pull-left"><a class="invisible"">____</p>
        <p class="pull-left"><a class="btn-link" href=<?= Url::toRoute("site/about")?>>&copy; Noin <?= date('Y') ?></p>
        <p class="pull-left"><a class="invisible"">____</p>
        <p class="pull-left"><a class="btn-link" href=<?= Url::toRoute("site/contact")?>> Связь</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
