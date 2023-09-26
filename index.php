<?php

require 'flight/Flight.php'; //se carga el framework
// Por medio de la siguiente linea podemos ver si el htacces esta funcionando, en caso de que no funcione bien no funcionaran las rutas

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api', 'root', ''));
// Se aclara que se utilizara una base de datos, un topo de conexion, despues donde esta ubicada, usuario y contraseña, en caso de no tener se deja en blanco
// Tipo de conexion PDO 
// con el array lo que se busca es conectarse a una base de datos 

//Lee los datos y muestra en un interface
Flight::route('GET /alumnos', function () { //solicitud de datos
    $sentence = Flight::db()->prepare('SELECT * FROM `alumnos`'); //selectionar todos los datos de alumnos
    $sentence->execute();
    $dates = $sentence->fetchAll();
    Flight::json($dates);
});

//recibe nuevos datos y recepciona 
Flight::route('POST /alumnos', function () {

    $nombres=(Flight::request()->data->nombres);  
    $apellidos=(Flight::request()->data->apellidos);  

    $sql = "INSERT INTO alumnos (nombres, apellidos) VALUES(?,?)";
    $sentence = Flight::db()->prepare($sql);
    //los siguientes son parametros que se insertan en el orden que estan en la parte de VALUES en la sentencia
    $sentence -> bindParam(1, $nombres);
    $sentence -> bindParam(2, $apellidos);
    $sentence->execute();

    Flight::jsonp(["Alumno agregado"]);
});
// El anterior bloque 
// 1. nos hacen un envio a travez de post 
// 2. recepcionamos los datos en las variables $nombres y $apellidos
// 3. insertamos la informacion en la DB
// 4. se muestra un mensaje de alumno agregado


Flight::start();

// Create a new task            POST            PATH   /tasks
// Delete an exiting task       DELETE          PATH   /tasks/{id}
// Get a specific task          GET             PATH   /tasks/{id}
// Search for tasks             GET             PATH   /tasks
// Update an existing task      PUT             PATH   /tasks/{id}