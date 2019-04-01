<?php
/**
 * Anivia *
 *	     __.oOo.__
 *	    /'(  _  )`\
 *	   / . \/^\/ . \
 *	  /  _)_`-'_(_  \
 *	 /.-~   ).(   ~-.\
 *	/'     /\_/\     `\
 *	     . "-V-"
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_tracking".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $start_date
 * @property string $end_date
 */
class UserTracking extends BaseModel
{
    /*
     * get array tracking time
     */
    public static function aTrackingTime(){
        return [
            14 => Yii::t('app', '2 weeks'),
            30 => Yii::t('app', '1 month'),
            90 => Yii::t('app', '3 months'),
            180 => Yii::t('app', '6 months'),
            365 => Yii::t('app', '1 year'),
            0 => Yii::t('app', 'Until canceled'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_tracking';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date', 'user_id', 'product_id'], 'safe'],
            [['rUser', 'rProduct'], 'safe'],
        ];
    }
    
    /*
     * relations
     */
    public function getRUser(){
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
    
    /*
     * relations
     */
    public function getRProduct(){
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'start_date' => 'Start Date',
            'end_date' => Yii::t('app', 'Track for'),
        ];
    }
    
    /*
     * get tracking items of user by id
     * @params: $this->user_id
     */
    public function getUserTrackingItems(){
        $now    = date('Y-m-d H:i:s');
        $models = UserTracking::find()
                ->where([
                    'user_id' => Yii::$app->user->id, 
//                    'status' => self::stt_active
                ])
                ->andWhere(['<=', 'start_date', $now])
                ->andWhere(['>=', 'end_date', $now])
                ->all();
        $ret    = [];
        if($models){
            foreach ($models as $row) {
                $ret[$row->product_id] = $row;
            }
        }
        return $ret;
    }
    
    /*
     * Check if product is tracked
     * @params: $this->product_id
     */
    public function isTracked(){
        $now    = date('Y-m-d H:i:s');
        $models = UserTracking::find()
                ->where([
                    'user_id' => Yii::$app->user->id, 
                    'product_id' => $this->product_id])
                ->andWhere(['<=', 'start_date', $now])
                ->andWhere(['>=', 'end_date', $now])
                ->one();
        return $models ? true : false;
    }
    
    /*
     * Check if product is tracked before (current no)
     * @params: $this->product_id
     */
    public function isTrackedBefore(){
        $models = UserTracking::find()
                ->where([
                    'user_id' => Yii::$app->user->id, 
                    'product_id' => $this->product_id,
//                    'status' => self::stt_inactive
                    ])
                ->one();
        return $models ? $models : false;
    }
    
    public function findByProductId() {
        return UserTracking::find()
                ->where([
                    'user_id' => Yii::$app->user->id, 
                    'product_id' => $this->product_id,
//                    'status' => self::stt_active
                ])
                ->one();
    }
    
    /**
     * @todo get list active product id
     */
    public function getArrayActive(){
        $now = date('Y-m-d H:i:s');
        $aModels  = UserTracking::find()
                        ->select('DISTINCT(product_id)')
                        ->where(['<=', 'start_date', $now])
                        ->andWhere(['>=', 'end_date', $now])
                        ->all();
        $ret      = [];
        foreach ($aModels as $value) {
            $ret[$value->product_id] = $value->product_id;
        }
        return $ret;
    }
}
