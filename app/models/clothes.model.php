<?php

class clothesModel {

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=business;charset=utf8', 'root', '');
    }

    

//muestra toda la lista de productos
    public function getAll() {

        
        $query = $this->db->prepare("SELECT * FROM clothes");//selecciono toda la lista de la tabla clothes
        $query->execute();                  //envio la consulta        
        

        $clothes = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $clothes;  //reenvia el arreglo al controlador
    }



    public function getFilter($table = null,  $category= null) {
        

        if( $table  && $category){
         $query = $this->db->prepare("SELECT * FROM clothes JOIN brand ON clothes.id_clothes = brand.id_brand WHERE id_brand = $category;");//selecciono toda la lista de la tabla clothes
        $query->execute();                  //envio la consulta        
        $clothes = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $clothes;  //reenvia el arreglo al controlador
    }

    }


    public function getOrder($sort,  $order) {

        
         $query = $this->db->prepare("SELECT * FROM clothes ORDER BY $sort  $order ;");//selecciono toda la lista de la tabla clothes
        $query->execute();                  //envio la consulta        
        $clothes = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
        
        return $clothes;  //reenvia el arreglo al controlador
    

    }

    public function getLimit($select,$starAt,$endAt) {

        
        $query = $this->db->prepare("SELECT $select FROM clothes LIMIT $starAt, $endAt ;");//selecciono toda la lista de la tabla clothes
       $query->execute();                  //envio la consulta        
       $clothes = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
       
       return $clothes;  //reenvia el arreglo al controlador
   

   }

   public function getFilterTo($linkTo,$equalTo) {

        
    $query = $this->db->prepare("SELECT * FROM clothes WHERE $linkTo = ? ;");//selecciono toda la lista de la tabla clothes

   $query->execute([$equalTo]);                  //envio la consulta        
   $clothes = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
   
   return $clothes;  //reenvia el arreglo al controlador


}



    public function get($id) {
        $query = $this->db->prepare("SELECT * FROM clothes WHERE id = ?");
        $query->execute([$id]);
        $cloth = $query->fetch(PDO::FETCH_OBJ);
        
        return $cloth;
    }



    //borra los item segun el id enviado por el boton
    function delete($id) {
        $query = $this->db->prepare('DELETE FROM clothes WHERE id = ?');
        $query->execute([$id]);
        
    }

 /**  Inserta una producto en la base de datos.*/
     
 public function insert($id_clothes, $description, $size, $colour, $price, $image, $offers) {
    $query = $this->db->prepare("INSERT INTO clothes (id_clothes,description, size, colour, price,image,offers) VALUES (?, ?, ?, ?,?,?,?)");
    $query->execute([$id_clothes,$description, $size, $colour, $price, $image, $offers]);

    return $this->db->lastInsertId();

   
}

public function getColumns() {

        
    $query = $this->db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = business and TABLE_NAME = clothes order by ORDINAL_POSITION");//selecciono toda la lista de la tabla clothes
   $query->execute();                  //envio la consulta        
   $columns = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo de objetos
   
   return $columns;  //reenvia el arreglo al controlador


}


   }


//SELECT * FROM `clothes` ORDER BY `price` DESC;
//in array
//php.net

//SELECT * FROM clothes JOIN brand ON clothes.id_clothes = brand.id_brand WHERE id_clothes= 3;