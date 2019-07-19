<?php


namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SearchProjects extends Projects
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name'], 'string'],
            [['info'], 'string'],
        ];
    }
    public function search($params, $id)
    {
        $query = Projects::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['name' => $this->name]);
        $query->andFilterWhere(['info' => $this->info]);

        return $dataProvider;
    }
}