<?php
    class Router {

        //1 atributo
        protected $routes = array(); // array donde vamos a definir las rutas
        protected $params = array();
        //2 metodos

        //metodo añadir que recibe dos parametros route y param este sera un array para definir una ruta
        public function add($route, $params) {
            //añadir al array routes
            $this->routes[$route] = $params; //indicarmos a que controlador y a que metodo del controlaror tiene que llamar
        }

        public function getRoutes(){ //funcion que devuelve el parametro de ruta para que se vea desde el index

            return $this -> routes;
        }

        public function matchRoutes($url){
            foreach ($this -> routes as $route => $params)
            {
                $pattern = str_replace(['{id}','/'], ['([0-9]+)','\/'], $route);
                $pattern = '/^' . $pattern. '$/';   //concatenar al patron las / necesarias para la URL

                if(preg_match($pattern,$url['path'])){ //evaluar si la url que estamos recibiendo nos encaja con el patron
                    $this -> params = $params;
                    return true;
                }   
            }
            return false;
        }

        /*****************ROUTING***************** */

        // 1º FUNCION
         /**Mirar si la url que recibimos en el navegador es la misma que la declarada en el router */
        // 1º funcion
        
    //    public function match($url){

    //     foreach ($this -> routes as $route => $params)
    //     {
    //         if($url['path'] == $route)
    //         {
    //             if($params['controller'] == $url['controller'] && $params['action'] == $url['action']){
    //                 $this->params = $params;
    //                 return true;
    //             }else {
    //                 return false;
    //             }
    //         }
    //     }
    //    }
        // 2º FUNCION
        public function getParams(){
            return $this-> params;
        }
    }
?>