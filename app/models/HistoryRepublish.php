<?php

class HistoryRepublish extends ModelBase
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
    public $message;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource("history_republish");
        $this->belongsTo('book_code', 'Book', 'code', ['alias' => 'Book']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'history_republish';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return HistoryRepublish[]|HistoryRepublish|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return HistoryRepublish|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
