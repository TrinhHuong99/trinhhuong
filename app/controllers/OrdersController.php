<?php
/**
 * @link http://hocmai.vn/
 * @copyright Cong ty CP Dau tu va dich vu Giao duc
 * @license http://hocmai.vn/
 */
/**
 *
 * @author Thai Bui - Created At: 10/22/2019 - 11:35 AM
 * @version 1.0.0
 *
 */
use JasonGrimes\Paginator;
use Phalcon\Mvc\Model\Query\Builder;
use Phalcon\Mvc\View;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class OrdersController extends \ControllerBase
{
  public function initialize()
  {

    parent::initialize();
        //addcss
    $this->assets->addCss('css/style.css');
    $this->assets->addCss('assets/icon/material-design/css/material-design-iconic-font.min.css');
    $this->assets->addCss('assets/icon/themify-icons/themify-icons.css');
    $this->assets->addCss('assets/icon/icofont/css/icofont.css');
    $this->assets->addCss('assets/icon/font-awesome/css/font-awesome.min.css');
    $this->assets->addCss('assets/pages/advance-elements/css/bootstrap-datetimepicker.css');
    $this->assets->addCss('bower_components/bootstrap-daterangepicker/css/daterangepicker.css');
    $this->assets->addCss('bower_components/select2/css/select2.min.css');
    $this->assets->addCss('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css');
    $this->assets->addCss('bower_components/multiselect/css/multi-select.css');
    $this->assets->addCss('assets/css/ukflex.css');

         //add js
    $this->assets->addJs('bower_components/bootstrap-daterangepicker/js/daterangepicker.js');
    $this->assets->addJs('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
    $this->assets->addJs('bower_components/select2/js/select2.full.min.js');
    $this->assets->addJs('bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js');
    $this->assets->addJs('bower_components/multiselect/js/jquery.multi-select.js');
    $this->assets->addJs('assets/pages/advance-elements/select2-custom.js');
    $this->assets->addJs('assets/pages/form-validation/validate.js');
    $this->assets->addJs('js/myjs.js');
    $this->assets->addJs('js/datepicker.js');


        //them css hoac js ma xu ly rieng (do minh viet hoac tu thu vien) cho tung trang vao day (neu can thiet)
  }

  public function indexAction()
  {
    $teachers = Teacher::find();
    $group_ids = BookGroup::find();
    $book = Book::find();
    $group_id = $this->request->getQuery('group_id');
    $name = $this->request->getQuery('name');
    $created_by = $this->request->getQuery('created_by');
    $startDate = $this->request->getQuery('startDate');
    $endDate =$this->request->getQuery('endDate');
    if (!empty($startDate)){
      $fomatstart = date_create_from_format('Y-m-d H:i:s', $startDate . ' 00:00:00')->getTimestamp();
    }
    if (!empty($endDate)){
      $fomatend = date_create_from_format('Y-m-d H:i:s', $endDate . ' 23:59:59')->getTimestamp();
    }

        $currentPage = (int) $this->request->getQuery('page', 'int'); // GET
        $w = '';
        if (!empty($group_id)) {
          $w .= ' AND group_id = '.$group_id.'';
        }
        if (!empty($name)) {
          $w .= ' AND name like "%'.$name.'%"';
        }
        if (isset($created_by) && $created_by != ""){
          $w .= ' AND orders.created_by = "'.$created_by.'"';
        }
        if (!empty($startDate)) {
          $w .= ' AND UNIX_TIMESTAMP(orders.created_at) >=  '.$fomatstart.'';
        }
        if (!empty($endDate)) {
          $w .= ' AND UNIX_TIMESTAMP(orders.created_at) <= '.$fomatend.'';
        }
        $pages = $currentPage ? $currentPage : 1;
        $off = ($pages -1)*15;
        $phql = "SELECT DISTINCT orders.*,book_group.name,company_orders.* FROM Orders as  orders 
                  LEFT JOIN Book as book on book.id = orders.book_id
                  LEFT JOIN CompanyOrders as company_orders on orders.company_code = company_orders.id
                 LEFT JOIN Status as status on status.id = orders.status_id 
                  LEFT JOIN BookGroup as book_group on book.group_id = book_group.id
                  WHERE orders.created_at IS NOT NULL ".$w;
        $paginate = $this->modelsManager->executeQuery($phql)->toArray();

        $phql1 = "SELECT DISTINCT orders.*,book_group.name ,company_orders.* ,book.name as book_name,status.status_name FROM Orders as  orders 
                  LEFT JOIN Book as book on book.id = orders.book_id
                  LEFT JOIN CompanyOrders as company_orders on orders.company_code = company_orders.id
                  LEFT JOIN Status as status on status.id = orders.status_id
                  LEFT JOIN BookGroup as book_group on book.group_id = book_group.id
                  WHERE orders.created_at IS NOT NULL ".$w." ORDER BY orders.id DESC LIMIT ".$off.",15";

        $orders = $this->modelsManager->executeQuery($phql1);
        
        $count = count($paginate);
        $a = $this->request->getQuery();
        unset($a['_url'], $a['page']);
        $arr = [];
        foreach ($a as $key => $val){
          $arr[] = $key.'='.$val;
        }
        $search = implode('&', $arr);

        $totalItems = count($paginate);
        $itemsPerPage = 15;
        $currentPage = $pages;
        $urlPattern = $this->url->get('orders/?page=(:num)&'.$search);
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);
        $this->view->setVars(
          [
            'orders'=>$orders,
            'group_id'=>$group_id,
            'name'=>$name,
            'count' =>$count,
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'teachers'=>$teachers,
            'group_ids'=>$group_ids,
            'paginator'=>$paginator,
            'teacher' =>$teacher,
            'off' =>$off,
          ]);
      }
      public function createAction()
      {
//          $this->assets->addJs('assets/pages/ckeditor/ckeditor.js');
//          $this->assets->addJs('assets/pages/ckeditor/ckeditor-custom.js');
        $this->assets->addJs('//cdn.ckeditor.com/4.5.9/standard/ckeditor.js');
        $teachers = Teacher::find(['conditions' => 'publish = :status:', 'bind'=>['status' =>1]]);

        $orders = new Orders();

        $books = Book::find();
        $status = Status::find();
        $company = CompanyOrders::find();
 
        if($this->request->isPost())
        { 
        $order_code = $this->request->getPost('code');
        $title = $this->request->getPost('title');
        $book_name = $this->request->getPost('book_name');
        $total_book  = $this->request->getPost('total_book');
        $company_name  = $this->request->getPost('company_name');
        $status  = $this->request->getPost('status');
        $contenmail  = $this->request->getPost('contenmail');
        $created_bys = $this->session->get('user_fullname');

        $now = date('Y-m-d H:i:s', time());
        $time_now = date_create_from_format('Y-m-d H:i:s', $now)->format('Y-m-d H:i:s');

        $orders->order_code = $order_code;
        $orders->title = $title;
        $orders->status_id = $status;
        $orders->company_code = $company_name;
        $orders->total_book = $total_book;
        $orders->note  = $contenmail;
        $orders->book_id = $book_name;
        $orders->created_by = $created_bys;
        $orders->created_at = $time_now;
        $orders->updated_at = $time_now;
        // echo "<pre>";
        // var_dump($orders);
        // exit(); 
         $success = $orders->save();

        if($success)
        {
          $this->flashSession->success('Thêm đơn đặt hàng thành công');
          $this->response->redirect('orders');
        }
        else
        {
          $messages  =$orders->getMessages();
          foreach ($messages as $message)
          {
            $this->flashSession->error($message);
          }
          Phalcon\Tag::setDefaults(get_object_vars($orders));

        }

      }
      $this->view->setVars(['books'=>$books,'status'=>$status,'company'=>$company]);
    }


    public function addvalidateAction(){
      $this->view->setRenderLevel(
        View::LEVEL_NO_RENDER
      );
      $code = $this->request->getPost('code', 'trim');
      $data = Book::findFirst(
        [
          'code = :code:',
          'bind'          => [
            'code' => $code
          ],
        ]
      );
      if(!$data){
        echo true;
      }else{
        echo false;
      }
      die;
    }

    public function editAction($id)
    {
        $this->assets->addJs('assets/pages/ckeditor/ckeditor.js');
        $this->assets->addJs('assets/pages/ckeditor/ckeditor-custom.js');
      $teachers = Teacher::find(['conditions' => 'publish = :status:', 'bind'=>['status' =>1]]);
      $teachers = Teacher::find();
      $status_name = Status::find();
      $orders = Orders::findFirst($id);
      $status_id = $orders->status_id;
      $company_code = $orders->company_code;
      $book_id = $orders->book_id;

      $company_orders = CompanyOrders::findFirst($company_code);
      $status = Status::findFirst($status_id);
      $books = Book::findFirst($book_id);
      $grou_id = $books->group_id;
      $group_ids = BookGroup::findFirst($grou_id);

      $notes = str_replace('<p>','',$orders->note);
      $notes = str_replace('</p>','',$notes);
      
      $this->view->setVars([
        'teachers' => $teachers,
        'status_name' => $status_name,
        'orders'=> $orders,
        'company_orders'=> $company_orders,
        'status'=> $status,
        'books'=> $books,
        'notes'=> $notes,
        'group_ids'=> $group_ids,
      ]);

    }

    public function updateAction($id)
    {
      $orders = Orders::findFirst($id);
      if($this->request->isPost())
      {
        $created_bys = $this->request->getPost('created_by');
        $orders->code = $this->request->getPost('code');
        $orders->title = $this->request->getPost('title');
        $orders->status_id = $this->request->getPost('status');
        $orders->note = $this->request->getPost('contenmail');

        $now = date('Y-m-d H:i:s', time());
        $time_now = date_create_from_format('Y-m-d H:i:s', $now)->format('Y-m-d H:i:s');

        $orders->created_by = $created_bys;
        $orders->updated_at = $time_now;

        $success = $orders->save();

          if($success)
          {
            $this->flashSession->success('Chỉnh sửa đơn hàng thành công');
            $this->response->redirect('orders');
          }
          else
          {
            $messages  =$orders->getMessages();
            foreach ($messages as $message)
            {
              $this->flashSession->error($message);
            }
            return $this->dispatcher->forward(
              [
                'controller' => 'orders',
                'action' => 'edit',
                'params' => [$orders->id]
              ]
            );
          }
      }
    }
  public function detailAction($id)
  {
  
    $teachers = Teacher::find();
    $orders = Orders::findFirst($id);
    $status_id = $orders->status_id;
    $company_code = $orders->company_code;
    $book_id = $orders->book_id;

    // $company_orders = CompanyOrders::query()
    //         ->where("id = ".$company_code )
    //         ->execute() ;
    $company_orders = CompanyOrders::findFirst($company_code);
    $status = Status::findFirst($status_id);
    $books = Book::findFirst($book_id);
    $grou_id = $books->group_id;
    $group_ids = BookGroup::findFirst($grou_id);
    // echo "<pre>";
    // var_dump($books);
    // exit();
    $this->view->setVars([
      'teachers' => $teachers,
      'orders'=> $orders,
      'company_orders'=> $company_orders,
      'status'=> $status,
      'books'=> $books,
      'group_ids'=> $group_ids,
    ]);

  }


  public function deleteAction($id)
  {
    $orders = Orders::findFirst($id);

    if($orders->delete())
    {
      $this->flashSession->success('Xóa đơn đặt hàng thành công');
      $this->response->redirect('orders');
    }
    // $book->BookTeacher->delete();
    // $book->Republish->delete();
    // $book->HistoryRepublish->delete();
    // $book->BookTempMail->delete();

  }

  public function totalpriceAction()
  {
       if ($this->request->isAjax() && $this->request->isPost()) {
            $book_id = $this->request->getPost('book_id');
            $number = $this->request->getPost('number');

            $books = Book::findFirst($book_id);
            echo $price_book = $books->price;
            // var_dump($books);
            // echo $price_to = $book_id * $number; 
        echo "string";
        exit();
        }
  }
    public function priceAction()
  {
       if ($this->request->isAjax() && $this->request->isPost()) {
            $book_id = $this->request->getPost('book_id');
            $number = $this->request->getPost('number');

            $books = Book::findFirst($book_id);
            echo $price_book = $books->price;
            // var_dump($books);
            // echo $price_to = $book_id * $number; 
        echo "string";
        exit();
        }
  }

}