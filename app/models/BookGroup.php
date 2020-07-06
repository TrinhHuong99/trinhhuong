<?php
use phalcon\validation;
use phalcon\validation\validator\uniqueness;
use phalcon\validation\validator\presenceof;
class BookGroup extends ModelBase
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
            new uniqueness(
                [
                    'message' => 'Mã nhóm  đã tồn tại',
                ]
            )
        );
        $validator->add(
            'code',
            new presenceof(
                [
                    'message' => 'Mã nhóm không được trống',
                ]
            )
        );
        $validator->add(
            'name',
            new presenceof(
                [
                    'message' => 'Tên nhóm không được trống',
                ]
            )
        );

        return $this->validate($validator);
    }

    public function initialize()
    {
        $this->setSource("book_group");
        $this->hasMany('id', 'Book', 'group_id', ['alias' => 'Book']);
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
        return 'book_group';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return BookGroup[]|BookGroup|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return BookGroup|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
