<?php
require_once './app/models/clothes.model.php';
require_once './app/views/api.view.php';

class clothesApiController {
    private $model;
    private $view;

    private $data;

    public function __construct() {
        $this->model = new clothesModel();
        $this->view = new ApiView();
        
        // lee el body del request
        $this->data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }


        /** ==================================================================
         **     //Filtra los productos de ambas tablas por columna y atributo (sin comodines):
         ** ===================================================================== */
           

       public function getClothes($params = null) {

        if (!empty ($_GET ['column'])  && !empty ($_GET ['search'] )){
            $column = $_GET ['column'];//columna en la cual buscar
            $search= $_GET['search'];//atributo especifico a buscar
            
         //si el array con todas las columnas de ambas tablas para comparar los nombres 
          $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
          if (in_array($column, $columns)) {//se compara si el nombre de la columna se halla en la lista
             //si es asi envia al model los datos
            $clothes =$this->model->getFilter($column,$search);
           //si regresa un arreglo valido lo imprime
           if($clothes==true){
            $this->view->response ($clothes, 200);

           }else{
            $this->view->response ("Atributo no encontrado.", 404);

           }
               
          }else  {
            $this->view->response ("Nombre invalido de columna. ", 400);
            }
           
          
          }   
        

        /** ==================================================================
         **  ordena los productos  de una columna por orden desc o asc :
         ** ===================================================================== */
    
            //trae las variables  en el get
            if (!empty ($_GET ['sort'])  && !empty ($_GET ['order'] )){
                $sort = $_GET ['sort'];
                $order= $_GET['order'];

             //llama la funcion con el arreglo de las columnas
             $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
             
             //compara si esa columna es parte del arreglo
              if((in_array($sort, $columns)) && (($order == "asc") || ($order == "desc"))){
             
             //llama a la funcion del model de ordenar   
                $clothes =$this->model->getOrder($sort,  $order);
                    $this->view->response ($clothes, 200);
              }else{
                $this->view->response ("para ordenar coloque asc /desc o especifique un nombre de columna valido ", 400);
                }
              }


            
        
            /** ==================================================================
             **   Paginacion con filtro por una colunma determinada
             ** ===================================================================== */
    
             //si las variables select (selecciona una columna), starAt (indica inicio de las filas a traer) y endAt(fin de las filas)
            // estan seteadas
            if (isset ($_GET ['select'])  && isset($_GET ['starAt'] ) && isset ($_GET ['endAt'])){
                $select = $_GET ['select'];
                $starAt = $_GET ['starAt'];
                $endAt= $_GET['endAt'];

                //se llama al arreglo de columnas para comprobar si existe esa columna

                $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
                // se compara la columna con el arreglo
                //se controla que los datos sean numericos

                if((is_numeric($starAt)) && (is_numeric($endAt)) && (in_array($select, $columns)) && ( $starAt >= 0)) {


               // if((in_array($select, $columns)) && ( $starAt >= 0)) {

                    //se llama a la funcion del model que realiza la paginacion
                    $clothes =$this->model->getLimit($select,$starAt,$endAt);

                    // si regresa un arreglo cargado
                    if($clothes==true){
                        $this->view->response ($clothes, 200);
                     
                    //si no trae nada:
                    }else{
                        $this->view->response ("No hay elementos para mostrar ", 404);

                    }
                    // si la columna no coincide:
                }else{
                  $this->view->response ("Los datos cargados son erroneos", 400);
                  }
                }
     
                    

                   
                
            
               /** ==================================================================
                **  Filtra los datos por tres columnas (busquedas especificas)  
                ** ===================================================================== */

                if (!empty ($_GET ['col1']) && !empty ($_GET ['col2'])&& !empty ($_GET ['col3'])){
                    $col1 = $_GET ['col1'];
                    $col2 = $_GET ['col2'];
                    $col3 = $_GET ['col3'];
                    
                    $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
            
                if((in_array($col1,$columns)) && (in_array($col1,$columns)) && (in_array($col1,$columns))){
  
                    $clothes =$this->model->getOneColumn($col1,$col2,$col3);
                    if($clothes==true){
                        $this->view->response ($clothes, 200);

                    }else{
                        $this->view->response ("No hay elementos para mostrar ", 404);

                    }
                    
                }else{
                  $this->view->response ("El nombre de la columna no es valido", 400);
                  }
                   
                }
      
                       
                /** ==================================================================
                 **  Muestra la tabla entera sin filtros ni limites
                 ** ===================================================================== */  


          
        
        else if (empty ($_GET ['column'])  &&  empty ($_GET ['search']) &&  empty ($_GET ['linkTo'])  &&  empty ($_GET ['equalTo']) && empty ($_GET ['select'])  &&  empty ($_GET ['starAt']) && empty ($_GET ['endAt']) && empty ($_GET ['table'])  &&  empty ($_GET ['category']) && empty ($_GET ['sort'])  &&  empty ($_GET ['order'])){

                 
                $clothes =$this->model->getAll();
                if( $clothes  ){
                    $this->view->response ($clothes, 200);

                }else{
                    $this->view->response ("no hay datos para mostrar",404);

                }
                 

                

                

            }
    }
            /** ==================================================================
             **  Muestra los datos segun un id determinado
             ** ===================================================================== */

         public function getCloth($params = null) {
        // obtengo el id del arreglo de params

        $id = $params[':ID'];
        $cloth = $this->model->get($id);

        // si no existe devuelvo 404

        
        if ($cloth){
            $this->view->response($cloth,200);

        }
            
        else {
            $this->view->response("El producto con el id=$id no existe", 404);
    }

        }


            /** ==================================================================
             **  Elimina datos segun el id
             ** ===================================================================== */
      

    public function deleteClothes($params = null) {
        $id = $params[':ID'];

        $cloth = $this->model->get($id);
        if ($cloth) {
            $this->model->delete($id);
            $this->view->response($cloth, 200);
        } else 
            $this->view->response("El producto con el id=$id no existe", 404);
    }


            /** ==================================================================
             **  Inserta datos a la tabla
             ** ===================================================================== */

    public function insertClothes($params = null) {
        $cloth= $this->getData();

        if (empty($cloth->id_clothes)|| empty($cloth->description) || empty($cloth->size) || empty($cloth->colour)|| empty($cloth->price) || empty($cloth->image) || empty($cloth->offers)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insert($cloth->id_clothes, $cloth->description, $cloth->size, $cloth->colour, $cloth->price, $cloth->image, $cloth->offers);
            $cloth = $this->model->get($id);
            $this->view->response($cloth, 201);
        }
    }

     public function getColumns(){
        $columns=$this->model->getColumns();
        var_dump($columns);

     }



     public function updateClothes($params = null) {
        $id = $params[':ID'];
        $cloth = $this->model->get($id);
        if ( !empty ($cloth)) {
            $body = $this->getData();
            $clothes = $this->model->info_clothes($body->id_clothes, $body->description, $body->size, $body->colour, $body->price, $body->image, $body->offers, $body->id);
            $this->view->response("Producto con id =$id actualizado con éxito", 200);
        }
        else {
            $this->view->response("producto con id =$id no encontrado", 404);
        }
           
    }
 

}


    
    

