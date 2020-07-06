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
use Phalcon\Mvc\View;
use JasonGrimes\Paginator;
class UserController extends \ControllerBase
{
    public function initialize()
    {
        parent::initialize();
        //css
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

        //js
        $this->assets->addJs('assets/pages/form-validation/validate.js');
        $this->assets->addJs('bower_components/select2/js/select2.full.min.js');
        $this->assets->addJs('bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js');
        $this->assets->addJs('bower_components/multiselect/js/jquery.multi-select.js');
        $this->assets->addJs('assets/pages/advance-elements/select2-custom.js');
        $this->assets->addJs('assets/pages/form-validation/validate.js');
        $this->assets->addJs('bower_components/bootstrap-daterangepicker/js/daterangepicker.js');
        $this->assets->addJs('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js');
        $this->assets->addJs('js/myjs.js');


        //them css hoac js ma xu ly rieng (do minh viet hoac tu thu vien) cho tung trang vao day (neu can thiet)
    }

    public function beforeExecuteRoute($dispatcher)
    {
        $abc = $this->session->get('user');
//        var_dump($abc['role']);exit();
        $role = $abc['role'];
        if ($role == '1') {
            $this->flashSession->error(
                "Bạn không có quyền vào quản lý người dùng"
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
        $username = $this->request->getQuery('username');
        $fullname = $this->request->getQuery('fullname');
        $phone = $this->request->getQuery('phone');
        $address = $this->request->getQuery('address');
        $startDate = $this->request->getQuery('startDate');
        $endDate =$this->request->getQuery('endDate');
        if (!empty($startDate)){
          $fomatstart = date_create_from_format('Y-m-d H:i:s', $startDate . ' 00:00:00')->getTimestamp();
      }
      if (!empty($endDate)){
          $fomatend = date_create_from_format('Y-m-d H:i:s', $endDate . ' 23:59:59')->getTimestamp();
      }
      $currentPage = (int) $this->request->getQuery('page', 'int');
      if (!empty($username)) {
        $w .= ' AND username like "%'.$username.'%"';
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
    if (!empty($startDate)) {
        $w .= ' AND UNIX_TIMESTAMP(created_at) >=  '.$fomatstart.'';
    }
    if (!empty($endDate)) {
        $w .= ' AND UNIX_TIMESTAMP(created_at) <= '.$fomatend.'';
    }
    $paginate = Users::find([
        'conditions'  =>'publish  = ?1' . $w,
        'bind' =>[
            '1' => 1

        ],
        'order' => 'id DESC',
    ]);
    $pages = $currentPage ? $currentPage : 1;
    $off = ($pages -1)*15;
    $users = Users::find([
        'conditions'  =>'publish  = ?1' . $w,
        'limit' =>15,
        'offset' => ($pages -1)*15,
        'bind' =>[
            '1' => 1

        ],
        'order' => 'id DESC',
    ]); 
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
    $urlPattern = $this->url->get('user/?page=(:num)&'.$search);
    $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
    $paginator->setMaxPagesToShow(7);

    $countuser = count($paginate);
    $this->view->setVars(
        [
            'users'=>$users,
            'username'=>$username,
            'fullname'=>$fullname,
            'phone'=>$phone,
            'countuser'=>$countuser,
            'address'=>$address,
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'paginator'=>$paginator,
            'off'=>$off

        ]);
}
public function createAction()
{
    $users = new Users();
    $name = $this->session->get('user_fullname');
    if($this->request->isPost())
    {

               $users->username = $this->request->getPost('username');
               $users->fullname = $this->request->getPost('fullname');
               $users->email = $this->request->getPost('email');
               $users->phone = $this->request->getPost('phone');
               $users->password  = $this->security->hash($this->request->getPost('password'));
               $users->address = $this->request->getPost('address');
               $users->role = $this->request->getPost('role');
               $users->position = $this->request->getPost('position');
               $users->department = $this->request->getPost('department');
               $users->created_by = $name;
               $success = $users->save();

               if($success)
               {
                $this->flashSession->success('Thêm thành công');
                $this->response->redirect('index');
            }
            else
            {
                $messages  =$users->getMessages();
                foreach ($messages as $message)
                {
                    $this->flashSession->error($message);
                }
            }
        }

    }

    public function addvalidateuserAction()
    {
        $this->view->setRenderLevel(
            View::LEVEL_NO_RENDER
        );
        $username = $this->request->getPost('username', 'trim');
        $emailuser = $this->request->getPost('email');
        $emails = Users::findFirst(
            [
                'conditions' => 'email = :emailuser:',
                'bind' =>[
                    'emailuser' => $emailuser

                ]
            ]
        );
        $users = Users::findFirst(
            [
                'conditions' => 'username = :username:',
                'bind' =>[
                    'username' =>$username,
                ]
            ]
        );

        return json_encode(['user'=>!empty($users) ? true : false ,'email'=>!empty($emails) ? true : false , 'status'=>400 ]);
    } 


    public function editAction($id)
    {
        $users = Users::findFirst($id);
        $this->view->setVar('users',$users);
    }
    public function updateAction($id)
    {
         $name = $this->session->get('user_fullname');
         $users = Users::findFirst($id);
         if($this->request->isPost())
            $password = $this->request->getPost('password');
        { 


            $users->username = $this->request->getPost('username');
            $users->fullname = $this->request->getPost('fullname');
            $users->email = $this->request->getPost('email');
            $users->phone = $this->request->getPost('phone');
            if (!empty($password)){
                $users->password  =$this->security->hash($password);
            }
            $users->address = $this->request->getPost('address');
            $users->role = $this->request->getPost('role');
            $users->position = $this->request->getPost('position');
            $users->department = $this->request->getPost('department');
            $users->created_by = $name;
            $success = $users->save();
            if($success)
            {
                $this->flashSession->success('Chỉnh sửa thông tin nhân viên thành công');
                $this->response->redirect('user');
            }
            else
            {
                $messages  =$users->getMessages();
                foreach ($messages as $message)
                {
                    $this->flashSession->error($message);
                }

                return $this->dispatcher->forward(
                    [
                        'controller' => 'user',
                        'action' => 'edit',
                        'params' => [$users->id]
                    ]
                );

            }
        }

    }
    public function detailAction($id)
    {
        $users = Users::findFirst($id);
        $this->view->setVar('users',$users);   
    }
    public function deleteAction($id)
    {
        $users = Users::findFirst($id);
         if($users->delete())
         {
            $this->flashSession->success('Xóa tài khoản thành công !');
            $this->response->redirect('user');
        }
    }
}

