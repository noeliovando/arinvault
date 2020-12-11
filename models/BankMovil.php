<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "bank_movil".
 *
 * @property int $id
 * @property string $telefono
 * @property string $cedula
 * @property int $id_bank
 * @property int $id_user
 *
 * @property BankName $bank
 * @property User $user
 */
class BankMovil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_movil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefono', 'cedula', 'id_bank', 'id_user'], 'required'],
            [['id_bank', 'id_user'], 'integer'],
            [['telefono', 'cedula'], 'string', 'max' => 50],
            [['id_bank'], 'exist', 'skipOnError' => true, 'targetClass' => BankName::className(), 'targetAttribute' => ['id_bank' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'telefono' => 'Telefono',
            'cedula' => 'Cedula',
            'id_bank' => 'Banco',
            'id_user' => 'Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBank()
    {
        return $this->hasOne(BankName::className(), ['id' => 'id_bank']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    public function getUsers()
    {
        $datos = User::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'username');
    }
    public function getBanks()
    {
        $datos = BankName::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'name');
    }
    public function getNombreCompleto()
    {
        return $this->user? $this->user->name.' '.$this->user->surname:'';
    }
}
