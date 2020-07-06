<?php
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{
    public function initialize()
    {
        //css
        $this->assets->addCss('bower_components/bootstrap/css/bootstrap.min.css');
        $this->assets->addCss('assets/icon/icofont/css/icofont.css');
        $this->assets->addCss('assets/css/style.css');
        $this->assets->addCss('assets/css/pages.css');

        //js
        $this->assets->addJs('bower_components/jquery/js/jquery.min.js');
        $this->assets->addJs('assets/pages/waves/js/waves.min.js');
        $this->assets->addJs('assets/js/common-pages.js');
    }

    public function indexAction()
    {

        if ($this->session->has("user_name")) {
            return $this->response->redirect('');

        }

    }

    public function forgotpasswordAction()
    {
        echo 1;
    }
    public function loginAction()
    {

        $username    = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = Users::findFirst(
            [
                'username = :username:',
                'bind'    => 
                [
                    'username' =>$username,
                ]
            ]);
        if ($user) 
        {
            if ($this->security->checkHash($password, $user->password)) 
            {
                $this->session->set('user', $user->toArray());
                $this->session->set('role', $user->role);
                $this->session->set('user_id', $user->id);
                $this->session->set('user_name', $user->username);
                $this->session->set('user_fullname', $user->fullname);
                return $this->response->redirect("");
            }
        } 
        else 
        {
                         // To protect against timing attacks. Regardless of whether a user
                         // exists or not, the script will take roughly the same amount as
                         // it will always be computing a hash.
            $this->security->hash(rand());
        }

        $this->flashSession->error('Tài khoản hoặc mật khẩu không đúng!');
        return $this->response->redirect("login");

               //The validation has failed
    }
    public function logoutAction()
    {

        $this->session->destroy(); 
        $this->dispatcher->forward(
            [
                'controller' => 'login',
                'action'     => 'index',
            ]
        );
    }
}


