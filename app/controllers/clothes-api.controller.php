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
         **     //lista los productos por categoria segun id de la categoria:
         ** ===================================================================== */
           

       public function getClothes($params = null) {

        if (!empty ($_GET ['table'])  && !empty ($_GET ['category'] )){
            $table = $_GET ['table'];
            $category= $_GET['category'];


                $clothes =$this->model->getFilter($table,$category);
                if( $clothes){
                    $this->view->response ($clothes, 200);
                }else{
                    $this->view->response ("no hay datos para mostrar", 404);
                }
                


             }

 
        /** ==================================================================
         **  ordena los productos  de una columna por orden desc o asc :
         ** ===================================================================== */
    
             
            

            if (!empty ($_GET ['sort'])  && !empty ($_GET ['order'] )){
                $sort = $_GET ['sort'];
                $order= $_GET['order'];
                if(($order== "asc") || ($order == "desc")){
                    $clothes =$this->model->getOrder($sort,  $order);
                    $this->view->response ($clothes, 200);
        
                }else if (($order != "asc") || ($order != "desc")){

                    $this->view->response ("para ordenar coloque asc o desc ", 404);
                }
               
               
            }
            
            /** ==================================================================
             **  Muestra la lista por un numero dado de filas : (paginacion)
             ** ===================================================================== */
    
            if (!empty ($_GET ['select'])  && !empty ($_GET ['starAt'] ) && !empty ($_GET ['endAt'])){
                $select = $_GET ['select'];
                $starAt = $_GET ['starAt'];
                $endAt= $_GET['endAt'];
                
                    $clothes =$this->model->getLimit($select,$starAt,$endAt);
                    if( $clothes  ){
                        $this->view->response ($clothes, 200);
    
                    }else{
                        $this->view->response ("no hay datos para mostrar", 404);
    
                    }
                    

                   
                }
            
               /** ==================================================================
                **  Filtra los datos de una columna determinada y segun un dato especifico
                ** ===================================================================== */

                if (!empty ($_GET ['linkTo'])  && !empty ($_GET ['equalTo'] ) ){
                    $linkTo = $_GET ['linkTo'];
                    $equalTo = $_GET ['equalTo'];


                    if (($linkTo=="id" )|| ($linkTo=="id_clothes" )|| ($linkTo=="description" )||($linkTo=="size" )||($linkTo=="colour" )||($linkTo=="price" )||($linkTo=="image" )||($linkTo=="oferta" )){
                        $clothes =$this->model->getFilterTo($linkTo,$equalTo);
                        if( $clothes  ){
                            $this->view->response ($clothes, 200);
        
                        }else{
                            $this->view->response ("no hay datos para mostrar", 404);
        
                        }
                       
                    }else{
                        $this->view->response ("No existe esa columna", 400);

                    }

                    }
                    
                    
                       
                /** ==================================================================
                 **  Muestra la tabla entera sin filtros ni limites
                 ** ===================================================================== */  


          
        
        else if (empty ($_GET ['linkTo'])  &&  empty ($_GET ['equalTo']) && empty ($_GET ['select'])  &&  empty ($_GET ['starAt']) && empty ($_GET ['endAt']) && empty ($_GET ['table'])  &&  empty ($_GET ['category']) && empty ($_GET ['sort'])  &&  empty ($_GET ['order'])){

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

     }


}
    
    

//select COLUMN_NAME from INFORMATION_SCHEMA.COLUMNS where TABLE_SCHEMA = 'business' and TABLE_NAME = 'clothes' order by ORDINAL_POSITION;
