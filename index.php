<?php

require 'flight/Flight.php'; //se carga el framework
// Por medio de la siguiente linea podemos ver si el htacces esta funcionando, en caso de que no funcione bien no funcionaran las rutas

Flight::register('db', 'PDO', array('mysql:host=localhost;dbname=api', 'root', ''));
// Se aclara que se utilizara una base de datos, un topo de conexion, despues donde esta ubicada, usuario y contraseña, en caso de no tener se deja en blanco
// Tipo de conexion PDO 
// con el array lo que se busca es conectarse a una base de datos 

Flight::route('GET /alumnos', function () { //solicitud 
    
    $sentence = FLight::db()->prepare('SELECT * FROM `alumnos`'); //selectionar todos los datos de alumnos
    $sentence->execute();
    $dates = $sentence->fetchAll();


    FLight::json($dates);

});

Flight::start();

// Create a new task            POST            PATH   /tasks
// Delete an exiting task       DELETE          PATH   /tasks/{id}
// Get a specific task          GET             PATH   /tasks/{id}
// Search for tasks             GET             PATH   /tasks
// Update an existing task      PUT             PATH   /tasks/{id}