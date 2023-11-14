<?php

require_once './app/models/accesorys.api.model.php';
require_once './app/views/Api.view.php';
require_once './app/controllers/api.controller.php';



class accessorysApiController extends ApiController{

    private $model;
    private $view;
   

    function __construct(){
        parent::__construct();
        $this->model = new accessorysApiModel();
        $this->view = new ApiView(); 
    }

    
    function getAllAccessorys($paramns = null){
        $parametros = [];
        
        if (isset($_GET['sort'])) {
            $parametros['sort'] = $_GET['sort'];   
            if (isset($_GET['order'])){
                $parametros['order'] = $_GET['order'];   
            }     
            
            if ($this->validarParametrosOrdenamiento($parametros)) {
                $resultado = $this->model->order($parametros['sort'], $parametros['order']);
                $this->view->response($resultado, 200);
            } else {
                $this->view->response("Debe proporcionar un criterio de orden válido", 404);
            }
        }
       
        else if (isset($_GET['id_joya'])){
            $parametros['id_joya'] = $_GET['id_joya'];  
            
            $id_joya = $this->model-> getAccessorysFiltradas($parametros);

            if($id_joya!=[]){
                $this ->view->response($id_joya, 200);
            } else {
                $this ->view->response('No existe el accesorio= '.$_GET['id_joya'].'.', 400);
            }
        }
      
        else{
            $joyas = $this->model->getAll();
            $this->view->response($joyas,200);
        }
    }
    
    function getAccessory($paramns = null){
        $id_joya =  $paramns[':ID'];

        $joya = $this->model->get($id_joya);

        if ($joya){
            $this->view->response($joya,200);
        }
        else{
            $this->view->response("no existe el id que esta buscando",400);
        }
    }

    function deleteAccessory($paramns = null){
        $id =  $paramns[':ID'];

        $accesorio= $this->model->get($id);

        if ($accesorio){
           $this->model->delete($id);
           $this->view->response("se elimino con exito id: $id",200);
        }
        else{
            $this->view->response("no existe el id que desea eliminar $id",400);
        }
    }

    function createAccessory($params = null) {
        
        $body = $this->getData(); 
        $id_joya = $body->id_joya;

        if (empty ($id_joya)){
            $this->view->response('ingrese de nuevo sus datos',400);
            return;
        }

        $id = $this->model->insertar($id_joya);

        if ($id){
            $this->view->response('La tarea fue insertada con el id='.$id, 201);
        }
        else{
            $this->view->response('La tarea no fue insertada con el id='.$id, 400);
        }    
    }  

    function updateAccessory($params = null){
        
        $id = $params[':ID'];
        $body = $this->getData();

        $accesory = $this->model->get($id);

        if ($accesory){
            $id_joya = $body->id_joya;
        
        
            if (empty ($id_joya) ){
                $this->view->response('ingrese de nuevo sus datos',400);
                return;
            }
        
            $this->model->actualizar($id_joya,$id);
            $this->view->response("se actualizo",200);
        }
        else{
            $this->view->response("no existe en la db el id que desea actualizar",404);
        }
        
    }   
    function validarParametrosOrdenamiento($parametros){

        $camposPermitidos = ['id','id_joya'];
        $ordenesPermitidas = ['asc', 'desc'];
    
      
        if (!isset($parametros['sort']) || !in_array($parametros['sort'], $camposPermitidos)) {
            return false;
        }
    
        
        if (!isset($parametros['order']) || !in_array($parametros['order'], $ordenesPermitidas)) {
            return false;
        }
        return true;
    }

}