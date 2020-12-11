<?php

declare(strict_types=1);

namespace User\Controller;

use Laminas\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Result;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Session\SessionManager;
use Laminas\View\Model\ViewModel;
use User\Form\Auth\LoginForm;
use User\Model\Table\UsersTable;

class LoginController extends AbstractActionController
{
	private $adapter;    # database adapter
	private $usersTable; # table we store data in

	public function __construct(Adapter $adapter, UsersTable $usersTable)
	{
		$this->adapter = $adapter;
		$this->usersTable = $usersTable;
	}

	public function indexAction()
	{
		$auth = new AuthenticationService();
		
		$loginForm = new LoginForm();
		$request = $this->getRequest();

		if($request->isPost()) {
			$formData = $request->getPost()->toArray();
			$loginForm->setInputFilter($this->usersTable->getLoginFormFilter());
			$loginForm->setData($formData);

			if($loginForm->isValid()) {
				$authAdapter = new CredentialTreatmentAdapter($this->adapter);
				$authAdapter->setTableName($this->usersTable->getTable())
				            ->setIdentityColumn('email')
				            ->setCredentialColumn('password')
				            ->getDbSelect()->where(['active' => 1]);

				$data = $loginForm->getData();
				$authAdapter->setIdentity($data['email']);

				$hash = new Bcrypt();
				$info = $this->usersTable->fetchAccountByEmail($data['email']);

				if($hash->verify($data['password'], $info->getPassword())) {
					$authAdapter->setCredential($info->getPassword());
				} else {
					$authAdapter->setCredential(''); 
				}
				$authResult = $auth->authenticate($authAdapter);

				switch ($authResult->getCode()) {
					case Result::FAILURE_IDENTITY_NOT_FOUND:
						$this->flashMessenger()->addErrorMessage('No se encontro el email!');
						return $this->redirect()->refresh(); 
						break;

					case Result::FAILURE_CREDENTIAL_INVALID:
						$this->flashMessenger()->addErrorMessage('Password incorrecto!');
						return $this->redirect()->refresh();
						break;
						
					case Result::SUCCESS:
						$storage = $auth->getStorage();
						$storage->write($authAdapter->getResultRowObject(null, ['created']));
						//print_r($info);die();
						if($info->getRoleId() == 1){
							return $this->redirect()->toRoute(
								'articulos', 
								[
									'id' => $info->getUserId(),
									'username' => mb_strtolower($info->getUsername())
								]
							);
						}else{
							return $this->redirect()->toRoute(
								'publicados', 
								[
									'id' => $info->getUserId(),
									'username' => mb_strtolower($info->getUsername())
								]
							);
						}
						

						break;		
					
					default:
						$this->flashMessenger()->addErrorMessage('La autenticación falló, intente mas tarde');
						return $this->redirect()->refresh(); # refresh the page to show error
						break;
				}
			}
		}

		return (new ViewModel(['form' => $loginForm]))->setTemplate('user/auth/login');
	}

}