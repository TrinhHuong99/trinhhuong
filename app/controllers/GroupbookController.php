<?php
/**
 * @link http://hocmai.vn/
 * @copyright Cong ty CP Dau tu va dich vu Giao duc
 * @license http://hocmai.vn/
 */
/**
 *
 * @author Doan Tiep - Created At: 11/04/2019 - 10:00 AM
 * @version 1.0.0
 *
 */
use JasonGrimes\Paginator;
use Phalcon\Mvc\View;
class GroupbookController extends \ControllerBase
{
	public function initialize()
	{
		parent::initialize();
		//css
    $this->assets->addCss('css/style.css');
		$this->assets->addCss('assets/css/groupbook.css');
    $this->assets->addCss('bower_components/select2/css/select2.min.css');
    $this->assets->addCss('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css');
    $this->assets->addCss('bower_components/multiselect/css/multi-select.css');
    $this->assets->addCss('assets/css/ukflex.css');
		//js
    $this->assets->addJs('js/myjs.js');
    $this->assets->addJs('bower_components/select2/js/select2.full.min.js');
    $this->assets->addJs('bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js');
    $this->assets->addJs('bower_components/multiselect/js/jquery.multi-select.js');
    $this->assets->addJs('assets/pages/advance-elements/select2-custom.js');
    $this->assets->addJs('assets/pages/form-validation/validate.js');
    $this->assets->addJs('assets/pages/form-validation/validate.js');

  }
    public function beforeExecuteRoute($dispatcher)
    {
        $abc = $this->session->get('user');
//        var_dump($abc['role']);exit();
        $role = $abc['role'];
        if ($role == '1') {
            $this->flashSession->error(
                "Bạn không có quyền vào quản lý loại sách"
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

        $code = $this->request->getQuery('code');
        $name = $this->request->getQuery('name');
        $currentPage = (int) $this->request->getQuery('page', 'int');
        $w = '';
        if (!empty($code)) 
        {
          $w .= ' AND code like "%'.$code.'%"';
        }
        if (!empty($name)) 
        {
           $w .= ' AND name like "%'.$name.'%"';
        }
       $paginate = BookGroup::find(
        [
          'conditions'  =>'created_at IS NOT NULL' . $w,
          
        ]
      );

       $pages = $currentPage ? $currentPage : 1;
       $off = ($pages -1)*15;
       $countuser =  count($paginate);
       $groupbooks = BookGroup::find([
        'conditions'  =>'created_at IS NOT NULL' . $w,
        'limit' =>15,
        'offset' => ($pages -1)*15,
        'order' => 'id DESC'
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
      $urlPattern = $this->url->get('groupbook/?page=(:num)&'.$search);
      $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
      $paginator->setMaxPagesToShow(7);
      $this->view->setVars(
        [
          'groupbooks' => $groupbooks,
          'code' => $code,
          'name' => $name,
          'countuser' => $countuser,
          'paginator' => $paginator,
          'off' =>$off,

        ]);

  }
  public function detailAction()
  {
      $groups = BookGroup::findFirst($id);
      $this->view->setVar('groups',$groups);
    }
    public function createAction()
    {
      if($this->request->isPost())
      {

       $groups = new BookGroup();

       $success = $groups->save($this->request->getPost());
       if($success)
       {
        $this->flashSession->success('Thêm loại sách thành công');
        $this->response->redirect('groupbook');
      }
      else
      {
        $messages  =$groups->getMessages();
        foreach ($messages as $message)
        {
          $this->flashSession->error($message);
        }

      }
    }
    }
  public function addvalidategroupAction(){
      $this->view->setRenderLevel(
        View::LEVEL_NO_RENDER
      );
      $code = $this->request->getPost('code', 'trim');
      $data = BookGroup::findFirst(
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
    $groups = BookGroup::findFirst($id);
    $this->view->setVar('groups',$groups);
  }
  public function updateAction($id)
  {
      if($this->request->isPost()){
       $groups = BookGroup::findFirst($id);
       $success = $groups->save($this->request->getPost());
       if($success)
       {
        $this->flashSession->success('Chỉnh sửa loại sách thành công');
        $this->response->redirect('groupbook');
      }
      else
      {
        $messages  =$groups->getMessages();
        foreach ($messages as $message)
        {
         $this->flashSession->error($message);
       }
       return $this->dispatcher->forward(
        [
          'controller' => 'groupbook',
          'action' => 'edit',
          'params' => [$groups->id]
        ]
      );

     }
    }
  }
  public function deleteAction($id)
  {
    $groupbook = BookGroup::findFirst($id);
    if($groupbook->delete())
    {
      $this->flashSession->success('Xóa loại sách thành công');
      $this->response->redirect('groupbook');
    }
  }
}