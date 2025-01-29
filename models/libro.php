<?php

//habilitar las excepciones en mysqli para usar try catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once "db.php";

class Libro
{
    private $db;

    function __construct()
    {
        $this->db = new DB();
    }

    public function getAllPrestamos() {
                    
        $q = "SELECT idprestan, iduser, idlibro, fechai from prestan";

        $items = $this->db->myQuery($q);
        return $items;
        
        
    }

    public function getPrestamos($iduser)
    {
        
        try {
            $db = new mysqli("localhost", "root", "root", "books");

            $q = "SELECT 
        prestan.idLibro as idLibro
        from prestan
        where iduser=?
        order by prestan.idLibro";
            $items = [];
            if ($result = $db->execute_query($q, [$iduser])) {
                if ($result->num_rows != 0) {
                    $items = [];
                    while ($fila = $result->fetch_object()) {
                        $items[] = $fila->idLibro;
                    }
                }
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error al buscar el libro: " . $e->getMessage();
            return [];  // En caso de error, se retorna un array vacío
        } finally {
            $db->close();  // Siempre se cierra la conexión
        }
        return $items;
    }

    public function getAll()
    {
        // $q = "SELECT libros.idLibro, libros.titulo, libros.genero, libros.numPaginas, libros.ano, libros.pais, personas.nombre, personas.apellido, libros.ejemplares
        // $q = "SELECT libros.idLibro, libros.titulo, libros.genero, libros.numPaginas, libros.ano, libros.pais, libros.ejemplares, libros.disponibles, concat(personas.apellido, ', ', personas.nombre) as autores
        //     FROM libros 
        //     LEFT JOIN escriben ON libros.idLibro = escriben.idLibro 
        //     LEFT JOIN personas ON escriben.idPersona = personas.idPersona 
        //     ORDER BY libros.idLibro";

        $q = "SELECT * from vlibros";

        $items = $this->db->myQuery($q);
        return $items;

        //se podria crear una vista en la base de datos con la consulta y llamar a la vista
        //$q = "SELECT * FROM vista_libros";
    }

    public function liberar()
    {
        //la profe lo tiene con el try catch etcetcetc

        //$q = "update libros set disponibles = disponibles + 1 where idLibro in(";
        //foreach($cart as $id=>$v) {
        //if ($v === 0) {
        //$ids[] = $id;
        //$q .= "?,";
        //}
        //}

        //$q = rtrim($q, ",");
        //$q .= ")";

        // $db->execute_query($q, $ids);

        $db = new mysqli("localhost", "root", "root", "books");
        $q = "UPDATE libros SET disponibles = disponibles + 1 WHERE idLibro = ?";

        foreach ($_SESSION['cart'] as $idLibro => $estado) {
            if ($estado === 0) {
                $db->execute_query($q, [$idLibro]);
            }
        }
    }

    public function reservar($idLibro)
    {
        try {
            $db = new mysqli("localhost", "root", "root", "books");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            $q = "UPDATE libros SET disponibles = disponibles - 1 WHERE idLibro =?";
            $db->execute_query($q, [$idLibro]);
        } catch (mysqli_sql_exception $e) {
            echo "Error al prestar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function cancelar($idLibro)
    {
        try {
            $db = new mysqli("localhost", "root", "root", "books");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            $q = "UPDATE libros set disponibles = disponibles + 1 where idLibro =?";
            $db->execute_query($q, [$idLibro]);
        } catch (mysqli_sql_exception $e) {
            echo "Error al cancelar la reserva del libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function renovar($idLibro, $iduser) {
        try {
            $db = new mysqli("localhost", "root", "root", "books");
            $q = "UPDATE prestan SET fechai = NOW() WHERE idLibro =? and iduser =?";

            //la profe tiene algo distinto, cambia la fecha fin en vez de fecha inicio, pero en esencia es lo mismo.
            //$q = "UPDATE prestan SET fechaf = DATE_ADD(fechaf, INTERVAL 15 day) where idLibro = ? and iduser = ?";

            $db->execute_query($q, [$idLibro, $iduser]);

        } catch (mysqli_sql_exception $e) {
            echo "Error al renovar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function devolver($idLibro, $iduser)
    {
        try {
            $db = new mysqli("localhost", "root", "root", "books");

            //obtener los datos del libro
            $q = "SELECT DISTINCT CONCAT_WS(';', titulo, autores, numPaginas, ano, pais) as datoslibro, CONCAT_WS(';', user, dni, nomcli, apecli, dircli, cpcli) as datosuser FROM vlibros, users WHERE idLibro =? and iduser =?";  
            $result = $db->execute_query($q, [$idLibro, $iduser]);
            $datos=[];
            while ($fila = $result->fetch_object()) {
                $datos = $fila;
            }

            print_r($datos);



            $db->autocommit(false);
            $db->commit();

            $q = "INSERT INTO prestanhist (iduser, datosuser, idlibro, datoslibro ) VALUES (?, ?, ?, ?)";
            $db->execute_query($q, [$iduser, $datos->datosuser, $idLibro, $datos->datoslibro]);

            $q = "UPDATE libros SET disponibles = disponibles + 1 WHERE idLibro =?";
            $db->execute_query($q, [$idLibro]);

            $q = "DELETE FROM prestan WHERE idLibro =? and iduser =?";
            $db->execute_query($q, [$idLibro, $iduser]);

            $db->commit();

            //unset($_SESSION['cart'][$idLibro]);//en el controlador mejor
        } catch (mysqli_sql_exception $e) {
            echo "Error al devolver el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function prestar($iduser, $idLibro)
    {
        // $q = "UPDATE libros SET disponibles = disponibles - 1 WHERE idLibro = " . $idLibro;
        // $resultado = $this->db->myUpdateQuery($q);


        // ----forma de la profe (sin crear la funcion myUpdateQuery en bd.php----

        try {
            $db = new mysqli("localhost", "root", "root", "books");

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            // $q = "UPDATE libros SET disponibles = disponibles - 1 WHERE idLibro =?";
            // $db->execute_query($q, [$idLibro]);

            $q = "INSERT INTO prestan (iduser, idlibro) VALUES (?, ?)";
            $db->execute_query($q, [$iduser, $idLibro]);

            $_SESSION['cart'][$idLibro] = 1;
            // $this->commit();

        } catch (mysqli_sql_exception $e) {
            echo "Error al prestar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function save($libro)
    {

        $autores = $libro['autor']; //es un array pq son varios
        unset($libro['autor']);

        try {
            $db = new mysqli("localhost", "root", "root", "books");
            // $db->autocommit(false);

            $db->commit();

            // $query = "INSERT INTO libros (titulo,genero,pais,ano,numPaginas) 
            // VALUES ('$titulo','$genero', '$pais', '$ano', '$numPaginas')";

            /*
            $query = "INSERT INTO libros (titulo,genero,pais,ano,numPaginas) 
            VALUES ("'
            .$libro['titulo']."','"
            .$libro['genero']."','"
            .$libro['pais']."','"
            .$libro['ano']."','"
            .$libro['numPaginas']."')";
            */

            //La profe ha cambiado los tipos de ano y numPaginas a varchar para poder insertar todo con comillas. 
            //Yo he probado y puedo insertar en int datos de String con comillas:
            //INSERT INTO libros (titulo,genero,pais,ano,numPaginas) VALUES ('libro4','genero4','pais4','año4','4444')
            // ^ funciona


            //Consulta preparada: plantilla sql
            $stmt = $db->prepare("INSERT INTO libros (titulo,genero,pais,ano,numPaginas,ejemplares,disponibles) VALUES (?,?,?,?,?,?,?)");


            $titulo = $libro['titulo'];
            $genero = $libro['genero'];
            $pais = $libro['pais'];
            $ano = $libro['ano'];
            $numPaginas = $libro['numPaginas'];
            $ejemplares = $libro['ejemplares'];
            $disponibles = $libro['disponibles'];
            

            //prepared statement: binding
            $stmt->bind_param('sssssss', $titulo, $genero, $pais, $ano, $numPaginas, $ejemplares, $disponibles);

            $stmt->execute();


            //otra forma:
            // $q = "INSERT INTO libros (titulo,genero,pais,ano,numPaginas) VALUES ('$titulo','$genero', '$pais', '$ano', '$numPaginas')";
            // $valores = array_values($libro);
            // $db->execute_query($q, $valores);



            // $query = "INSERT INTO libros (";
            // foreach ($libro as $k => $v) {
            //     $query .= $k . ",";
            // }
            // $query = substr($query, 0, -1);
            // $query .= ") VALUES (";
            // foreach ($libro as $k => $v) {
            //     $query .= "'" . $v . "',";
            // }
            // $query = substr($query, 0, -1);
            // $query .= ")";

            // $db->query($query);    
            //->>>> la profe no tiene asi la consulta. La tiene como arriba.

            if ($db->affected_rows == 1) {
                // Si la inserción del libro ha funcionado, continuamos insertando en la tabla "escriben"
                // Tenemos que averiguar qué idLibro se ha asignado al libro que acabamos de insertar
                $result = $db->query("SELECT LAST_INSERT_ID() AS idLibro");
                $idLibro = $result->fetch_object()->idLibro;
                // Ya podemos insertar todos los autores junto con el libro en "escriben"
                foreach ($autores as $idAutor) {
                    $q = "INSERT INTO escriben(idLibro, idPersona) VALUES('$idLibro', '$idAutor')";

                    //con consulta preparada
                    // $q = "INSERT INTO escriben(idLibro, idPersona) VALUES(?, ?)";
                    // $params = array_values([$idLibro, $idAutor]);
                    // $db->execute_query($q, $params);

                    echo "<br>";
                    echo $q;
                    echo "<br>";
                    $db->query($q);

                    if ($db->affected_rows != 1) $db->rollback();
                }
            }

            $db->commit();

            echo "<br>";
            // echo $stmt;
            echo "<br>";
        } catch (mysqli_sql_exception $e) {
            echo "Error al insertar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function get($busqueda)
    {
        try {
            $db = new mysqli("localhost", "root", "root", "books");

            $textoBusqueda = $busqueda;
            echo "<h1>Resultados de la búsqueda: \"$textoBusqueda\"</h1>";

            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda. 
            // Me ha tocado actualizar la consulta para que también busque por autor (o algo así)
            // if ($result = $db->execute_query("
            // SELECT 
            //     libros.idLibro AS idLibro, 
            //     libros.titulo, 
            //     libros.genero, 
            //     libros.numPaginas,
            //     libros.ano AS año,
            //     libros.disponibles,
            //     libros.pais AS pais,
            //     GROUP_CONCAT(CONCAT(personas.apellido, ', ', personas.nombre) SEPARATOR '; ') AS autores
            // FROM libros
            // LEFT JOIN escriben ON libros.idLibro = escriben.idLibro
            // LEFT JOIN personas ON escriben.idPersona = personas.idPersona
            // WHERE libros.titulo LIKE ?
            // OR libros.genero LIKE ?
            // OR personas.nombre LIKE ?
            // OR personas.apellido LIKE ?
            // OR libros.pais LIKE ?
            // OR libros.ano LIKE ?
            // OR libros.numPaginas LIKE ?
            // GROUP BY libros.idLibro
            // ORDER BY libros.titulo", [$textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda])) {

            //la profe lo hace con la vista envez de con la consulta entera, select * from vlibros where titulo like ? or genero like ? or autores like ? or pais like ? or ano like ? or numPaginas like ?

            $libro = [];
            if ($result = $db->execute_query("
            SELECT 
                *
            FROM vlibros
            where titulo like ?
            or genero like ?
            OR autores LIKE CONCAT('%', ?, '%')
            or pais like ?
            or ano like ?
            or numPaginas like ?
            ORDER BY vlibros.titulo", [$textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda, $textoBusqueda])) {
                if ($result->num_rows != 0) {


                    $libro = [];

                    while ($fila = $result->fetch_object()) {
                        $libro[] = $fila;
                    }
                }
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error al buscar el libro: " . $e->getMessage();
            return [];  // En caso de error, se retorna un array vacío
        } finally {
            $db->close();  // Siempre se cierra la conexión
        }
        return $libro;  // Esta línea asegura que se devuelvan los libros encontrados
    }


    public function getCart($ids)
    {

        try {
            $db = new mysqli("localhost", "root", "root", "books");
            $q = "SELECT idLibro, titulo, genero, numPaginas, ano, pais, autores from vlibros where idLibro in (";

            if (count($ids) == 0) {
                return [];
            }
            foreach ($ids as $id => $v) {
                $q .= "?,";
            }
            $q = rtrim($q, ",");
            $q .= ")";

            $result = $db->execute_query($q, array_keys($ids));
            $items = [];

            while ($fila = $result->fetch_object()) {
                $items[] = $fila;
            }

            // print_r($items);
            return $items;
        } catch (mysqli_sql_exception $e) {
            echo "Error al buscar el libro: " . $e->getMessage();
            return [];  // En caso de error, se retorna un array vacío
        } finally {
            $db->close();  // Siempre se cierra la conexión
        }

        // $q = "SELECT * from vlibros where idLibro in (";

        // foreach ($ids as $id) {
        //     $q .= $id . ",";
        // }

        // $q = rtrim($q, ",");

        // $q .= ")";
        // $items = $this->db->myQuery($q);
        // return $items;

        //se podria crear una vista en la base de datos con la consulta y llamar a la vista
        //$q = "SELECT * FROM vista_libros";
    }

    public function delete($idLibro)
    {
        try {
            $db = new mysqli("localhost", "root", "root", "books");
            $db->query("DELETE FROM libros WHERE idLibro = '$idLibro'");

            //consulta preparada:
            // $q = "DELETE FROM libros WHERE idLibro = ?";
            // $db->execute_query($q, [$idLibro]);

        } catch (mysqli_sql_exception $e) {
            echo "Error al borrar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }

    public function update($libro)
    {


        try {
            $db = new mysqli("localhost", "root", "root", "books");

            //verificar la conexion

            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            } //es redundante, se ha dejado de ejemplo

            $db->autocommit(false); //mysqli_autocommit($db, FALSE);
            $db->commit();


            // Obtener el ID del libro.
            //La profe lo consigue con un hidden en el formulario de save.php (?)
            $idLibro = $libro['idLibro'];

            // Extraer los autores del array (si existen)
            $autores = $libro['autor'];
            unset($libro['autor']);

            // Construir la consulta de actualización para la tabla `libros`
            // $query = "UPDATE libros SET ";
            // foreach ($libro as $campo => $valor) {
            //     $query .= "$campo = '$valor',";
            // }
            // $query = rtrim($query, ','); // Eliminar la última coma
            // $query .= " WHERE idLibro = '$idLibro'";

            //Consulta preparada: plantilla sql
            $q = ("UPDATE libros SET titulo = ?, genero = ?, pais = ?, ano = ?, numPaginas = ?, ejemplares = ?, disponibles = ? WHERE idLibro = ?");


            $db->execute_query($q, [$libro['titulo'], $libro['genero'], $libro['pais'], $libro['ano'], $libro['numPaginas'], $libro['ejemplares'], $libro['disponibles'], $idLibro]);



            // Ejecutar la consulta de actualización
            //$db->autocommit(false); // Iniciar transacción
            // if (!$db->query($query)) {
            //     $db->rollback();
            //     die("Error al actualizar el libro: " . $db->error);
            // }

            echo "<br>";
            // print_r($query);
            echo "<br>";

            // Actualizar los autores en la tabla `escriben`
            // Primero, eliminar las relaciones existentes
            $deleteQuery = "DELETE FROM escriben WHERE idLibro = '$idLibro'";
            if (!$db->query($deleteQuery)) {
                $db->rollback();
                die("Error al eliminar autores antiguos: " . $db->error);
            }

            echo "<br>";
            echo $deleteQuery;
            echo "<br>";

            // Insertar las nuevas relaciones autor-libro
            foreach ($autores as $idAutor) {
                $insertQuery = "INSERT INTO escriben (idLibro, idPersona) VALUES ('$idLibro', '$idAutor')";
                if (!$db->query($insertQuery)) {
                    $db->rollback(); //deshacer transacción
                    die("Error al insertar los nuevos autores: " . $db->error);
                }
                echo "<br>";
                print_r($insertQuery);
                echo "<br>";
            }

            $db->commit(); // Confirmar transacción si todo va bien
            // $db->close();
            echo "<br>";
            echo "Libro actualizado correctamente.";
            echo "<br>";
        } catch (mysqli_sql_exception $e) {
            echo "Error al actualizar el libro: " . $e->getMessage();
        } finally {
            $db->close();
        }
    }
}
