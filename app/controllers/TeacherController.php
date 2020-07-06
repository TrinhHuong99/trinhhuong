<?php


use JasonGrimes\Paginator;
use Phalcon\Mvc\View;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Controllers\ControllerBase;
use Models\Users;
use Models\Grade;
use Models\Subject;
use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;


class TeacherController extends \ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        $this->assets->addCss('css/style.css');
        $this->assets->addCss('assets/css/component.css');
        $this->assets->addCss('bower_components/sweetalert/css/sweetalert.css');
        $this->assets->addCss('assets/pages/notification/notification.css');
        $this->assets->addCss('assets/css/ukflex.css');

        $this->assets->addJs('bower_components/sweetalert/js/sweetalert.min.js');
        $this->assets->addJs('bower_components/modernizr/js/modernizr.js');
        $this->assets->addJs('bower_components/modernizr/js/css-scrollbars.js');
        //sweet alert js -->
        $this->assets->addJs('bower_components/sweetalert/js/sweetalert.min.js');
//        $this->assets->addJs('assets/js/modal.js');
        $this->assets->addJs('assets/js/hai.js');
        // sweet alert modal.js intialize js -->
        // modalEffects js nifty modal window effects -->
        $this->assets->addJs('assets/js/classie.js');
        $this->assets->addJs('assets/js/modalEffects.js');
        $this->assets->addJs('assets/js/pcoded.min.js');
        $this->assets->addJs('assets/js/vertical/vertical-layout.min.js');
        $this->assets->addJs('assets/js/jquery.mCustomScrollbar.concat.min.js');
        //Custom js -->
        $this->assets->addJs('assets/js/script.js');
        $this->assets->addJs('assets/js/bootstrap-growl.min.js');
