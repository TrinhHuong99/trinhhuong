<?php

class IndexController extends ControllerBase
{

    /**
     * Luon co ham nay trong tung controller duoc ke thua tu controllerBase, va phai goi parent::initialize() cua lop
     * cha.
     * Viec nay giup dam bao viec tach rieng cac js va css ma minh them vao de xu ly rieng biet cho tung trang khong
     * anh huong toi cac thu viec va js ben tren, dong thoi tranh tinh trang nhung trang khac co js/css khong can thiet.
     *
     */
    public function initialize()
    {
        parent::initialize();

        //them css hoac js ma xu ly rieng (do minh viet hoac tu thu vien) cho tung trang vao day (neu can thiet)
    }

    public function indexAction()
    {

    }

}

