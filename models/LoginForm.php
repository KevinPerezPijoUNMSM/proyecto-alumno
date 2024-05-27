<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read Alumno|null $alumno
 *
 */
class LoginForm extends Model
{
    public $alu_vcnombre;
    public $alu_vcpassword;
    public $rememberMe = true;

    private $_alumno = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['alu_vcnombre', 'alu_vcpassword'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['alu_vcpassword', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $alumno = $this->getALumno();

            if (!$alumno || !$alumno->validatePassword($this->alu_vcpassword)) {
                $this->addError($attribute, 'Nombre o Constraseña incorrectos');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->alumno->login($this->getAlumno(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds Alumno by [[alu_vcnombre]]
     *
     * @return Alumno|null
     */
    public function getAlumno()
    {
        if ($this->_alumno === false) {
            $this->_alumno = Alumno::findByUsername($this->alu_vcnombre);
        }
        return $this->_alumno;
    }
}
