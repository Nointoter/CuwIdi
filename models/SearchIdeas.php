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
                ->orderBy('id_ideas');
        } else {
            $query = Ideas::find()
                ->joinWith('ideas_tags')
                ->joinWith('users')
                ->orderBy('id_ideas');
        }
        if ($ideasSearch != Nnull) {
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
                        ['creators_id' => $this->ideasSearch],
                        ['users_name' => $this->ideasSearch],
                        ['tag' => $this->ideasSearch],
                    ],
                    [
                        'status' => 0
                    ]
                ]);
        } else {
            $query->andWhere(
                [
                    'AND',
                    [
                        'status' => 0
                    ]
                ]);
        }

        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['like', 'ideas_name', $this->ideas_name])
            ->andFilterWhere(['like', 'info_short', $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['creators_id' => $this->creators_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        if ($ideasSearch != Nnull) {
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
                        ['creators_id' => $this->ideasSearch],
                        ['users_name' => $this->ideasSearch],
                        ['tag' => $this->ideasSearch],
                    ],
                    [
                        'status' => 0
                    ]
                ]);
        } else {
            $query->andWhere(
                [
                    'AND',
                    [
                        'status' => 0
                    ]
                ]);
        }

        $query->andFilterWhere(['id_ideas' => $this->id_ideas])
            ->andFilterWhere(['like', 'ideas_name', $this->ideas_name])
            ->andFilterWhere(['like', 'info_short', $this->info_short])
            ->andFilterWhere(['creations_day' => $this->creations_day])
            ->andFilterWhere(['creations_month' => $this->creations_month])
            ->andFilterWhere(['creations_year' => $this->creations_year])
            ->andFilterWhere(['creators_id' => $this->creators_id]);

        return $dataProvider;
    }
}