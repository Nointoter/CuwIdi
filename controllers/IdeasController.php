<?php


namespace app\controllers;

use app\models\Ideas;
use app\models\SearchIdeas;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class IdeasController extends Controller
{
    /**
     * Displays ideas
     *
     * @return string
     */
    public function actionIdeas()
    {
        $model = Ideas::find()->all();
        $searchModel = new SearchIdeas();
        $dataProvider = $searchModel->search(Yii::$app->request->get(), NULL);
        $id_ideas = ArrayHelper::map($model,'id_ideas', 'id_ideas');
        $ideas_name = ArrayHelper::map($model,'ideas_name', 'ideas_name');
        $info_short = ArrayHelper::map($model,'info_short', 'info_short');
        return $this->render('ideas',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id_ideas' => $id_ideas,
            'ideas_name' => $ideas_name,
            'info_short' => $info_short,
        ]);
    }
}