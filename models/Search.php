<?php


namespace app\models;

use yii\data\ActiveDataProvider;
use app\models\Projects;
use app\models\Options;

class Search extends Projects
{
    public function search($params, $target)
    {
        $query = Projects::find()
            ->joinWith('options')
            ->where(['options_name' => $target])
            ->orWhere(['options_value' => $target])
            ->orWhere(['name' => $target])
            ->orWhere(['info' => $target]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['name' => $this->name]);
        $query->andFilterWhere(['info' => $this->info]);
        $query->andFilterWhere(['projects_id' => $this->options->projects_id]);
        $query->andFilterWhere(['options_name' => $this->options->options_name]);
        $query->andFilterWhere(['options_value' => $this->options->options_value]);

        return $dataProvider;
    }
}