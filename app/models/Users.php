<?php

use phalcon\validation;
use phalcon\validation\validator\email as emailvalidator;
use phalcon\validation\validator\uniqueness;
use phalcon\validation\validator\presenceof;
use phalcon\mvc\model\behavior\timestampable;
use phalcon\validation\validator\regex;
use Phalcon\Validation\Validator\StringLength as StringLength;

class users extends \phalcon\mvc\model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $fullname;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var integer
     */
    public $role;

    /**
     *
     * @var integer
     */
    public $position;

    /**
     *
     * @var string
     */
    public $department;

    /**
     *
     * @var integer
     */
    public $publish;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     *
     * @var string
     */
    public $created_by;

    /**
     * validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new validation();

        
        $validator->add(
            'username',
            new presenceof(
                [
                    'message' => 'Mã nhân viên không được trống',
                ]
            )
        );
        $validator->add(
            'phone',
            new presenceof(
                [
                    'message' => 'Số điện thoại không được trống',
                ]
            )
        );
        $validator->add(
            'phone',
            new Regex(
                [
                  'message'    => 'Số điện thoại không đúng định dạng',
                  'pattern'    => '/[0-9]+/',
                  'allowEmpty' => true,
              ]
          )
        );
        $validator->add(
            'phone',
            new StringLength(
                [
                    'messageMinimum' => 'Số điện thoại tối thiểu 10 ký tự',
                    'messageMaximum' => 'Số điện thoại tối đa 10 ký tự',
                    'min'            => 10,
                    'max'            =>10,
                ]
            )
        );
        $validator->add(
            'username',
            new uniqueness(
                [
                    'message' => 'Mã nhân viên đã tồn tại',
                ]
            )
        );

        $validator->add(
            'fullname',
            new presenceof(
                [
                    'message' => 'Tên nhân viên không được trống',
                ]
            )
        );



        // $validator->add(
        //     'email',
        //     new presenceof(
        //         [
        //             'message' => 'Email không được trống',
        //         ]
        //     )
        // );
        $validator->add(
            'password',
            new presenceof(
                [
                    'message' => 'Mật khẩu không được trống',
                ]
            )
        );
        $validator->add(
            'email',
            new emailvalidator(
                [
                    'model'   => $this,
                    'message' => 'Email không đúng định dạng',
                ]
            )
        );
        $validator->add(
            'email',
            new uniqueness(
                [
                    'model'   => $this,
                    'message' => 'Email này đã tồn tại',
                ]
            )
        );
        // $validator->add(
        //     'address',
        //     new presenceof(
        //         [
        //             'message' => 'Địa chỉ không được trống',
        //         ]
        //     )
        // );
        // $validator->add(
        //     'department',
        //     new presenceof(
        //         [
        //             'message' => 'Phòng làm việc không được trống',
        //         ]
        //     )
        // );



        return $this->validate($validator);
    }

    /**
     * initialize method for model.
     */
    public function initialize()
    {
        $this->setsource("users");
        $this->addBehavior(
            new \Phalcon\Mvc\Model\Behavior\Timestampable([
                'beforeCreate' => [
                    'field' => 'created_at',
                    'format' => 'Y-m-d H:i:s'
                ],
                'beforeUpdate' => [
                    'field' => 'updated_at',
                    'format' => 'Y-m-d H:i:s'
                ]
            ])
        );


    }

    /**
     * returns table name mapped in the model.
     *
     * @return string
     */
    public function getsource()
    {
        return 'users';
    }

    /**
     * allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return users[]|users|\phalcon\mvc\model\resultsetinterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return users|\phalcon\mvc\model\resultinterface
     */
    public static function findfirst($parameters = null)
    {
        return parent::findfirst($parameters);
    }

}