//        $this->assets->addJs('assets/pages/notification/notification.js');
        $this->assets->addJs('assets/js/pcoded.min.js');
        $this->assets->addJs('assets/js/vertical/vertical-layout.min.js');
        $this->assets->addJs('assets/js/jquery.mCustomScrollbar.concat.min.js');

    }

    public function beforeExecuteRoute($dispatcher)
    {
        $abc = $this->session->get('user');
//        var_dump($abc['role']);exit();
        $role = $abc['role'];
        if ($role == '1') {
            $this->flashSession->error(
                "Bạn không có quyền vào mục quản lý giáo viên"
            );

            $this->dispatcher->forward(
                [
                    'controller' => 'index',
                    'action'     => 'index',
                ]
            );

            return false;
        }
    }

    public function indexAction()
    {
        $this->assets->addCss('css/hai.css');
        $code = $this->request->getQuery('txtcode');
        $fullname = $this->request->getQuery('txtfullname');
        $phone = $this->request->getQuery('txtphone');
        $address = $this->request->getQuery('txtaddress');
        $email = $this->request->getQuery('txtemail');
        $currentPage = (int) $this->request->getQuery('page', 'int'); // GET
        $w = '';
        if (!empty($code)) {
            $w .= ' AND Teacher.code like "%'.$code.'%"';
        }
        if (!empty($fullname)) {
            $w .= ' AND fullname like "%'.$fullname.'%"';
        }
        if (!empty($phone)) {
            $w .= ' AND phone like "%'.$phone.'%"';
        }
        if (!empty($address)) {
            $w .= ' AND address like "%'.$address.'%"';
        }
        if (!empty($book)) {
            $w .= ' AND name like "%'.$book.'%"';
        }
        if (!empty($email)) {
            $w .= ' AND email like "%'.$email.'%"';
        }
        $paginate = Teacher::find([
            'conditions'  => 'created_at IS NOT NULL' . $w,
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

        $phql1 = "SELECT DISTINCT Teacher.* FROM Teacher 
         WHERE Teacher.created_at IS NOT NULL".$w." ORDER BY Teacher.id DESC LIMIT ".$off.",15";

        $teachers = $this->modelsManager->executeQuery($phql1);
        $aha = [];
//        $teachers1 = Teacher::find();
//        foreach ($teachers1 as $value){
//            $ab = $value->BookTeacher ? $value->BookTeacher : NULL;
//            if($ab){
//                foreach ($value->BookTeacher as $va){
//                    $aha = [
//                        'class_id' => $va->Book->class_id,
//                        'name' => $va->Book->name
//                    ];
//                }
//            }
//        }


//        $teacherBook  = Teacher::find([
//            'conditions'  =>  'id = :id:',
//            'bind'  =>  [
//                'id'  =>  '23',
//            ],
//        ]);
//        foreach ($teacherBook as $value){
//            $ab = $value->BookTeacher ? $value->BookTeacher : NULL;
//            if($ab){
//                foreach ($value->BookTeacher as $va){
//                    $aha = [
//                        'class_id' => $va->Book->class_id,
//                        'name' => $va->Book->name
//                    ];
//                }
//            }
//        }
//        var_dump($aha);
//        exit();
        $totalItems = count($paginate);
        $itemsPerPage = 15;
        $currentPage = $pages;
        $urlPattern = $this->url->get('teacher?page=(:num)&'.$text);

        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);

        $teacherBook = BookTeacher::find();
//        $teacherBookSql = "SELECT DISTINCT  Book.class_id, Book.name FROM Teacher LEFT JOIN BookTeacher on Teacher.code = BookTeacher.teacher_code
//                LEFT JOIN Book on BookTeacher.book_code = Book.code";
//        $teacherBook = $this->modelsManager->executeQuery($teacherBookSql);
//        var_dump($teacherBook);exit();


        $this->view->setVars(
            [
                'teachers'      => $teachers,
                'teacherBook'   => $teacherBook,
                'code'          => $code,
                'fullname'      => $fullname,
                'phone'         => $phone,
                'address'       => $address,
                'book'          => $book,
                'email'         => $email,
                'paginator'     => $paginator,
                'paginate'      => $paginate,
                'currentPage'   => $currentPage,
                'off'           => $off,
                'aha'           => $aha,
            ]
        );
    }


    public function createAction()
    {
        $this->assets->addCss('css/hai.css');
        $teacher = new Teacher();
//        $bookTeacher = new BookTeacher();
        $name = $this->session->get('user_fullname');
        $str = [];

        if($this->request->isPost()) {

            $abc = explode(" ", $this->request->getPost('txtcode','trim'));
            $teacher->code = implode('', $abc);
            $teacher->fullname = $this->request->getPost('txtfullname', 'trim');
            $teacher->phone = $this->request->getPost('txtphone', 'trim');
            $teacher->email = $this->request->getPost('txtemail', 'trim');
            $teacher->address = $this->request->getPost('txtaddress', 'trim');
            $teacher->facebook = $this->request->getPost('txtfacebook');
            $teacher->youtube_chanel = $this->request->getPost('txtyoutube_chanel');
            $teacher->created_by = $name;
            $success = $teacher->save();

//            $bookTeacher->book_code = $this->request->getPost('txtbook_code');
//            $bookTeacher->teacher_code = $this->request->getPost('txtcode');
//            $bookTeacher->save();

            if ($success) {
                $this->flashSession->success('Thêm mới nhân viên thành công');
//                $this->response->redirect('teacher');
                $this->dispatcher->forward(
                    [
                        'controller' => 'teacher',
                        'action' => 'index',
                    ]
                );
            } else {
                $messages = $teacher->getMessages();
                foreach ($messages as $message) {
                    $str[$message->getField()] = $message->getMessage();
//                    $str[] = $message->getField() . '=' . $message->getMessage();
                }
//                var_dump($str);die();
            }
        }
        $this->view->setVar('str', $str);
    }

    public function saveAction()
    {
        $teacher = new Teacher();
//        $bookTeacher = new BookTeacher();
        $name = $this->session->get('user_fullname');
        if($this->request->isPost()) {

            $teacher->code = $this->request->getPost('txtcode');
            $teacher->fullname = $this->request->getPost('txtfullname');
            $teacher->phone = $this->request->getPost('txtphone');
            $teacher->email = $this->request->getPost('txtemail');
            $teacher->address = $this->request->getPost('txtaddress');
            $teacher->facebook = $this->request->getPost('txtfacebook');
            $teacher->youtube_chanel = $this->request->getPost('txtyoutube_chanel');
            $teacher->created_by = $name;
            $success = $teacher->save();

//            $bookTeacher->book_code = $this->request->getPost('txtbook_code');
//            $bookTeacher->teacher_code = $this->request->getPost('txtcode');
//            $bookTeacher->save();

            if ($success) {
                $this->flashSession->success('Thêm thành công');
                $this->response->redirect('teacher');
            } else {
                $messages = $teacher->getMessages();
                foreach ($messages as $message) {
                    $this->flashSession->error($message);
                }

            }
        }
    }

    public function editAction($id)
    {
        $this->assets->addCss('css/hai.css');
        $teacher = Teacher::findFirst($id);
//        var_dump($teacher->code); exit();
        $conditions = ['TeacherID' => $id];
//        $bookTeacher = BookTeacher::findFirst([
//            'conditions'    => 'id=:TeacherID:',
//            'bind'          => $conditions,
//        ]);
//        var_dump($bookTeacher);exit();
        $str = [];
        if ($this->request->isPost()){
            $code = $this->request->get('txtcode', 'trim');
            $fullname = $this->request->get('txtfullname' , 'trim');
            $phone = $this->request->get('txtphone');
            $email = $this->request->get('txtemail', 'trim');
            $address = $this->request->get('txtaddress', 'trim');
            $facebook = $this->request->get('txtfacebook');
            $youtube_chanel = $this->request->get('txtyoutube_chanel');

//            $book_code = $this->request->get('txtbook_code');

            $teacher->code = $code;
            $teacher->fullname = $fullname;
            $teacher->phone = $phone;
            $teacher->email = $email;
            $teacher->address = $address;
            $teacher->facebook = $facebook;
            $teacher->youtube_chanel = $youtube_chanel;
//            $bookTeacher->book_code = $book_code;
            $success = $teacher->save();

//            if ($teacher->save() && $bookTeacher->save()){
            if ($success){
                $this->flashSession->success('Chỉnh sửa nhân viên thành công!');
                return $this->response->redirect('teacher');
            } else {
                $messages  =$teacher->getMessages();
//                var_dump($messages);exit();
                foreach ($messages as $message){
//                    $this->flashSession->error($message);
                    $str[$message->getField()] = $message->getMessage();
                }
            }
        }
//        $this->view->setVar('teacher' , $teacher);
        $this->view->setVars(['teacher' => $teacher, 'str' => $str]);
    }

    public function detailAction()
    {

    }

    public function deleteAction($id){
//        var_dump($id);exit();
        $conditions = ['teacherID' => $id];
        $teacher = Teacher::findFirst([
            'conditions' => 'id=:teacherID:',
            'bind'       => $conditions,
        ]);
//        var_dump($teacher);exit();

//        $conditions_teacherBook = ['TeacherCode' => $teacher->code];
//        $bookTeacher = BookTeacher::findFirst([
//            'conditions'    => 'teacher_code=:TeacherCode:',
//            'bind'          => $conditions_teacherBook,
//        ]);
//        var_dump($bookTeacher); exit();
//        if ($teacher->delete() === false || $bookTeacher->delete() == false){
        if ($teacher->delete() === false){
            $messages = $teacher->getMessages();
            foreach ($messages as $message){
                $this->flash->error($message);
            }
        }else {
            $this->flashSession->success('Chúc mừng bạn đã xóa thành công!');
            return $this->response->redirect('teacher');
        }
    }

    public function changeActiveAction($id)
    {
        $this->view->disable();
        $teacher = Teacher::findFirst($id);
        if ($this->request->isAjax()) {
            $update = $teacher->update(
                [
                    'publish' => $teacher->publish == 0 ? 1 : 0,
                ]
            );
            if ($update)
            {

                return json_encode(["Active" =>$update, "status" => 200]);

            }
            else
            {

                return json_encode(["Active" =>$update,"status" => 400 ]);
            }
        }
    }

    public function deleteModelAction($id){
//        var_dump($id);exit();
        $conditions = ['teacherID' => $id];
        $teacher = Teacher::findFirst([
            'conditions' => 'id=:teacherID:',
            'bind'       => $conditions,
        ]);
        if ($teacher->delete() === false){
            $messages = $teacher->getMessages();
            foreach ($messages as $message){
                $this->flash->error($message);
            }
        }else {
            $this->flashSession->success('Chúc mừng bạn đã xóa thành công!');
            return $this->response->redirect('teacher');
        }
    }


    public function kiemtratrungAction(){
        $this->view->disable();
        //lay tham so tu request
        $code = $this->request->getPost('code', 'trim');
//        console.log($code);
        //kiem tra trung trong CSDL (findfirst())
        $data = Teacher::findFirst(
            [
                'code = :code:',
                'bind'          => [
                    'code' => $code
                ],
            ]
        );
        if (! $data){
            echo true;
        }else{
            echo false;
        }
        die;
    }

    public function bookTeacherAction(){
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );
        $book_code = $this->request->getPost('databook');
        $aha = [];

        $teacherBook  = Teacher::find([
            'conditions'  =>  'id = :id:',
            'bind'  =>  [
                'id'  =>  $book_code,
            ],
        ]);
        foreach ($teacherBook as $value){
            $ab = $value->BookTeacher ? $value->BookTeacher : NULL;
            if($ab){
                foreach ($value->BookTeacher as $va){
                    $aha[] = [
                        'name' => $va->Book->name,
                        'class_id' => $va->Book->class_id
                    ];
                }
            }
        };
        return json_encode($aha);

    }
     public function catrucAction()
    {
        $this->assets->addCss('node_modules/fullcalendar/core/main.css');
        $this->assets->addCss('node_modules/fullcalendar/timegrid/main.min.css');

        $this->assets->addJs('node_modules/fullcalendar/core/main.min.js');
        $this->assets->addJs('node_modules/fullcalendar/interaction/main.min.js');
        $this->assets->addJs('node_modules/fullcalendar/daygrid/main.min.js');
        $this->assets->addJs('node_modules/fullcalendar/timegrid/main.js');
        $this->assets->addJs('node_modules/fullcalendar/resource-common/main.js');
        $this->assets->addJs('node_modules/fullcalendar/resource-daygrid/main.min.js');
        $this->assets->addJs('node_modules/fullcalendar/resource-timegrid/main.js');
        $this->assets->addJs('assets/js/tooltip.min.js');
        $this->assets->addJs('assets/js/calendar.js');

        if ($this->request->isPost()) {
            $this->persistent->filterCalendar = $this->request->getPost();
        }

        if (isset($this->persistent->filterCalendar)) {
            if (isset($this->persistent->filterCalendar['reset'])) {
                $this->persistent->remove('filterCalendar');
            }
            foreach ($this->persistent->filterCalendar as $key => $val) {
                $this->tag->setDefault($key, $val);
            }
        }

        // $subjects = Subject::find()->toArray();
        // $grades = Grade::find()->toArray();

        $subject = $grade = [];
        foreach ($subjects as $key => $val) {
            $subject[$val['id']] = $val['name'];
        }

        foreach ($grades as $keys => $vals) {
            $grade[$vals['id']] = $vals['name'];
        }
        
        $this->view->setVars([
            'subject' => $subject,
            'grade' => $grade
        ]);
        $this->view->pick('teacher/catruc');
    }

}

