<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchComments extends Comments
{
    public function search($params, $id, $bool)
    {
        if ($id != Null) {
            if ($bool) {
                $query = Comments::find()
                    ->where(['ideas_id' => $id]);
            } else {
                $query = Comments::find()
                    ->where(['users_id' => $id]);
            }
        } else {
            $query = Comments::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id_comments' => $this->id_comments])
            ->andFilterWhere(['comment' => $this->comment])
            ->andFilterWhere(['users_id' => $this->users_id])
            ->andFilterWhere(['ideas_id' => $this->ideas_id]);
        return $dataProvider;
    }
}