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

    $router->add('/public',array(
        'controller' => 'Home',
        'action' => 'index'
    ));

    $router -> add('/public/post/new',array(
        'controller' => 'Post',
        'action' => 'new'
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

    // LLamar a la funcion de match para pasarle la url
    if($router->match($urlArray)){
                                        //aqui se llama al controlador y al metodo que nos interesa cargar en funcion de lo que nos llega por la URL
        $controller= $router->getParams()['controller'];
        $action = $router->getParams()['action'];                                        

        $controller = new $controller(); //la variable controller ahora es de tipo POST 
        $controller -> $action();

    }else { // Si no hay match
        echo "No route found by URL" .$url;
    }

//  esto es para pintar en pantalla
      echo '<pre>';
        print_r($urlArray) . ' <br>';
      echo '</pre>';
?>
