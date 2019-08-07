<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchImages extends Images
{
    public function search($params, $id)
    {
        if ($id != Null) {
            $query = Images::find()
                ->where(['ideas_id' => $id]);
        } else {
            $query = Images::find();
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