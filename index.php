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
    // El anterior bloque 
    // 1. nos hacen un envio a travez de post 
    // 2. recepcionamos los datos en las variables $nombres y $apellidos
    // 3. insertamos la informacion en la DB
    // 4. se muestra un mensaje de alumno agregado
});

//Borrar registro
Flight::route('DELETE /alumnos', function () {
    $id=(Flight::request()->data->id); 

    $sql = "DELETE FROM alumnos WHERE id=?";
    $sentence = Flight::db()->prepare($sql);
    $sentence -> bindParam(1, $id);
    $sentence->execute();

    Flight::jsonp(["Alumno eliminado"]);
});

// Actualizar registros  
Flight::route('PUT /alumnos', function () {
    $id=(Flight::request()->data->id); 
    $nombres=(Flight::request()->data->nombres);  
    $apellidos=(Flight::request()->data->apellidos);

    // Identificar la instruccion sql 
    $sql = "UPDATE alumnos SET nombres=?, apellidos=? WHERE id=?";
    // Se cambiaran los nombres y los apelledos por los nuevos cuando el id sea igual al id 
    $sentence = Flight::db()->prepare($sql); //preparar la instruccion

    // El numero representa el numero respecto al ? que ocupa
    $sentence -> bindParam(1, $nombres);//pasando nuevos parametros 
    $sentence -> bindParam(2, $apellidos);//pasando nuevos parametros 
    $sentence -> bindParam(3, $id); //pasando nuevos parametros 

    $sentence->execute();
    Flight::jsonp(["Alumno modificado"]);
});


Flight::start();

// Create a new task            POST            PATH   /tasks
// Delete an exiting task       DELETE          PATH   /tasks/{id}
// Get a specific task          GET             PATH   /tasks/{id}
// Search for tasks             GET             PATH   /tasks
// Update an existing task      PUT             PATH   /tasks/{id}