<?php                                
        //requerir el fichero router
        
        require '../core/Router.php';
        require '../app/controllers/Post.php';
        

       //instancia de la clase router
       $router = new Router();

    //vamos accediendo a nuestras endpoint dentro de la api
    $url = $_SERVER['QUERY_STRING'];
    echo 'URL = '.$url.' <br>';


    /************************definir las rutas********************************************/

    $router->add('/public/post/get',array(
        'controller' => 'Post',
        'action' => 'getAllPosts'
    ));

    $router->add('/public/post/get/{id}',array(
        'controller' => 'Post',
        'action' => 'getPostById'
    ));

    $router->add('/public/post/create',array(
        'controller' => 'Post',
        'action' => 'createPost'
    ));

    $router->add('/public/post/update/{id}',array(
        'controller' => 'Post',
        'action' => 'updatePost'
    ));

    $router->add('/public/post/delete/{id}',array(
        'controller' => 'Post',
        'action' => 'deletePost'
    ));





    //pintar por pantalla las rutas que nos devuelve el enrutador metodo getRoutes()

    // echo '<pre>';
    // print_r($router->getRoutes()) . ' <br>';
    // echo '</pre>';

//*************************FRONT CONTROLLER******************************************* */

$urlParams = explode('/',$url); //esto nos creara un array separando la url del navegador

$urlArray = array (
    'HTTP' => $_SERVER['REQUEST_METHOD'],
    'path' => $url, //este campo obtiene la url completa y comprueba en router a ver si existen o estan dadas de alta en el router
    'controller' => '', 
    'action' => '',
    'params' => ''
);

//********************************VALIDACION******************************************* */


    if(!empty($urlParams[2])){ //si esta vacio es que no estamos recibiendo ningun controlador
        $urlArray['controller'] = ucwords($urlParams[2]); //ucwords nos convierte la primera letra en mayuscula

        if(!empty($urlParams[3])){   //este if recoge el metodo
            $urlArray['action'] = $urlParams[3];

           if(!empty($urlParams[4])){
                $urlArray['params'] = $urlParams[4];
           }
        }else{
            $urlArray['action'] = 'index';
        }

    }else { // si el parametro controller no es valido o esta vacio se redirije a Home
        $urlArray['controller'] = 'Home';
        $urlArray['action'] = 'index';
    }

    echo '<pre>';
    print_r($urlArray) . '<br>';
    echo '</pre>';


    //MOSTRAMOS LAS RUTAS

    if($router->matchRoutes($urlArray)){



         // SABER QUE METODO HTTP ESTA UTILIZANDO EL CLIENTE
         $method = $_SERVER['REQUEST_METHOD'];

        // ARRAY DE PARAMETROS
        $params = [];

        // ESTRUCTURA ITERATIVA
        if($method === 'GET'){
            $params[]=intval($urlArray['params']) ?? null; //intval
    
        }elseif($method === 'POST') {
    
            $json = file_get_contents('php://input');  // Leer el cuerpo de la solicitud como JSON
            $params[]=json_decode($json,true); // Decodificar el JSON y añadir al array $params
        }elseif($method === 'PUT') {
            
            $id=intval($urlArray['params']) ?? null;  // Convertir a entero y asignar a $id
            $json = file_get_contents('php://input'); // Leer el cuerpo de la solicitud como JSON
            $params[]=$id;  // Añadir $id al array $params
            $params[]=json_decode($json,true); // Decodificar el JSON y añadir al array $params
    
        }elseif($method === 'DELETE'){
            $params[]=intval($urlArray['params']) ?? null; //intval
        }

         //aqui se llama al controlador y al metodo que nos interesa cargar en funcion de lo que nos llega por la URL
         $controller= $router->getParams()['controller'];
         $action = $router->getParams()['action']; 
         $controller = new $controller(); //la variable controller ahora es de tipo POST 

         // Se verifica si el método especificado existe en el controlador

        if(method_exists($controller, $action)){
            // Se llama al método del controlador y se le pasan los parámetros
            $resp = call_user_func_array([$controller,$action], $params);
        }else{
            // Si el método no existe en el controlador, se muestra un mensaje de error
            echo 'el metodo no existe';
        }
    }else{
        echo "No route found by URL" .$url;
    }


?>
