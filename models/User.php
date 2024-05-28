<?php

namespace app\models;

use app\models\Tablas\Alumno;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $alu = Alumno::findOne(['alu_vccodigo'=>$id]);
        if(!is_null($alu)){
            $user = new User();
            $user -> id = strtoupper($alu->alu_vccodigo);
            $user -> password = $alu->alu_vcpassword;
            $user -> authKey = $alu->alu_vccodigo.''.$alu->alu_vcpassword;
            $user -> accessToken = $alu->alu_vccodigo.''.$alu->alu_vcpassword;
            return $user;
        } else{
            return false;
        }

        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $alu = Alumno::find() -> where(['alu_vccorreo'=>$username])->one();
        if(!is_null($alu)){
            $user = new User();
            $user -> id = strtoupper($alu->alu_vccodigo);
            $user -> password = $alu->alu_vcpassword;
            $user -> authKey = $alu->alu_vccodigo.''.$alu->alu_vcpassword;
            $user -> accessToken = $alu->alu_vccodigo.''.$alu->alu_vcpassword;
            return $user;
        } else{
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
