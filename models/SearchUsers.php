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

    public function search($params, $id, $target, $bool)
    {
        if ($id != Null){
            $query = User::find()
                ->where(['id_users' => $id]);
        } else {
            $query = User::find();
        }
        if (!$bool) {
            $query->andWhere(['status' => 0]);
        }
        //echo '<pre>';
        //var_dump($params);
        if ($target != Null){
            $this->usersSearch = $target;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->orFilterWhere(['id_users' => $this->usersSearch])
            ->orFilterWhere(['users_name' => $this->usersSearch])
            ->orFilterWhere(['username' => $this->usersSearch])
            ->orFilterWhere(['password' => $this->usersSearch])
            ->orFilterWhere(['users_role' => $this->usersSearch]);

        $query->andFilterWhere(['id_users' => $this->id_users])
            ->andFilterWhere(['users_name' => $this->users_name])
            ->andFilterWhere(['username' => $this->username])
            ->andFilterWhere(['password' => $this->password])
            ->andFilterWhere(['users_role' => $this->users_role]);
        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        $query->orFilterWhere(['id_users' => $this->usersSearch])
            ->orFilterWhere(['users_name' => $this->usersSearch])
            ->orFilterWhere(['username' => $this->usersSearch])
            ->orFilterWhere(['password' => $this->usersSearch])
            ->orFilterWhere(['users_role' => $this->usersSearch]);
        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id_users' => $this->id_users])
            ->andFilterWhere(['users_name' => $this->users_name])
            ->andFilterWhere(['username' => $this->username])
            ->andFilterWhere(['password' => $this->password])
            ->andFilterWhere(['users_role' => $this->users_role]);

        return $dataProvider;
    }
}