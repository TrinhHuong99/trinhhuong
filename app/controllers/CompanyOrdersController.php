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
class CompanyOrdersController extends \ControllerBase
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

    $company_name = $this->request->getQuery('company_name');
        $currentPage = (int) $this->request->getQuery('page', 'int'); // GET
        $w = '';
        if (!empty($company_name)) {
          $w .= ' AND company_name like '.'"%'.$company_name.'%"'.'';
        }
        $pages = $currentPage ? $currentPage : 1;
        $off = ($pages -1)*15;
        $phql = "SELECT DISTINCT company_orders.* FROM  CompanyOrders as company_orders
                  WHERE company_orders.id IS NOT NULL ".$w;
        $paginate = $this->modelsManager->executeQuery($phql)->toArray();

        $phql1 = "SELECT DISTINCT company_orders.* FROM CompanyOrders as company_orders
                  WHERE company_orders.id IS NOT NULL  ".$w." ORDER BY company_orders.id DESC LIMIT ".$off.",15";

        $company = $this->modelsManager->executeQuery($phql1);
        // echo "<pre>";
        // var_dump($phql1);
        // exit();
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
        $urlPattern = $this->url->get('companyorders/?page=(:num)&'.$search);
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow(7);
        $this->view->setVars(
          [
            'company'=>$company,
            'count' =>$count,
            'paginator'=>$paginator,
            'off' =>$off,
          ]);
      }
      public function createAction()
      {
        $this->assets->addJs('//cdn.ckeditor.com/4.5.9/standard/ckeditor.js');
        $teachers = Teacher::find(['conditions' => 'publish = :status:', 'bind'=>['status' =>1]]);

        $companyorders = new CompanyOrders();
 
        if($this->request->isPost())
        { 
        $company_name = $this->request->getPost('company_name');
        $address = $this->request->getPost('address');
        $linkweb = $this->request->getPost('linkweb');
        $created_bys = $this->session->get('user_fullname');

        $companyorders->company_name = $company_name;
        $companyorders->address = $address;
        $companyorders->linkweb = $linkweb;
        $companyorders->created_by = $created_bys;

         $success = $companyorders->save();

        if($success)
        {
          $this->flashSession->success('Thêm công ty thành công');
          $this->response->redirect('companyorders');
        }
        else
        {
          $messages  =$companyorders->getMessages();
          foreach ($messages as $message)
          {
            $this->flashSession->error($message);
          }
          Phalcon\Tag::setDefaults(get_object_vars($companyorders));

        }

      }
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
      $companyorders = CompanyOrders::findFirst($id);

      $this->view->setVars(['companyorders'=>$companyorders]);
    }

    public function updateAction($id)
    {
      $companyorders = CompanyOrders::findFirst($id);
  
       if($this->request->isPost())
      { 
      $company_name = $this->request->getPost('company_name');
      $address = $this->request->getPost('address');
      $linkweb = $this->request->getPost('linkweb');
      $created_bys = $this->session->get('user_fullname');

      $companyorders->company_name = $company_name;
      $companyorders->address = $address;
      $companyorders->linkweb = $linkweb;
      $companyorders->created_by = $created_bys;
      $success = $companyorders->save();
      if($success)
      {
        $this->flashSession->success('Chỉnh sửa công ty  thành công');
        $this->response->redirect('companyorders');
      }
      else
      {
        $messages  =$companyorders->getMessages();
        foreach ($messages as $message)
        {
          $this->flashSession->error($message);
        }
        return $this->dispatcher->forward(
          [
            'controller' => 'companyorders',
            'action' => 'edit',
            'params' => [$companyorders->id]
          ]
        );
      }
    }
  }


  public function deleteAction($id)
  {
    $company = CompanyOrders::findFirst($id);

    if($company->delete())
    {
      $this->flashSession->success('Xóa đơn công ty thành công');
      $this->response->redirect('companyorders');
    }

  }

}