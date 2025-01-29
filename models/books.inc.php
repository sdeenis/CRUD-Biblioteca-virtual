<?php

DEFINE("MSSGS", [
    'borrowed' => 'Prestado',
    'empty' => '<h2>No hay libros en la base de datos</h2>',
    'maxcart' => 'Carrito lleno, accede a <a href= %s?action=libroCart>tu carrito</a> para gestionar tus libros',
    'maxbooks' => 'El límite de libros prestados es de %d y el de libros en el carrito es de %d',
    'maxbooktd' => 'Maximo de libros prestados',
    'new' => 'Nuevo libro',
    'reserve' => 'Reservar',
    'reserved' => 'Reservado',
    'unavailable' => 'No hay libros disponibles',
]);
DEFINE("MAXBOOKS", 3);  //maximo de libros prestados
DEFINE("MAXCART", 6); //maximo de libros entre prestados y reservados
