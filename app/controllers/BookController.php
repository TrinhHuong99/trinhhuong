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
class BookController extends \ControllerBase
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
    $group_id = $this->request->getQuery('group_id');
    $name = $this->request->getQuery('name');
    $class_id = $this->request->getQuery('class_id');
    $teacher = $this->request->getQuery('teacher');
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
        if (!empty($class_id)) {
          $w .= ' AND class_id  = '.$class_id.'';
        }
        if (isset($teacher) && $teacher != ""){
          $w .= ' AND BookTeacher.teacher_code = "'.$teacher.'"';
        }
        if (!empty($startDate)) {
          $w .= ' AND UNIX_TIMESTAMP(Book.created_at) >=  '.$fomatstart.'';
        }
        if (!empty($endDate)) {
          $w .= ' AND UNIX_TIMESTAMP(Book.created_at) <= '.$fomatend.'';
        }
        $pages = $currentPage ? $currentPage : 1;
        $off = ($pages -1)*15;
        $phql = "SELECT DISTINCT  Book.* FROM Book LEFT JOIN BookTeacher on Book.code = BookTeacher.book_code
        WHERE Book.created_at IS NOT NULL ".$w;
        $paginate = $this->modelsManager->executeQuery($phql)->toArray();

        $phql1 = "SELECT DISTINCT Book.* FROM Book LEFT JOIN BookTeacher on Book.code = BookTeacher.book_code
        WHERE Book.created_at IS NOT NULL".$w." ORDER BY Book.id DESC LIMIT ".$off.",15";
        $books = $this->modelsManager->executeQuery($phql1);
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
        $urlPattern = $this->url->get('book/?page=(:num)&'.$search);
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);
        $this->view->setVars(
          [
            'books'=>$books,
            'group_id'=>$group_id,
            'name'=>$name,
            'class_id'=>$class_id,
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
        $book = new Book();
        $group_id = BookGroup::find();

        if($this->request->isPost())
        { 
          $name = $this->request->getPost('name');
          $created_bys = $this->session->get('user_fullname');
          $book->code = $this->request->getPost('code');
          $book->name = $name;
          $book->group_id = $this->request->getPost('group_id');
          $book->class_id = $this->request->getPost('class_id');
          if ($this->request->hasFiles() == true) 
          {
            $files = $this->request->getUploadedFiles();

                      // Print the real file names and sizes
            foreach ($files as $file) 
            {
             $hdsd = $book->attachs = $file->getName();
             $file->moveTo('upload/' . $file->getName());
           }
         }
         $book->attachs  = $hdsd;
         $book->created_by = $created_bys;
         $success = $book->save();
         $teachers = $this->request->getPost('teacher');

         foreach ($teachers as $key => $value) {
          $teacher = new BookTeacher();
          $teacher->book_code = $this->request->getPost('code');
          $teacher->teacher_code = $value;
          $teacher->save();
        }
         $tempmail = new BookTempMail();
         $tempmail->book_code = $this->request->getPost('code');
         $tempmail->title = $this->request->getPost('subjectemail');
         $tempmail->content = $this->request->getPost('contenmail');
         $tempmail->save();
        if($success)
        {
          $this->flashSession->success('Thêm sách thành công');
          $this->response->redirect('book');
        }
        else
        {
          $messages  =$book->getMessages();
          foreach ($messages as $message)
          {
            $this->flashSession->error($message);
          }
          Phalcon\Tag::setDefaults(get_object_vars($book));

        }

      }
      $this->view->setVars(['teachers'=>$teachers,'group_id'=>$group_id]);
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
      $book = Book::findFirst($id);
      $group_id = BookGroup::find();
      $this->view->setVars(['teachers'=>$teachers,'group_id'=>$group_id,'book'=>$book,'bookteacher'=>$bookteacher]);
    }
    public function updateAction($id)
    {
      $book = Book::findFirst($id);

      $fileupload = $this->request->getPost('hdsd');
      if($this->request->isPost())
      {
        $arr = [];
        $created_bys = $this->session->get('user_fullname');

        $book->code = $this->request->getPost('code');
        $book->name = $this->request->getPost('name');
        $book->group_id = $this->request->getPost('group_id');
        $book->class_id = $this->request->getPost('class_id');
        if ($this->request->hasFiles() == true) 
        {
          $files = $this->request->getUploadedFiles();

                      // Print the real file names and sizes
          foreach ($files as $file) 
          {
           $hdsd = $book->attachs = $file->getName();
           $file->moveTo('upload/' . $file->getName());
         }
       }
       $book->attachs  = $hdsd  == '' ? $fileupload : $hdsd;
       $book->created_by = $created_bys;
       $success = $book->save();
       $book->BookTeacher->delete();
       $teacher = $this->request->getPost('teacher');
       foreach ($teacher as $key => $value) {
        $teacher = new BookTeacher();
        $teacher->book_code = $this->request->getPost('code');
        $teacher->teacher_code = $value;
        $teacher->save();
      }
          $book->BookTempMail->delete();
          $tempemail = new BookTempMail();
          $tempemail->book_code = $this->request->getPost('code');
          $tempemail->title = $this->request->getPost('subjectemail');
          $tempemail->content = $this->request->getPost('contenmail');
          $tempemail->save();

      if($success)
      {
        $this->flashSession->success('Chỉnh sửa sách  thành công');
        $this->response->redirect('book');
      }
      else
      {
        $messages  =$book->getMessages();
        foreach ($messages as $message)
        {
          $this->flashSession->error($message);
        }
        return $this->dispatcher->forward(
          [
            'controller' => 'book',
            'action' => 'edit',
            'params' => [$book->id]
          ]
        );
      }
    }
  }
  public function detailAction($id)
  {
  
    $teachers = Teacher::find();
    $book = Book::findFirst($id);
    $arr = Republish::find([
      'conditions'  =>  'book_code = :checkcode:',
      'bind'  =>  [
        'checkcode' => $book->code,

      ],
      'columns'=>'republish, count(id) as total',
      'group' => 'republish , book_code'
    ])->toArray();
    $countrepub = $book->HistoryRepublish->count();
    $this->view->setVars([
      'teachers' => $teachers,
      'group_id'=> $group_id,
      'book' => $book,
      'countrepub'=> $countrepub,
      'arr' =>$arr
    ]);

  }

  private function generateRandomString($length = 6) 
  {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= str_shuffle($characters[mt_rand(0, $charactersLength - 1)]);
    }
    return $randomString;
  }
  private function errorrepublist($errors , $book_code,$count)
  {
    $sum = 0;
      for($i = 1; $i <= $errors; $i++)
          {
            $randomstr = $this->generateRandomString();
            $republish = new Republish();
            $code_items = $book_code . $randomstr;
            $republish->book_code = $book_code;
            $republish->code_item = $code_items; 
            $republish->republish = $count; 
            if (!$republish->save()) {
              $sum++;
            }
          }
          if (!empty($sum)) {
             $this->errorrepublist($sum,$book_code,$count);
      }
  }

  public function republistAction()
  {
      $abc = $this->session->get('user');
//        var_dump($abc['role']);exit();
      $role = $abc['role'];
      if ($role == '1') {
          $this->flashSession->error(
              "Bạn không có quyền tái bản sách"
          );

          $this->dispatcher->forward(
              [
                  'controller' => 'index',
                  'action'     => 'index',
              ]
          );

          return false;
      }
          $republish = Republish::find();
          $geturl = $this->request->getPost('geturl');
          $number  = (int) $this->request->getPost('number');
          $book_code = $this->request->getPost('book_code');
          $count = $this->request->getPost('count');
          $book = Book::findFirst(
            [
              'code  = :code:',
              'bind' =>['code' => $book_code,] 
            ]
          );

          $errors = 0;
          if($this->request->isPost()) {
           for($i = 1; $i <= $number; $i++)
           {
            $randomstr = $this->generateRandomString();
            $republish = new Republish();
            $code_items = $book_code . $randomstr;
            $republish->book_code = $book_code;
            $republish->code_item = $code_items; 
            $republish->republish = $count + 1; 
            if(!$republish->save())
            {
              $errors++;

            }
          }
          if (!empty($errors)) {

              $this->errorrepublist($errors,$book_code,($count + 1));
              $this->dispatcher->forward(
                  [
                    'controller' => 'book',
                    'action' => 'detail',
                    'params' => [$geturl]
                  ]
              );
         }
         $this->flashSession->success('Thêm  mã in thành công ' );
         $historyrepublish  = new HistoryRepublish();
         $historyrepublish->book_code = $book_code;
         $historyrepublish->message = 'Đã được tái bản';
         $historyrepublish->save();
         return $this->dispatcher->forward(
          [
            'controller' => 'book',
            'action' => 'detail',
            'params' => [$geturl]
          ]
        );

      }
  }
  public function detailscodeAction()
  {
      $this->view->setRenderLevel(
        View::LEVEL_NO_RENDER
      );
      $republish = $this->request->getPost('republish');
      $book_code = $this->request->getPost('book_code');

      $countrepublishs = Republish::find([
        'conditions'  =>  'republish = :republish: And book_code = :book_code:',
        'bind'  =>  [
          'republish'  =>  $republish, 
          'book_code'  =>  $book_code, 

        ],
        'columns'=>'republish, count(id) as total',
      ]);

      $republishs = Republish::find([
        'conditions'  =>  'republish = :republish: And book_code = :book_code:',
        'bind'  =>  [
          'republish'  =>  $republish, 
          'book_code'  =>  $book_code, 

        ],
        'limit' => 10,
      ]);
        $republishstotal = Republish::find([
        'conditions'  =>  'republish = :republish: And book_code = :book_code:',
        'bind'  =>  [
          'republish'  =>  $republish, 
          'book_code'  =>  $book_code, 

        ],
        'limit' => 10,
      ]);
        $counttotal = count($republishstotal);

      return json_encode([$republishs,$countrepublishs,$counttotal]);
  }
  public function downloadAction()
  {
      $this->view->setRenderLevel(
        View::LEVEL_NO_RENDER
      );
      $alert = [
        'success' => true,
        'result' => '',
        'page' => 1,
        'percent' => 0
      ];

      if($this->request->isPost())
      {
        $currentPage = (int) $this->request->getPost('page', 'int');
        $republish = $this->request->getPost('republish');
        $book_code = $this->request->getPost('book_code');
        $pages = $currentPage ? $currentPage : 1;
        $code_items = Republish::find([
          'conditions'  =>  'republish = :republish: And book_code = :book_code:',
          'bind'  =>  [
            'republish'  =>  $republish, 
            'book_code'  =>  $book_code,

          ],
          'limit' => 100,
          'offset' => ($pages -1)*100,
        ]);
        $republishs = Republish::find([
          'conditions'  =>  'republish = :republish: And book_code = :book_code:',
          'bind'  =>  [
            'republish'  =>  $republish, 
            'book_code'  =>  $book_code, 

          ],
          'columns'=>'republish, count(id) as total',
        ])->toArray();
        $data =[];
        foreach ($republishs as $key => $val) {
          $data[] = $val['total'];
        }
        $data['page'] = $currentPage ? $currentPage : 1;
        $data['limit'] = 100;
        $total_page = ceil($data[0]/100);
        $user = $this->session->getId();
        if (!empty($code_items) ){
          if ($data['page'] == 1) {
            $spreadsheet = new Spreadsheet();
          }else{
            $spreadsheet = IOFactory::load(BASE_PATH.'/public/download/Code_book'.$user.'.csv');
          }
          $spreadsheet->setActiveSheetIndex(0);
          $spreadsheet->getActiveSheet()->setTitle('Ma In');
          $columnArray = array('A', 'B');
          $titleArray = array('STT', 'Code Item');
          $row_count = 1;
          foreach($columnArray as $key => $val){
            $spreadsheet->getActiveSheet()->setCellValue($val.$row_count, $titleArray[$key]);
            $spreadsheet->getActiveSheet()->getColumnDimension($val)->setAutoSize(true);
          }
          foreach($code_items as $keyp => $val){
           $spreadsheet->getActiveSheet()->SetCellValue('A'.(($keyp + 2) + ($data['page'] - 1)*100), (($keyp + 1) + ($data['page'] - 1)*100) ); 
           $spreadsheet->getActiveSheet()->SetCellValue('B'.(($keyp + 2) + ($data['page'] - 1)*100), ($val->code_item));
         }
         $writer = IOFactory::createWriter($spreadsheet, 'Csv');
         $writer->setUseBOM(true);
         $file_create = ''.BASE_PATH.'/public/download/Code_book'.$user.'.csv';
         $writer->save($file_create);

         $alert['success'] = true;
         $alert['page'] = (($data['page'] == $total_page) ? NULL : ($data['page'] + 1));
         $alert['percent'] =  (($data['page'] == 1) ? 0 : ceil( (($data['page']/$total_page)*100) ) >= 100 ? 100 : ceil( (($data['page']/$total_page)*100) ) );
         $alert['result'] = '<a href="'.$this->url->getStatic('download/Code_book'.$user.'.csv').'">Tải xuống  tại đây</a>';
       }
       elseif($data['page'] == 1){

       }
       else
       {
        $alert['success'] = true;
        $alert['percent'] = 100;
        $alert['page'] = NULL;
        $alert['result'] = '<a href="'.$this->url->getStatic('download/Code_book'.$user.'.csv').'">Tải xuống tại đây!/a> ';
      }
    }
    echo json_encode($alert);die;
  }

  public function deleteAction($id)
  {
    $book = Book::findFirst($id);

    if($book->delete())
    {
      $this->flashSession->success('Xóa sách thành công');
      $this->response->redirect('book');
    }
    $book->BookTeacher->delete();
    $book->Republish->delete();
    $book->HistoryRepublish->delete();
    $book->BookTempMail->delete();

  }

}