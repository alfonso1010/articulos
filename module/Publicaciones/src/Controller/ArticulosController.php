<?php

declare(strict_types=1);

namespace Publicaciones\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Authentication\AuthenticationService;
use Laminas\View\Model\ViewModel;
use Publicaciones\Model\Table\ArticulosTable;
use Publicaciones\Model\Table\ComentariosTable;
use Publicaciones\Model\Table\OpinionesTable;
use Publicaciones\Form\Articulos\CreateForm;
use Publicaciones\Form\Articulos\ComentarioForm;
use RuntimeException;

class ArticulosController extends AbstractActionController
{
	private $articulosTable; # table we store data in
	private $comentariosTable; # table we store data in
	private $opinionesTable; # table we store data in

	public function __construct(ArticulosTable $articulosTable, ComentariosTable $comentariosTable, OpinionesTable $opinionesTable)
	{
		$this->articulosTable = $articulosTable;
		$this->comentariosTable = $comentariosTable;
		$this->opinionesTable = $opinionesTable;
	}
	public function indexAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		
		return new ViewModel(['articulos' => $this->articulosTable->fetchAllArticulos()]);
	}

	public function publicadosAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		
		return new ViewModel(['articulos' => $this->articulosTable->fetchAllArticulos()]);
	}

	public function createAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}

		$createForm = new CreateForm();
		$request = $this->getRequest();
    	if ($request->isPost()) {
    		$post = array_merge_recursive(
	            $request->getPost()->toArray(),
	            $request->getFiles()->toArray()
	        );
	    	$createForm->setData($post);

	    	if($createForm->isValid()) {
	    		try {
	    			$data = $createForm->getData();
	    			$img = file_get_contents($data['image-file']['tmp_name']); 
	    			if( is_null($img) | $img == "" ){
	    				$this->flashMessenger()->addErrorMessage('Por favor seleccione una imagen!');
	    				return $this->redirect()->refresh();
	    			}
					$img_64 = base64_encode($img); 
					$type = $data['image-file']['type'];
					if($type != "image/jpeg" & $type != "image/png" ){
						$this->flashMessenger()->addErrorMessage('El formato de la imagen debe ser jpg o png!');
	    				return $this->redirect()->refresh();
					}	
					$imagen_64 = "data:".$type.";base64,".$img_64;
					$storage = $auth->getIdentity();
					$datos = [
						'articulo' => $data['articulo'],
						'user_id'  => $storage->user_id,
						'foto'     => $imagen_64
					];
	    			$this->articulosTable->saveArticulo($datos); 
	    			$this->flashMessenger()->addSuccessMessage('Artículo Creado con éxito');
	    			return $this->redirect()->toRoute('articulos');
	    		} catch(RuntimeException $exception) {
	    			$this->flashMessenger()->addErrorMessage($exception->getMessage());
	    			return $this->redirect()->refresh(); # refresh this page to view errors
	    		}
	    	}
    	}
		return new ViewModel(['form' => $createForm]);
	}

	public function updateAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}

		$request = $this->getRequest();
		$params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
	    $articulo = $this->articulosTable->fetchArticuloById($id_articulo);
		$createForm = new CreateForm();
		$createForm->get('articulo')->setValue($articulo->getArticulo());
    	if ($request->isPost()) {
    		$post = array_merge_recursive(
	            $request->getPost()->toArray(),
	            $request->getFiles()->toArray()
	        );
	    	$createForm->setData($post);

	    	if($createForm->isValid()) {
	    		try {
	    			$data = $createForm->getData();
	    			$img = file_get_contents($data['image-file']['tmp_name']); 
	    			if( is_null($img) | $img == "" ){
	    				$imagen_64 = $articulo->getFoto();
	    			}else{
	    				$img_64 = base64_encode($img); 
						$type = $data['image-file']['type'];
						if($type != "image/jpeg" & $type != "image/png" ){
							$this->flashMessenger()->addErrorMessage('El formato de la imagen debe ser jpg o png!');
		    				return $this->redirect()->refresh();
						}	
						$imagen_64 = "data:".$type.";base64,".$img_64;
	    			}
					
					$storage = $auth->getIdentity();
					$datos = [
						'articulo' => $data['articulo'],
						'user_id'  => $storage->user_id,
						'foto'     => $imagen_64
					];
	    			$this->articulosTable->updateArticulo($datos,$id_articulo); 
	    			$this->flashMessenger()->addSuccessMessage('Artículo Actualizado con éxito');
	    			return $this->redirect()->toRoute('articulos');
	    		} catch(RuntimeException $exception) {
	    			$this->flashMessenger()->addErrorMessage($exception->getMessage());
	    			return $this->redirect()->refresh(); # refresh this page to view errors
	    		}
	    	}
    	}
		return new ViewModel(['form' => $createForm,'id_articulo' => $id_articulo]);
	}

	public function deleteAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		$request = $this->getRequest();
	    $params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
		$elimina = $this->articulosTable->deleteArticulo($id_articulo);
		
		$this->flashMessenger()->addSuccessMessage('Artículo eliminado con éxito.');
		return $this->redirect()->toRoute('articulos');
	}

	public function readarticuloAction(){
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		$storage = $auth->getIdentity();

		$comentarioForm = new ComentarioForm();
		$request = $this->getRequest();
		$params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
	    $articulo = $this->articulosTable->fetchArticuloById($id_articulo);
	    $comentarios = $this->comentariosTable->fetchAllComentariosByIdArticulo($id_articulo);
	    $opinion_usuario = $this->opinionesTable->fetchAllMeGustaByIdArticuloAndUser($id_articulo,$storage->user_id); 
	    $total_me_gusta = $this->opinionesTable->fetchAllMeGustaByIdArticulo($id_articulo);
	    $total_me_gusta =  count($total_me_gusta);
	    $total_no_me_gusta = $this->opinionesTable->fetchAllNoMeGustaByIdArticulo($id_articulo);
	    $total_no_me_gusta =  count($total_no_me_gusta);

	    if($request->isPost()) {
	    	$formData = $request->getPost()->toArray();
	    	$comentarioForm->setData($formData);
	    	if($comentarioForm->isValid()) {
	    		try {
	    			$data = $comentarioForm->getData();
	    			$datos = [
	    				'articulo_id' => $id_articulo,
	    				'user_id'  => $storage->user_id,
	    				'comentario'  => $data['comentario'],
	    			];
	    			$this->comentariosTable->saveComentario($datos); 
	    			$this->flashMessenger()->addSuccessMessage('Comentario publicado con éxito.');
	    			return $this->redirect()->toRoute('readarticulo',[],array( 'query' => array(
				        'id' => $id_articulo
				    )));
	    		} catch(RuntimeException $exception) {
	    			$this->flashMessenger()->addErrorMessage($exception->getMessage());
	    			return $this->redirect()->refresh(); # refresh this page to view errors
	    		}
	    	}
	    }

	    return new ViewModel([
	    	'articulo' => $articulo,
	    	'comentarios' => $comentarios,
	    	'form' => $comentarioForm,
	    	'id_articulo' => $id_articulo,
	    	'opinion_usuario' => $opinion_usuario,
	    	'total_me_gusta'  => $total_me_gusta,
	    	'total_no_me_gusta'  => $total_no_me_gusta,
	    ]);
	}

	public function megustaAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		$request = $this->getRequest();
	    $params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
		
		$storage = $auth->getIdentity();
		$datos = [
			'articulo_id' => $id_articulo,
			'user_id'  => $storage->user_id,
			'me_gusta'  => "1",
		];
		$this->opinionesTable->saveOpinion($datos); 
		
		$this->flashMessenger()->addSuccessMessage('Le ha gustado este artículo.');
		return $this->redirect()->toRoute('readarticulo',[],array( 'query' => array(
	        'id' => $id_articulo
	    )));
	}

	public function nomegustaAction()
	{	
		//verifica la session del iusuario
		$auth = new AuthenticationService();
		if(!$auth->hasIdentity()) {
			$this->flashMessenger()->addErrorMessage('Su sesión caducó');
			$auth->clearIdentity();
			# si no existe la session lo redirige al home
			return $this->redirect()->toRoute('home');
		}
		$request = $this->getRequest();
	    $params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
		
		$storage = $auth->getIdentity();
		$datos = [
			'articulo_id' => $id_articulo,
			'user_id'  => $storage->user_id,
			'me_gusta'  => "2",
		];
		$this->opinionesTable->saveOpinion($datos); 
		
		$this->flashMessenger()->addSuccessMessage('NO le ha gustado este artículo :( .');
		return $this->redirect()->toRoute('readarticulo',[],array( 'query' => array(
	        'id' => $id_articulo
	    )));
	}

	public function imagenAction(){
   	 // get image content
	    $response = $this->getResponse();
	    $request = $this->getRequest();
	    $params = $request->getQuery()->toArray();
	    $id_articulo = $params['id'];
	    $articulo = $this->articulosTable->fetchArticuloById($id_articulo);
	    $base_64 = $articulo->getFoto();
	  	$arr1 = explode(',', $base_64);
        $content = $arr1[0];
        $content = explode(";", $content);
        $content = explode(":", $content[0]);
        $type = $content[1];
        $base64 = $arr1[1];
	    $response->setContent(base64_decode($base64) );
	    $response
	        ->getHeaders()
	        ->addHeaderLine('Content-Transfer-Encoding', 'binary')
	        ->addHeaderLine('Content-Type', $type);

	    return $response;
	}
}