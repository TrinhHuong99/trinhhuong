<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Republish extends \Phalcon\Mvc\Model
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
    public $book_code;

    /**
     *
     * @var string
     */
    public $code_item;

    /**
     *
     * @var integer
     */
    public $republish;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     * Initialize method for model.
     */
    public function validation()
    {
        $validator = new validation();
        $validator->add(
            'code_item',
            new uniqueness(
                [
                    'message' => 'Mã sách tái bản đã tồn tại',
                ]
            )
        );
        return $this->validate($validator);
    }
    public function initialize()
    {
        $this->setSource("republish");
        $this->belongsTo('book_code', 'Book', 'code', ['alias' => 'Book']);
        $this->hasOne('code_item', 'SmsBook', 'code', ['alias' => 'SmsBook']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'republish';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Republish[]|Republish|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Republish|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
