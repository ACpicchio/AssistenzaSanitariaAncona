<?php

class UserController extends Zend_Controller_Action
{
    protected $_authService;
    protected $_userModel;
    protected $_operModel;

    public function init()
    {
        $this->_helper->layout->setLayout('user');
        $this->_authService = new Application_Service_Auth();
        $this->_userModel = new Application_Model_User();
        $this->_operModel = new Application_Model_Oper();
    }

    public function indexAction()
    {

        $email = $this->_authService->getIdentity()->email;
        $utente = $this->_userModel->getUserByEmail($email);
        $this->view->assign(array(
                'utente' => $utente  )
        );
    }



    public function viewstaticAction() {
        $page = $this->_getParam('staticPage');
        $this->render($page);
    }


    public function operatoriAction()
    {

        $tipo = $this->getParam('tipo', null);
        $operatori = $this->_operModel->getOperByTipo($tipo);

        if ($operatori == NULL) {
            $this->view->assign(array(
                    'operatori' => NULL  )
            );
        }
        else {
            $this->view->assign(array(
                    'tipo' => $tipo  )
            );
            $this->view->assign(array(
                    'operatori' => $operatori  )
            );
        }
    }

    public function logoutAction() {
        $this -> _authService -> clear();
        return $this -> _helper -> redirector('index', 'public');
    }


}
