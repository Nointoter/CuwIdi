<?php


namespace app\models;


use yii\data\ActiveDataProvider;

class SearchUsers extends User
{
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
        ];
    }

    public function search($params, $id)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id_users' => $this->id_users])->
            andFilterWhere(['users_name' => $this->users_name])->
            andFilterWhere(['username' => $this->username])->
            andFilterWhere(['password' => $this->password])->
            andFilterWhere(['users_role' => $this->users_role]);


        return $dataProvider;
    }
}