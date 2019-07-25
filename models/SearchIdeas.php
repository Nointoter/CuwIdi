<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchIdeas extends Ideas
{
    public $ideasSearch;

    public function rules()
    {
        return[
            [['id_ideas'], 'integer'],
            [['ideas_name'], 'string'],
            [['info_short'], 'string'],
            [['info_long'], 'string'],
            [['creators_id'], 'integer'],
            [['ideas_images'], 'integer'],
            [['creations_day'], 'string'],
            [['creations_month'], 'string'],
            [['creations_year'], 'string'],
            [['ideasSearch'], 'string']
        ];
    }

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
        $query->orFilterWhere(['id_ideas' => $this->ideasSearch])->
            orFilterWhere(['ideas_name' => $this->ideasSearch])->
            orFilterWhere(['info_short' => $this->ideasSearch])->
            orFilterWhere(['creators_id' => $this->ideasSearch]);

        $query->andFilterWhere(['id_ideas' => $this->id_ideas])->
        andFilterWhere(['ideas_name' => $this->ideas_name])->
        andFilterWhere(['info_short' => $this->info_short])->
        andFilterWhere(['creators_id' => $this->creators_id]);


        return $dataProvider;
    }
}