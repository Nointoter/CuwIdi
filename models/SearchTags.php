<?php


namespace app\models;

use yii\data\ActiveDataProvider;

class SearchTags extends Tags
{
    /**
     * @param $params
     * @param null $id
     * @return ActiveDataProvider
     */
    public function search($params, $id = null)
    {
        $query = Tags::find();
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
            andFilterWhere(['id_tags' => $this->id_tags])->
            andFilterWhere(['like', 'tag', $this->tag])->
            andFilterWhere(['ideas_id' => $this->ideas_id]);

        return $dataProvider;
    }
}