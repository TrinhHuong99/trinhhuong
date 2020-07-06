<?php
use phalcon\validation;
use phalcon\validation\validator\email as emailvalidator;
use phalcon\validation\validator\uniqueness;
use phalcon\validation\validator\presenceof;
use phalcon\mvc\model\behavior\timestampable;
class Book extends ModelBase
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
    public $name;

    /**
     *
     * @var integer
     */
    public $group_id;

    /**
     *
     * @var integer
     */
    public $class_id;

    /**
     *
     * @var string
     */
    public $attachs;

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
     * Initialize method for model.
     */


    public function validation()
    {
        $validator = new validation();

        
        $validator->add(
            'code',
            new presenceof(
                [
                    'message' => 'Mã sách không được trống',
                ]
            )
        );
        $validator->add(
            'code',
            new uniqueness(
                [
                    'message' => 'Mã sách đã tồn tại',
                ]
            )
        );
        $validator->add(
            'name',
            new presenceof(
                [
                    'message' => 'Tên sách không được trống',
                ]
            )
        );
        $validator->add(
            'group_id',
            new presenceof(
                [
                    'message' => 'Loại sách không được trống',
                ]
            )
        );
        return $this->validate($validator);
    }
    public function initialize()
    {
        $this->setSource("book");
        $this->hasOne('code', 'BookTempMail', 'book_code', ['alias' => 'BookTempMail']);
        $this->belongsTo('group_id', 'BookGroup', 'id', ['alias' => 'BookGroup']);
        $this->hasMany('code', 'BookTeacher', 'book_code', ['alias' => 'BookTeacher']);
        $this->hasMany('id', 'Orders', 'book_id', ['alias' => 'Orders']);
        $this->hasMany('code', 'HistoryRepublish', 'book_code', ['alias' => 'HistoryRepublish']);
        $this->hasMany('code', 'Republish', 'book_code', ['alias' => 'Republish']);
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
        return 'book';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Book[]|Book|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Book|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
