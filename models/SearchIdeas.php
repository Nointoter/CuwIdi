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
            [['creations_day'], 'string'],
            [['creations_month'], 'string'],
            [['creations_year'], 'string'],
            [['ideasSearch'], 'string']
        ];
    }

    public function search($params, $id, $ideasSearch)
    {
        if ($ideasSearch != Null){
            $this->ideasSearch = $ideasSearch;
        }
        if ($id != Null) {
            $query = Ideas::find()
                ->joinWith('ideas_tags')
                ->joinWith('users')
                ->where(['creators_id' => $id])
                ->andWhere(['status' => 0]);
        } else {
            $query = Ideas::find()
                ->joinWith('ideas_tags')
                ->joinWith('users')
                ->where(['status' => 0]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orFilterWhere(['id_ideas' => $this->ideasSearch])
            ->orFilterWhere(['ideas_name' => $this->ideasSearch])
            ->orFilterWhere(['info_short' => $this->ideasSearch])
            ->orFilterWhere(['creations_day' => $this->ideasSearch])
            ->orFilterWhere(['creations_month' => $this->ideasSearch])
            ->orFilterWhere(['creations_year' => $this->ideasSearch])
            ->orFilterWhere(['creators_id' => $this->ideasSearch])
            ->orFilterWhere(['users_name' => $this->ideasSearch])
            ->orFilterWhere(['tag' => $this->ideasSearch]);
        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['ideas_name' => $this->ideas_name])
            ->andFilterWhere(['info_short' => $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['creators_id' => $this->creators_id]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        $query->orFilterWhere(['id_ideas' => $this->ideasSearch])
            ->orFilterWhere(['ideas_name' => $this->ideasSearch])
            ->orFilterWhere(['info_short' => $this->ideasSearch])
            ->orFilterWhere(['creations_day' => $this->ideasSearch])
            ->orFilterWhere(['creations_month' => $this->ideasSearch])
            ->orFilterWhere(['creations_year' => $this->ideasSearch])
            ->orFilterWhere(['creators_id' => $this->ideasSearch])
            ->orFilterWhere(['users_name' => $this->ideasSearch])
            ->orFilterWhere(['tag' => $this->ideasSearch]);
        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['ideas_name' => $this->ideas_name])
            ->andFilterWhere(['info_short' => $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['creators_id' => $this->creators_id]);
        return $dataProvider;
    }
}