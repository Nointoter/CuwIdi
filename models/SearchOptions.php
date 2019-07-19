<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class SearchOptions extends Options
{
    public function rules()
    {
        return [
            [['options_id'], 'integer'],
            [['options_name'], 'string'],
            [['options_value'], 'string'],
            [['projects_id'], 'integer'],
        ];
    }

    public function search($params, $id)
    {

        $query = Options::find()->where(['projects_id' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['options_id' => $this->options_id]);
        $query->andFilterWhere(['projects_id' => $this->projects_id]);
        $query->andFilterWhere(['options_name' => $this->options_name]);
        $query->andFilterWhere(['options_value' => $this->options_value]);

        return $dataProvider;
    }
}