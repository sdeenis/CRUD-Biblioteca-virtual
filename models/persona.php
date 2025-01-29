
<?php
/*
extraer todo lo de vista. Vamos a hacer un modelo por cada entidad y una vista por cada caso de uso
¿y cada vista en una clase diferente?
*/

require_once 'db.php';

class Persona
{
    private $db;

    function __construct()
    {
        $this->db = new DB();
    }


    public function getAll()
    {
        $q = "SELECT * FROM personas ORDER BY apellido";
        $items = $this->db->myQuery($q);
        return $items;
    }

    public function save($p)
    {
        $db = new mysqli("localhost", "root", "root", "books");

        $q = "INSERT INTO personas (nombre, apellido, pais) VALUES ('$p[nombre]', '$p[apellido]', '$p[pais]')";
        echo $q;
        $result = $db->query($q);

        // if ($result->num_rows != 0) $data['result'] = "Persona insertada con éxito";
        // else $data['result'] = "Ha ocurrido un error al insertar la persona. Por favor, inténtelo más tarde.";

        $db->close();
    }
}
?>