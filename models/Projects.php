<?php


namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property int $id
 * @property string $name
 * @property string $info
 *
*/
class Projects extends  ActiveRecord
{
    /**
     * @return string название таблицы, сопоставленной с этим ActiveRecord-классом.
     */
    public static function tableName()
    {
        return '{{projects}}';
    }

    public function getOptions()
    {
        return ($this->hasMany(Options::className(), ['projects_id' => 'id']));
    }

    public function rules()
    {
        return[
            [['id'],'integer'],
            [['name'],'string'],
            [['info'],'string'],
            [['images_name'],'string'],
        ];
    }

    public function getImageUrl()
    {
        return Url::to('@web/images/' . $this->images_name, true);
    }
}