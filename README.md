# API REST para el recurso de clothes
Una API REST sencilla para manejar un CRUD de clothes


## Pueba con postman
El endpoint de la API es: http://localhost/Proyectoxamp/api-rest-TP2/api/clothes

## Importación de  la base de datos
- importar base de datos: database/business.sql

Configuracion de tablas con las que se opera:

Base de datos: 
dbname=business

-tabla "clothes":

columnas:
*id
*id_clothes (foreing key)
*description
*size
*colour
*price
*image
*offers
![image](https://user-images.githubusercontent.com/112092368/201440576-409da508-8b67-408f-b092-f3c34d7a5238.png)


Tabla "brand"
columnas:
*id_brand
*brand
![image](https://user-images.githubusercontent.com/112092368/201440634-085b6678-ab2c-4aa9-b193-ce2e8b3570e9.png)


Acceso a los endPoints:

1.- Mostrar los todos los datos de la tabla "clothes":

endPoint: Metodo GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes



![image](https://user-images.githubusercontent.com/112092368/201440783-b244b545-3fbe-4778-a828-1d903c767a9c.png)


2.- Mostrar los productos ordenados de forma asc o desc , segun una columna de la tabla "clothes":
 endPoint: metodo GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes?sort=price&order=asc

Se debe colocar en la variable "sort"= la columna elegida para ordenar(puede ser cualquier columna).
En la variable  "order" = se debe colocar "asc" o "desc".
![image](https://user-images.githubusercontent.com/112092368/201441245-a3068dca-0d01-4fe8-a929-9fea160f6a89.png)

En caso de escribir mal el nombre de la columna o la palabra asc o desc el sistema arrojara error 400, especificando que coloque bien las palabras.



3.- Mostrar los productos especificados por su id:
endPoint: metodo GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes/7

Se debe colocar / y el numero del id a buscar.

![image](https://user-images.githubusercontent.com/112092368/201441640-ef4864c5-9bd9-450d-8196-6c5e739b8b8e.png)

En caso de colocar un id inexistente la api arrojara error 404, con el mensaje de "id inexistente".

4.- Insertar datos en la base de datos:
endPoint:metodo POST- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes

![image](https://user-images.githubusercontent.com/112092368/201441854-c8095429-8abd-4e76-9d18-e70b9f4befbc.png)

Colocar en formato json  todos los atributos a modificar. No dejar ningun capo vacio o el sistema arrojará la advertencia de "completar los datos".

5.- Paginacion de la busqueda de datos:

endPoint: metodo: GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes?select=*&starAt=1&endAt=6
Se debe colocar el nombre de la columna a buscar en la variable "select" . En caso de requerir todas las columnas se debe colocar *.
En la variable "starAt" se coloca el nuemro de filas desde la cual buscar.
En la variable "endAt" colocar el numero de filas hasta el cual se desea buscar.
![image](https://user-images.githubusercontent.com/112092368/201442546-4de43d86-6645-4a55-8313-eb9870574977.png)

En caso de colocar un nombre de columna inexistente  o que se pida iniciar la búsqueda en un numero inexistente, el sistema avisará del error. En caso de colocar un numero de término mas alto que el total de filas, el sistema traerá todas las que encuentre.

6.- Filtro de búsqueda por campo específico:
endPoint: metodo GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes?column=colour&search=verde

Se debe colocar en la variable "column" el nombre de la columna por la cual buscar.
En la variable "search" se colocará el dato especifico a buscar. Debe ser el dato exacto, bien escrito o el sistema arrojará error.
![image](https://user-images.githubusercontent.com/112092368/201443058-86e6050e-5652-4de5-a2f8-59e442de3532.png)

También es posible buscar en la tabla relacionada por nombre de la marca con la columna "brand".

![image](https://user-images.githubusercontent.com/112092368/201443273-063755f3-556f-4a7d-9547-484600729467.png)

En caso de escribir mal el atributo o nombre de la columna el sistema arrojará error.

7.- Eliminar un elemento por su id:

endPoint: metodo DELETE- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes/12

Se debe colocar el id de la fila a eliminar.
![image](https://user-images.githubusercontent.com/112092368/201443544-6b66a70e-766b-434e-986e-7d2d5d15b2ad.png)

En caso de colocar un id incorrecto el sistema avisará que ese id no existe.

8.- Busqueda por 3 columnas.
endPOint. Metodo :GET- http://localhost/Proyectoxamp/api-rest-TP2/api/clothes?col1=description&col2=price&col3=offers

Se deben colocar los nombres de 3 columnas por las cuales filtrar los datos.
En caso de nombres invalidos de las columnas el sistema expresara el error.



![image](https://user-images.githubusercontent.com/112092368/201446818-15efb279-9957-49df-953e-d146234ebecf.png)



Nota:
Se agregó una columna "offers" a la tabla "clothes", a la cual se puede acceder mediante el metodo get y el endpoint N° 8, colocando en el nombre de una columna : offers.














