<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchComments extends Comments
{
    public $commentsSearch;

    public function rules()
    {
        return[
            [['id_comments'], 'integer'],
            [['comment'], 'string'],
            [['ideas_id'], 'integer'],
            [['users_id'], 'integer'],
            [['commentsSearch'], 'string'],
        ];
    }

    public function search($params, $id, $bool, $target)
    {
        if ($target != Null){
            $this->commentsSearch = $target;
        }
        if ($id != Null) {
            if (!$bool) {
                $query = Comments::find()
                    ->joinWith('users')
                    ->where(['users_id' => $id])
                    ->andWhere(['status' => 0]);
            } else {
                $query = Comments::find()
                    ->joinWith('ideas')
                    ->where(['ideas_id' => $id])
                    ->joinWith('users')
                    ->andWhere(['status' => 0]);
            }
        } else {
            $query = Comments::find();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->orFilterWhere(['id_comments' => $this->commentsSearch])
            ->orFilterWhere(['like', 'comment', $this->commentsSearch]);
        $query->andFilterWhere(['id_comments' => $this->id_comments])
            ->andFilterWhere(['like', 'comment', $this->comment]);
        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        // изменяем запрос добавляя в его фильтрацию
        $query->orFilterWhere(['id_comments' => $this->commentsSearch])
            ->orFilterWhere(['like', 'comment', $this->commentsSearch]);
        $query->andFilterWhere(['id_comments' => $this->id_comments])
            ->andFilterWhere(['like', 'comment', $this->comment]);
        return $dataProvider;
    }
}