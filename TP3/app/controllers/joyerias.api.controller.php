<?php
 
    require_once 'app/models/joyerias.api.model.php';
    require_once 'app/views/Api.view.php';
    require_once 'app/controllers/api.controller.php';
    

    class JoyeriaApiController extends ApiController{
        private $view;
        private $model;
       
        function __construct(){
            parent::__construct();
            $this->model = new JoyeriaApiModel();
            $this->view = new ApiView();
            
        }
    
        function getAllJoyeria($paramns = null){
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

          
            else if (isset($_GET['bañado'])){
                $parametros['bañado'] = $_GET['bañado'];  
            
                $bañado = $this->model-> getMarcasFiltradas($parametros);

                    if($bañado!=[]){
                    $this ->view->response($bañado, 200);
                } else {
                    $this ->view->response('No existe el bañado= '.$_GET['bañado'].'.', 400);
                }
            }
            
            else if (empty($params)){
                $joyeria = $this->model->getAll();
                $this->view->response($joyeria,200);
            }
        }

        function getJoyeria($paramns = null){
            $id_tipo = $paramns[':ID'];
            $tipo = $this->model->get($id_tipo);
            if ($tipo){
                $this->view->response($tipo,200);
            }
            else{
                $this->view->response("no existe el id que esta buscando",400);
            }
            
        }

        function deleteJoyeria($paramns = null){
            $id =  $paramns[':ID'];
    
            $joyeria= $this->model->get($id);
    
            if ($joyeria){
               $this->model->delete($id);
               $this->view->response("se elimino con exito id: $id",200);
            }
            else{
                $this->view->response("no existe el id que desea eliminar $id",400);
            }
        }

        function createJoyeria($params = null) {
           
                $body = $this->getData(); 
                $marca = $body->marca;
                $precio = $body->precio;
                $bañado = $body->bañado;
                $id_joya = $body->id_joya;
            
                    if (empty ($marca) || empty ($precio) ||  empty ($bañado) ||  empty ($id_joya) ){
                        $this->view->response('ingrese de nuevo sus datos',400);
                        return;
                    }
            
                    $id = $this->model->insertar($marca, $precio, $bañado, $id_joya);
            
                    if ($id){
                        $this->view->response('La tarea fue insertada con el id='.$id, 201);
                    }
                    else{
                        $this->view->response('La tarea no fue insertada con el id='.$id, 400);
                    }
                  
        }

        function updateJoyeria($params = null){
           
                $id = $params[':ID'];
                $body = $this->getData();
    
                $joyeria = $this->model->get($id);
    
                if ($joyeria){
                    $marca = $body->marca;
                    $precio = $body->precio;
                    $bañado = $body->bañado;
                    $id_joya = $body->id_joya;
            
            
                    if (empty ($marca) || empty ($precio) ||  empty ($bañado) ||  empty ($id_joya) ){
                        $this->view->response('ingrese de nuevo sus datos',400);
                        return;
                    }
            
                    $this->model->actualizar($marca, $precio, $bañado, $id_joya, $id);
                    $this->view->response("se actualizo",200);
                }
                else{
                    $this->view->response("no existe en la db el id que desea actualizar",404);
                }      
        }

        function validarParametrosOrdenamiento($parametros){

            $camposPermitidos = ['id', 'marca', 'precio', 'bañado','id_joya'];
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

        



    