<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * User represents the model behind the search form about `mdm\admin\models\User`.
 */
class Vendor extends Model
{
    public $vendorname;
    public $imageFile;
    public $isNewRecord;
    public $id;
    public $created_at;
    public $updated_at;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['vendorname'], 'safe'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('vendor', 'ID'),
            'vendorname' => Yii::t('vendor', 'Vendor Name'),
            'created_at' => Yii::t('vendor', 'Created At'),
            'updated_at' => Yii::t('vendor', 'Updated At'),

        ];
    }

    public function search($params)
    {

    }


    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
