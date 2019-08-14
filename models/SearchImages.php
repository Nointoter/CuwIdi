<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class SearchImages extends Images
{
    /**
     * @param $params
     * @param null $id
     * @return ActiveDataProvider
     */
    public function search($params, $id = null)
    {
        $query = Images::find();
        if ($id != null) {
            $query
                ->where(['ideas_id' => $id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        $query->
            andFilterWhere(['id_ideas_images' => $this->id_ideas_images])->
            andFilterWhere(['like', 'images_name', $this->images_name])->
            andFilterWhere(['ideas_id' => $this->ideas_id]);

        return $dataProvider;
    }
}