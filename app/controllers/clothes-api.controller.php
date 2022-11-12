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
            $column = $_GET ['column'];
            $search= $_GET['search'];
            

          $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
          if (in_array($column, $columns)) {

            $clothes =$this->model->getFilter($column,$search);
           
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
    
            if (!empty ($_GET ['sort'])  && !empty ($_GET ['order'] )){
                $sort = $_GET ['sort'];
                $order= $_GET['order'];

             $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
            
              if((in_array($sort, $columns)) && (($order == "asc") || ($order == "desc"))){

                $clothes =$this->model->getOrder($sort,  $order);
                    $this->view->response ($clothes, 200);
              }else{
                $this->view->response ("para ordenar coloque asc /desc o especifique un nombre de columna valido ", 400);
                }
              }


            
        
            /** ==================================================================
             **  Muestra la lista por un numero dado de filas : (paginacion con filtro por una colunma determinada)
             ** ===================================================================== */
    
            if (!empty ($_GET ['select'])  && !empty ($_GET ['starAt'] ) && !empty ($_GET ['endAt'])){
                $select = $_GET ['select'];
                $starAt = $_GET ['starAt'];
                $endAt= $_GET['endAt'];

                $columns=$this->model->getColumns(); //traigo el array de los nombres de las columnas de las tablas
            
                if(in_array($select, $columns)) {
  
                    $clothes =$this->model->getLimit($select,$starAt,$endAt);
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
                **  Filtra los datos por una columna determinada  
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


}
    
    

//select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = 'business' and TABLE_NAME = 'clothes' order by ORDINAL_POSITION;
