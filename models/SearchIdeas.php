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
            orFilterWhere(['info_short' => $this->ideasSearch]);


        return $dataProvider;
    }
}