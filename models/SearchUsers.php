<?php

namespace app\models;

use yii\data\ActiveDataProvider;

class SearchUsers extends User
{
    public $usersSearch;

    public function rules()
    {
        return[
            [['id_users'], 'integer'],
            [['users_name'], 'string'],
            [['username'], 'string'],
            [['password'], 'string'],
            [['users_info'], 'string'],
            [['users_image'], 'string'],
            [['users_role'], 'string'],
            [['usersSearch'], 'string'],
        ];
    }

    /**
     * @param $params
     * @param null $id
     * @param null $target
     * @param null $bool
     * @return ActiveDataProvider
     */
    public function search($params, $id = null, $target = null, $bool = null)
    {
        $query = User::find();
        if ($id != null) {
            $query
                ->where(['id_users' => $id]);
        }
        if (!$bool) {
            $query->andWhere(['status' => 0]);
        }

        if ($target) {
            $this->usersSearch = $target;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orFilterWhere(['id_users' => $this->usersSearch])
            ->orFilterWhere(['like', 'users_name', $this->usersSearch])
            ->orFilterWhere(['like', 'users_info', $this->usersSearch]);

        $query->andFilterWhere(['id_users' => $this->id_users])
            ->andFilterWhere(['like', 'users_name', $this->users_name])
            ->andFilterWhere(['like', 'users_info', $this->users_info])
            ->andFilterWhere(['users_role' => $this->users_role]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->orFilterWhere(['id_users' => $this->usersSearch])
            ->orFilterWhere(['like', 'users_name', $this->usersSearch])
            ->orFilterWhere(['like', 'users_info', $this->usersSearch]);

        $query->andFilterWhere(['id_users' => $this->id_users])
            ->andFilterWhere(['like', 'users_name', $this->users_name])
            ->andFilterWhere(['like', 'users_info', $this->users_info])
            ->andFilterWhere(['users_role' => $this->users_role]);

        return $dataProvider;
    }
}
