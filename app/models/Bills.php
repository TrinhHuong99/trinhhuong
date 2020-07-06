<?php
use phalcon\validation;
use phalcon\validation\validator\email as emailvalidator;
use phalcon\validation\validator\uniqueness;
use phalcon\validation\validator\presenceof;
use phalcon\mvc\model\behavior\timestampable;
class Bills extends ModelBase
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
    public $bill_code;

    /**
     *
     * @var string
     */
    public $name_customer;

    /**
     *
     * @var string
     */
    public $birthday_customer;

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
     *
     * @var integer
     */
    public $discount;

    /**
     *
     * @var integer
     */
     public $note;

    /**
     *
     * @var integer
     */
    public $book_id;
    /**
     * Initialize method for model.
     */
     /**
     *
     * @var integer
     */
    public $price;
    /**
     * Initialize method for model.
     */
   /**
     *
     * @var integer
     */
    public $total_price;
    /**
     * Initialize method for model.
     */


    public function validation()
    {
        $validator = new validation();

        $validator->add(
            'bill_code',
            new presenceof(
                [
                    'message' => 'Mã hóa đơn không được trống!',
                ]
            )
        );
        $validator->add(
            'bill_code',
            new uniqueness(
                [
                    'message' => 'Mã hóa đơn đã tồn tại!',
                ]
            )
        );
        $validator->add(
            'name_customer',
            new presenceof(
                [
                    'message' => 'Tên khách hàng không được trống!',
                ]
            )
        );
        $validator->add(
            'book_id',
            new presenceof(
                [
                    'message' => 'Tên sách không được trống!',
                ]
            )
        );
        return $this->validate($validator);
    }
    public function initialize()
    {
        $this->setSource("bills");
        $this->hasOne('code', 'BookTempMail', 'book_code', ['alias' => 'BookTempMail']);
        $this->belongsTo('group_id', 'BookGroup', 'id', ['alias' => 'BookGroup']);
        $this->hasMany('code', 'BookTeacher', 'book_code', ['alias' => 'BookTeacher']);
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
        return 'bills';
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
