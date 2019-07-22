<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchIdeas extends Ideas
{
    public function search($params, $id)
    {
        $query = Ideas::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id_ideas' => $this->id_ideas]);
        $query->andFilterWhere(['ideas_name' => $this->ideas_name]);
        $query->andFilterWhere(['info_short' => $this->info_short]);

        return $dataProvider;
    }
}