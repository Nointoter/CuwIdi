<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class SearchComments extends Comments
{
    /**
     * @param $params
     * @param null $users_id
     * @param null $ideas_id
     * @param null $target
     * @return ActiveDataProvider
     */
    public function search($params, $users_id = null, $ideas_id = null, $target = null)
    {
        $query = Comments::find();

        if ($ideas_id) {
            $query = $query->where(['ideas_id' => $ideas_id]);
        }

        if ($users_id) {
            $query = $query
                ->where(['users_id' => $users_id])
                ->joinWith('user')
                ->andWhere(['status' => 0]);
        }

        $query = $query->orderBy('id_comments DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($target) {
            $query->orFilterWhere(['id_comments' => $target])
                ->orFilterWhere(['like', 'comment', $target]);
        }

        $query->andFilterWhere(['id_comments' => $this->id_comments])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}