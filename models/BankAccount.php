<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "bank_account".
 *
 * @property int $id
 * @property string $number
 * @property int $id_bank
 * @property string $person_name
 * @property int $id_person_name
 * @property int $id_type_bank_account
 * @property int $id_user
 *
 * @property BankName $bank
 * @property BankAccountType $typeBankAccount
 * @property User $user
 */
class BankAccount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_account';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['number', 'id_bank', 'person_name', 'id_person_name', 'id_type_bank_account','id_user'], 'required'],
            [['id_bank', 'id_person_name', 'id_type_bank_account','id_user'], 'integer'],
            [['person_name'], 'string', 'max' => 100],
            [['number'], 'string', 'max' => 20],
            [['id_bank'], 'exist', 'skipOnError' => true, 'targetClass' => BankName::className(), 'targetAttribute' => ['id_bank' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_type_bank_account'], 'exist', 'skipOnError' => true, 'targetClass' => BankAccountType::className(), 'targetAttribute' => ['id_type_bank_account' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Numero de cuenta',
            'id_bank' => 'Banco',
            'person_name' => 'Nombre del beneficiario',
            'id_person_name' => 'Cedula',
            'id_type_bank_account' => 'Tipo de Cuenta',
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
    public function getTypeBankAccount()
    {
        return $this->hasOne(BankAccountType::className(), ['id' => 'id_type_bank_account']);
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
    public function getTypeBankAccounts()
    {
        $datos = BankAccountType::find()
            ->asArray()
            ->all();
        return ArrayHelper::map($datos, 'id', 'name');
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
