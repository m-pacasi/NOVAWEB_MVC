<?php

namespace MVC;

class Router {
    // public function __construct()
    // {
    //     echo "Creado el Router";
    // }
    public $rutasGET=[];
    public $rutasPOST=[];

     public function get($url,$fn){
         $this->rutasGET[$url] = $fn;
     }

     public function post($url, $fn) {
         $this->rutasPOST[$url] = $fn;
     }

    public function comprobarRutas(){

        session_start();
        $auth = $_SESSION['login'] ?? null;
        //arreglo de rutas protegidas
        $rutas_protegidas = ['/admin','/propiedades/crear','/propiedades/actualizar','/propiedades/eliminar','/vendedores/crear','/vendedores/actualizar','/vendedores/eliminar'];

          $urlActual = $_SERVER['PATH_INFO'] ?? '/';
          $metodo = $_SERVER['REQUEST_METHOD'];

          if ($metodo === 'GET'){
                $fn = $this->rutasGET[$urlActual] ?? null;
            //    debuguear($this->rutasGET);
             //    echo 'si fue un get';
          }else {
             $fn = $this->rutasPOST[$urlActual] ?? null;
          }

          if(in_array($urlActual,$rutas_protegidas) && !$auth){
                header('Location: /');
              
          }

          if($fn){
             call_user_func($fn, $this);
          }else{
             echo "Página no encontrada";
        
         }
      
    }
     //muestra una vista
     public function render($view, $datos = []){
      // Leer lo que le pasamos  a la vista
           foreach ($datos as $key => $value) {
             $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
         }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Limpia el Buffer
        include __DIR__ . '/views/layout.php';

    }

}