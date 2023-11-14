<?php
    require_once 'config.php';
    require_once 'libs/router.php';
    require_once 'app/controllers/joyerias.api.controller.php';
    require_once 'app/controllers/accessorys.api.controller.php';
    
    $router = new Router();
    
    #                 endpoint          verbo             controller             método
    $router->addRoute('joyeria',        'GET',    'JoyeriaApiController', 'getAllJoyeria' );
    $router->addRoute('joyeria/:ID',    'GET',    'JoyeriaApiController', 'getJoyeria');
    $router->addRoute('joyeria',        'POST',   'JoyeriaApiController', 'createJoyeria');
    $router->addRoute('joyeria/:ID',    'PUT',    'JoyeriaApiController', 'updateJoyeria');
    $router->addRoute('joyeria/:ID', 'DELETE',      'JoyeriaApiController', 'deleteJoyeria');

   
    #                 endpoint          verbo               controller           método
    $router->addRoute('accesorio',      'GET',    'accessorysApiController', 'getAllAccessorys');
    $router->addRoute('accesorio/:ID',  'GET',    'accessorysApiController', 'getAccessory');
    $router->addRoute('accesorio',      'POST',   'accessorysApiController', 'createAccessory');
    $router->addRoute('accesorio/:ID',  'PUT',    'accessorysApiController', 'updateAccessory');
    $router->addRoute('accesorio/:ID', 'DELETE',  'accessorysApiController', 'deleteAccessory');
    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);