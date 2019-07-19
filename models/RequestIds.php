<?php


namespace app\models;


use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

class RequestIds extends Projects
{
    public function search($params, $model)
    {
        $query = Projects::find()
            ->joinWith('options')
            ->where(['name' => $model->name])
            ->andWhere(['info' => $model->info])
            ->andWhere(['options_name' => $model->options_name])
            ->andWhere(['options_value' => $model->options_value]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,

        ]);

        // загружаем данные формы поиска и производим валидацию
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // изменяем запрос добавляя в его фильтрацию
        $query->andFilterWhere(['id' => $this->id]);

        return $dataProvider;
    }
}