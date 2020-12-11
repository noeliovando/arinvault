<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use Yii;


/**
 * This is the model class for table "user_account".
 *
 * @property int $id
 * @property int $id_user
 * @property string $btc_amount
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'btc_amount'], 'required'],
            [['id', 'id_user'], 'integer'],
            [['btc_amount'], 'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Usuario',
            'btc_amount' => 'Saldo BTC',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(),['id' =>'id_user']);
    }
    public function getUsers()
    {
        $datos = User::find()
        ->where(['id_user_rol' => 2 ])
        ->asArray()
        ->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
    public function getUserUsername()
    {
        return $this->user? $this->user->username: 'Vacio';
    }
    public function  getTasaBs(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_bolivar');
    }
    public function  getTasaDolares(){
        $datos = TasaDia::find()
            ->orderBy(['id'=>SORT_DESC])
            ->one();
        return ArrayHelper::getValue($datos, 'valor_dolar');
    }

    public static function getTotal($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }
        return $total;
    }
    public static function getTotalBs($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }
        return $total;
    }
    public static function getTotalD($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
            $total += $item[$columnName];
        }
        return $total;
    }

}
