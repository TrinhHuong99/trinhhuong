<?php

use JasonGrimes\Paginator;

class InvalidmessageController extends \ControllerBase
{

    public function indexAction()
    {
        $phone = $this->request->getQuery('phone');
        $email = $this->request->getQuery('email');
        $startDate = $this->request->getQuery('startDate');
//        $datestart = strtotime(date_format(date_create($startDate),"Y/m/d"));
        if (!empty($startDate)){
            $datestart = date_create_from_format('Y-m-d H:i:s', $startDate . ' 00:00:00')->getTimestamp();
        }
        $endDate = $this->request->getQuery('endDate');
//        $dateend = strtotime(date_format(date_create($endDate),"Y/m/d"));
        if (!empty($endDate)){
            $dateend = date_create_from_format('Y-m-d H:i:s', $endDate . ' 23:59:59')->getTimestamp();
        }
        $currentPage = (int) $this->request->getQuery('page', 'int'); // GET
        $w = '';
        if (!empty($email)) {
            $w .= ' AND email like "%'.$email.'%"';
        }
        if (!empty($phone)) {
            $w .= ' AND phone like "%'.$phone.'%"';
        }
        if (!empty($address)) {
            $w .= ' AND address like "%'.$address.'%"';
        }
        if (!empty($startDate)) {
            $w .= ' AND UNIX_TIMESTAMP(created_at) >=  '.$datestart.'';
        }
        if (!empty($endDate)) {
            $w .= ' AND UNIX_TIMESTAMP(created_at) <= '.$dateend.'';
        }
        $paginate = SmsBook::find([
            'conditions'  =>'publish  = ?1' . $w,
            'bind' =>[
                '1' => 0

            ]
        ]);
        $pages = $currentPage ? $currentPage : 1;
        $off = ($pages -1)*15;

        $a = $this->request->getQuery();
        unset($a['_url'], $a['page']);
        $arr = [];
        foreach ($a as $key => $val){
            $arr[] = $key.'='.$val;
        }
        $text = implode('&', $arr);

        $smsbook = SmsBook::find([
            'conditions'  =>'publish  = ?1' . $w,
            'limit' =>15,
            'offset' => ($pages -1)*15,
            'bind' =>[
                '1' => 0

            ],
            'order' => 'id DESC',
        ]);

        $totalItems = count($paginate);
        $itemsPerPage = 15;
        $currentPage = $pages;
        $urlPattern = $this->url->get('invalidmessage/?page=(:num)&'.$text);
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);


        $this->view->setVars(
            [
                'smsbook'   =>  $smsbook,
                'phone'     =>  $phone,
                'address'   =>  $address,
                'startDate' =>  $startDate,
                'endDate'   =>  $endDate,
                'paginator' =>  $paginator,
                'email'     =>  $email,
                'paginate'  =>  $paginate,
                'off'       => $off,

            ]);
    }

}

