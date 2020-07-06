<?php

use JasonGrimes\Paginator;

class ValidmessageController extends \ControllerBase
{

    public function indexAction()
    {
        $phone = $this->request->getQuery('phone');
        $email = $this->request->getQuery('email');
        $code = $this->request->getQuery('code');

        $status = $this->request->getQuery('status');
        $startDate = $this->request->getQuery('startDate');
//        $datestart=strtotime(date_format(date_create($startDate. ' 00:00:00'),"Y-m-d H:i:s "));
        if (!empty($startDate)){
            $datestart = date_create_from_format('Y-m-d H:i:s', $startDate . ' 00:00:00')->getTimestamp();
        }
        $endDate =$this->request->getQuery('endDate');
        //$dateend=strtotime(date_format(date_create($endDate. ' 23:59:59'),"Y-m-d H:i:s"));
        if (!empty($endDate)){
            $dateend = date_create_from_format('Y-m-d H:i:s', $endDate . ' 23:59:59')->getTimestamp();
        }

        $currentPage = (int) $this->request->getQuery('page', 'int'); // GET
//        var_dump(date('Y-m-d H:i:s', $dateend));
//        exit();
//var_dump($status=="" ? "chưa chon ": "$status");exit();
        $w = '';
        if (!empty($phone)) {
            $w .= ' AND phone like "%'.$phone.'%"';
        }
        if (!empty($email)) {
            $w .= ' AND email like "%'.$email.'%"';
        }
        if (!empty($code)) {
            $w .= ' AND code like "%'.$code.'%"';
        }
        if (isset($status) && $status != ""){
            $w .= ' AND send_mail = '.$status.'';
        }
        if (!empty($startDate)) {
            $w .= ' AND UNIX_TIMESTAMP(created_at) >=  '.$datestart.'';
        }
        if (!empty($endDate)) {
            $w .= ' AND UNIX_TIMESTAMP(created_at) <= '.$dateend.'';
        }

//        $paginate = SmsBook::find();
        $pages = $currentPage ? $currentPage : 1;
        $off = ($pages -1)*15;

        $paginate = SmsBook::find([
            'conditions'  => 'publish = ?1' . $w ,
            'bind' =>[
                '1' => 1

            ]
        ]);

        $a = $this->request->getQuery();
        unset($a['_url'], $a['page']);
        $arr = [];
        foreach ($a as $key => $val){
            $arr[] = $key.'='.$val;
        }
        $text = implode('&', $arr);

        $validmessage = SmsBook::find([
            'conditions'  =>'publish  = ?1' . $w,
            'limit' =>15,
            'offset' => ($pages -1)*15,
            'bind' =>[
                '1' => 1

            ],
            'order' => 'id DESC',
        ]);
//        var_dump($validmessage);exit();

        $totalItems = count($paginate);
        $itemsPerPage = 15;
        $currentPage = $pages;
        $urlPattern = $this->url->get('validmessage/?page=(:num)&'.$text);
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);


        $this->view->setVars(
            [
                'validmessage'     =>  $validmessage,
                'paginator' =>  $paginator,
                'phone'     =>  $phone,
                'email'     =>  $email,
                'code'      =>  $code,
                'startDate' =>  $startDate,
                'endDate'   =>  $endDate,
                'paginate'  =>  $paginate,
                'status'    =>  $status,
                'off'       =>  $off,

            ]);
    }

}

