<?php
use phalcon\validation;
use phalcon\validation\validator\email as emailvalidator;
use phalcon\validation\validator\uniqueness;
use phalcon\validation\validator\presenceof;
use phalcon\mvc\model\behavior\timestampable;
class Orders extends ModelBase
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
    public $order_code;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var integer
     */
    public $company_code;

    /**
     *
     * @var integer
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
     * @var string
     */
    public $status_id;

    /**
     * Initialize method for model.
     */
    public $book_id;

    /**
     * Initialize method for model.
     */
     public $total_book;

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
            'order_code',
            new presenceof(
                [
                    'message' => 'Mã đơn đặt hàng không được trống',
                ]
            )
        );
        $validator->add(
            'order_code',
            new uniqueness(
                [
                    'message' => 'Mã đơn đặt hàng đã tồn tại',
                ]
            )
        );
        $validator->add(
            'title',
            new presenceof(
                [
                    'message' => 'Tiêu đề không được trống',
                ]
            )
        );
        $validator->add(
            'status_id',
            new presenceof(
                [
                    'message' => 'Trạng thái đơn đặt hàng không được trống',
                ]
            )
        );
         $validator->add(
            'book_id',
            new presenceof(
                [
                    'message' => 'Mã sách không được trống',
                ]
            )
        );
        return $this->validate($validator);
    }
    public function initialize()
    {
        $this->setSource("orders");
        $this->hasOne('code', 'BookTempMail', 'book_code', ['alias' => 'BookTempMail']);
        $this->belongsTo('group_id', 'BookGroup', 'id', ['alias' => 'BookGroup']);
        $this->hasMany('status_id', 'Status', 'id', ['alias' => 'Status']);
        $this->hasMany('code', 'BookTeacher', 'book_code', ['alias' => 'BookTeacher']);
        $this->hasMany('code', 'HistoryRepublish', 'book_code', ['alias' => 'HistoryRepublish']);
        $this->hasMany('code', 'Republish', 'book_code', ['alias' => 'Republish']);
        // $this->hasMany('book_id', 'Book', 'id', ['alias' => 'Book']);
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
        return 'orders';
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
