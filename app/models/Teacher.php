<?php

use Phalcon\Validation;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\Alnum as AlnumValidator;

class Teacher extends ModelBase
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
    public $code;

    /**
     *
     * @var string
     */
    public $fullname;

    /**
     *
     * @var string
     */
    public $phone;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $facebook;

    /**
     *
     * @var string
     */
    public $youtube_chanel;

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
     * Validations and business logic
     *
     * @return boolean
     */
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'code',
            new presenceof(
                [
                    'message' => 'Mã giáo viên không được để trống',
                ]
            )
        );
        $validator->add(
            'code',
            new Uniqueness(
                [
                    'field' => 'code',
                    'message' => 'Mã giáo viên đã tồn tại',
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
//        $validator->add(
//            'phone',
//            new StringLength(
//                [
//                    'messageMinimum' => 'Số điện thoại tối thiểu 10 ký tự',
//                    'messageMaximum' => 'Số điện thoại tối đa 13 ký tự',
//                    'min'            => 10,
//                    'max'            => 13,
//                ]
//            )
//        );

//        $validator->add(
//            'phone',
//            new presenceof(
//                [
//                    'message' => 'Số điện thoại không được trống',
//                ]
//            )
//        );
//
//        $validator->add(
//            'phone',
//            new Regex(
//                [
//                    'message'    => 'Số điện thoại không đúng định dạng',
//                    'pattern'    => '/[0-9]+/',
//                    'allowEmpty' => true,
//                ]
//            )
//        );
//
//        $validator->add(
//            'phone',
//            new StringLength(
//                [
//                    'messageMinimum' => 'Số điện thoại tối thiểu 10 ký tự',
//                    'messageMaximum' => 'Số điện thoại tối đa 13 ký tự',
//                    'min'            => 10,
//                    'max'            =>13,
//                ]
//            )
//        );

//        $validator->add(
//            'email',
//            new presenceof(
//                [
//                    'message' => 'Email không được trống vui lòng điền đúng định dạng',
//                ]
//            )
//        );
        $validator->add(
            'email',
            new StringLength(
                [
                    'messageMaximum' => 'email tối đa 50 ký tự',
                    'max'            => 50,
                ]
            )
        );
        $validator->add(
            "code",
            new AlnumValidator(
                [
                    "message" => "Mã giáo viên không được để trống",
                ]
            )
        );
//        $validator->add(
//            "address",
//            new AlnumValidator(
//                [
//                    "message" => "Địa chỉ chỉ bao gồm các ký tự aA-zZ, 0-9",
//                ]
//            )
//        );
//        $validator->add(
//            'address',
//            new presenceof(
//                [
//                    'message' => 'Địa chỉ không được trống',
//                ]
//            )
//        );

        $validator->add(
            'address',
            new StringLength(
                [
                    'messageMaximum' => 'Địa chỉ gồm 255 ký tự',
                    'max'            => 255,
                ]
            )
        );

        $validator->add(
            'code',
            new StringLength(
                [
                    'messageMaximum' => 'Mã giáo viên chỉ cho phép tối đa 20 ký tự',
                    'max'            => 20,
                ]
            )
        );

        $validator->add(
            'fullname',
            new StringLength(
                [
                    'messageMaximum' => 'Tên giáo viên tối đa 50 ký tự',
                    'max'            => 50,
                ]
            )
        );

        $validator->add(
            'fullname',
            new presenceof(
                [
                    'message' => 'Tên giáo viên không được trống',
                ]
            )
        );

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true){
            return false;
        }

        return $this->validate($validator);
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("teacher");
        $this->hasMany('code', 'BookTeacher', 'teacher_code', ['alias' => 'BookTeacher']);
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
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'teacher';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Teacher[]|Teacher|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Teacher|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
