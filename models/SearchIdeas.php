<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class SearchIdeas extends Ideas
{
    public $ideasSearch;

    /**
     * @return array
     */
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

    /**
     * @param $params
     * @param null $id
     * @param null $ideasSearch
     * @param null $tagSearch
     * @return ActiveDataProvider
     */
    public function search($params, $id = null, $ideasSearch = null, $tagSearch = null)
    {
        if ($ideasSearch) {
            $this->ideasSearch = $ideasSearch;
        }
        $query = Ideas::find()
            ->joinWith('tags')
            ->joinWith('user')
            ->orderBy('id_ideas');

        if ($id) {
            $query
                ->where(['creators_id' => $id]);
        }
        if ($tagSearch) {
            $query->andWhere(['tag' => $tagSearch]);
        }
        $query->andWhere(['status' => 0]);

        if ($ideasSearch) {
            $query->andWhere(
                [
                    'AND',
                    [
                        'OR',
                        ['id_ideas' => $this->ideasSearch],
                        ['like', 'ideas_name', $this->ideasSearch],
                        ['like', 'info_short', $this->ideasSearch],
                        ['creations_day' => $this->ideasSearch],
                        ['creations_month'=> $this->ideasSearch],
                        ['creations_year' => $this->ideasSearch],
                        ['like', 'users_name', $this->ideasSearch],
                        ['like', 'tag', $this->ideasSearch],
                    ]
                ]
            );
        }

        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['like', 'ideas_name', $this->ideas_name])
            ->andFilterWhere(['like', 'info_short', $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['like', 'users_name', $this->user->users_name]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        if ($ideasSearch) {
            $query->andWhere(
                [
                    'AND',
                    [
                        'OR',
                        ['id_ideas' => $this->ideasSearch],
                        ['like', 'ideas_name', $this->ideasSearch],
                        ['like', 'info_short', $this->ideasSearch],
                        ['creations_day' => $this->ideasSearch],
                        ['creations_month' => $this->ideasSearch],
                        ['creations_year' => $this->ideasSearch],
                        ['like', 'users_name', $this->ideasSearch],
                        ['like', 'tag', $this->ideasSearch],
                    ]
                ]
            );
        }

        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['like', 'ideas_name', $this->ideas_name])
            ->andFilterWhere(['like', 'info_short', $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['like', 'users_name', $this->user->users_name]);

        return $dataProvider;
    }
}
