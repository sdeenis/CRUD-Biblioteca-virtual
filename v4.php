
    <?php
    //titulos de tablas
    //inserccion de libros - ejemplares etc
    //tabla de prestamos, añadir nombre de usuario y libro
    include 'models/libro.php';
    include 'models/persona.php';
    include 'models/user.php';
    include 'view.php';
    include 'models/books.inc.php';

    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
    } else {
        $action = "libroAll";
    }



    // print_r($_REQUEST);
    // echo "<br>";
    // print_r($action);
    // echo "<br>";
    // // print_r($_SESSION);
    // echo "<br>";



    $biblio = new Biblioteca();
    $biblio->$action();


    class Biblioteca
    {
        private $db = null;
        private $libro, $persona, $user;



        public function __construct()
        {
            $this->libro = new Libro();
            $this->persona = new Persona();
            $this->user = new User();
        }



        public function logOut()
        {
            session_start();

            // foreach($_SESSION['cart'] as $k=>$v) {
            //     if ($v === 0) {
            //         $data['liberar'][$k] = 0;
            //     }
            // } 

            //la profe tiene:
            //$data['cart'] = $_SESSION['cart'];
            // $this->libro->liberar($data['cart']);

            $this->libro->liberar();

            session_destroy();
            // unset($_SESSION);
            header("location:" . $_SERVER['PHP_SELF']);

            // $this->libroAll();
        }

        public function loginForm()
        {
            // include "views/nav.php";
            View::render('login');
            // include "views/footer.php";
        }

        public function userValidate()
        {
            //recoger los datos del form y comprobar si existe user, pwd y con qué rol
            $data['login'] = $_REQUEST;
            $iduser = $this->user->validate($data['login']);

            // $this->user->validate($data['login']);
            if ($iduser != 0) {
                

                //pedir el rol del usuario
                //mostrar la vista principal de ese rol
                //cargar en la sesion id, rol y preferencias

                $roles = $this->user->getRoles($iduser);
      
                session_start();
                $_SESSION['iduser'] = $iduser;
                $_SESSION['cart'] = [];
                $_SESSION['prestados'] = 0;
                // $_SESSION['books'] = $this->libro->getPrestamos($iduser);
                $prestamos = ($this->libro->getPrestamos($iduser));
                if (!empty($prestamos)) {
                    foreach ($prestamos as $p) {
                        $_SESSION['cart'][$p] = 1; //Prestdo. 0, reservado.
                        $_SESSION['prestados']++;
                        // echo "contador prestaos: " . $_SESSION['prestados'] . "<br>";
                        //Por otro lado, cabe recalcar que no se puede prestar el mismo libro
                        //a la vez.
                        // [cart] => Array ( [2] => 1 [20] => 1 )
                        //No hay 2 claves iguales.
                    }
                }

                if(count($_SESSION['cart']) == MAXCART) {
                    $data['maxcart'] = MSSGS['maxbooks'];
                }


                if (isset($roles['adm'])) {
                    $_SESSION['adm'] = $iduser;
                    // View::render('admin');
                    $this->adminAll();
                } else {
                    $this->libroAll();
                }
            } else {
                include "views/header.php";
        include "views/nav.php";
        include("views/login.php");
        echo "<p class='errorLogin'>Datos incorrectos. Inténtelo de nuevo</p>";
        include "views/footer.php";
                
                //se podria meter una vista de error, de forma que se llame con:
                //View::render('error', $data); --> "No hay datos con ese correo", o "La contraseña no es correcta", o lo que sea
            }
        }




        public function prestamoAll()
        {
            $data['prestamo_all'] = $this->libro->getPrestamos();
    
            View::render('prestamo/all', $data);
            
        }

        public function userAll()
        {
            $data['user_all'] = $this->user->getAll();
   
            View::render('user/all', $data);
        }

        public function adminAll()
        {

            if (!isset($_SESSION)) session_start();
            View::render('admin');
        }



        public function libroCart()
        {
            if (!isset($_SESSION)) session_start();

            $data['libro_cart'] = $this->libro->getCart($_SESSION['cart']);
            // print_r($data['libro_cart']);
            $data['prestados'] = $_SESSION['prestados'];

            if (empty($data['libro_cart'])) View::render('message', MSSGS['empty']);
            // if (empty($data['libro_cart'])) echo "No hay libros en el carrito";
            else View::render('libro/cart', $data);
        }

        public function libroDevolver()
        {
            if (!isset($_SESSION)) session_start();
            $this->libro->devolver($_REQUEST['idLibro'], $_SESSION['iduser']);
            unset($_SESSION['cart'][$_REQUEST['idLibro']]);
            $_SESSION['prestados']--;
            $this->libroCart();
        }

        public function libroRenovar()
        {
            if (!isset($_SESSION)) session_start();
            $this->libro->renovar($_REQUEST['idLibro'], $_SESSION['iduser']);
            $this->libroCart();
        }

        public function libroAll()
        {
            // include "views/nav.php";
            $data['libro_all'] = $this->libro->getAll();
            
            if (isset($_SESSION)) {
                $books = count($_SESSION['cart']);
                echo "Reservas: " . $books . "<br>";
                if($books >= MAXCART) {
                    // echo "No se pueden reservar más libros";
                $data['maxcart'] = MSSGS['maxcart'];
                }
            }

            if (empty($data['libro_all'])) View::render('message', MSSGS['empty']);
            else View::render('libro/all', $data);
            // include "views/footer.php";
        }

        public function libroPrestar()
        {
            if (!isset($_SESSION)) session_start();

            

            $this->libro->prestar($_SESSION['iduser'], $_REQUEST['idLibro']);
            $_SESSION['prestados']++;
            $this->libroCart();
        }

        public function libroReservar()
        {
            if (!isset($_SESSION)) session_start();
            $this->libro->reservar($_REQUEST['idLibro']);

            $_SESSION['cart'][$_REQUEST['idLibro']] = 0; //1=prestado, 0=reservado 
            $this->libroAll();
        }

        public function libroCancelar()
        {
            if (!isset($_SESSION)) session_start();
            $this->libro->cancelar($_REQUEST['idLibro']);

            unset($_SESSION['cart'][$_REQUEST['idLibro']]);
            $this->libroCart();
        }

        public function libroForm()
        {
            if (isset($_REQUEST['idLibro'])) {
                $data['libroID'] = $_REQUEST['idLibro'];
            }
            $data['persona_all'] = $this->persona->getAll();
            View::render('libro/save', $data);
        }

        public function userForm() {
            View::render('user/save');
        }

        public function libroSave()
        {

            $libro = $_REQUEST;
            unset($libro['action']);
            print_r($libro);
            $this->libro->save($libro);
            $this->libroAll();
        }

        public function userSave() {
            $user = $_REQUEST;
            unset($user['action']);
            $this->user->save($user);
            $this->userAll();
        }

        public function libroModificar()
        {
            $libro = $_REQUEST;
            unset($libro['action']);
            $this->libro->update($libro);
            $this->libroAll();
        }

        

        public function personaForm()
        {
            View::render('persona/save'); // 
        }

        public function personaSave()
        {
            $persona = $_REQUEST;
            unset($persona['action']);
            $this->persona->save($persona);
            unset($persona['nombre']);
            unset($persona['apellido']);
            unset($persona['pais']);
            $this->libroForm();
        }

        public function libroGet()
        {
            // $data['libro_all'] = $this->libro->get($_REQUEST['textoBusqueda']);
            // if ($data['libro_all'] == -1) {
            //     include "views/header.php";
            //     include "views/nav.php";
            //     echo "No se han encontrado resultados";
            //     include "views/footer.php";
            // } else {
            //     View::render('libro/all', $data);
            // }
            // echo "<p><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>Resetear búsqueda</a></p>";


            $data['libro_all'] = $this->libro->get($_REQUEST['textoBusqueda']);

            if (empty($data['libro_all'])) View::render('message', ["mensaje" => MSSGS['empty']]);
            else View::render('libro/all', $data);

            echo "<p><a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "'>Resetear búsqueda</a></p>";
        }

        public function libroDelete()
        {
            $this->libro->delete($_REQUEST['idLibro']);
            $this->libroAll();
        }

        public function userDelete() {
            $this->user->delete($_REQUEST['idUser']);
            $this->userAll();
        }

        public function formularioModificarLibro()
        {
            echo "<h1>Modificación de libros</h1>";

            // Recuperamos el id del libro que vamos a modificar y sacamos el resto de sus datos de la BD
            $idLibro = $_REQUEST["idLibro"];
            $result = $this->db->query("SELECT * FROM libros WHERE libros.idLibro = '$idLibro'");
            $libro = $result->fetch_object();

            // Creamos el formulario con los campos del libro
            // y lo rellenamos con los datos que hemos recuperado de la BD
            echo "<form action = '" . $_SERVER['PHP_SELF'] . "' method = 'get'>
				    <input type='hidden' name='idLibro' value='$idLibro'>
                    Título:<input type='text' name='titulo' value='$libro->titulo'><br>
                    Género:<input type='text' name='genero' value='$libro->genero'><br>
                    País:<input type='text' name='pais' value='$libro->pais'><br>
                    Año:<input type='text' name='ano' value='$libro->ano'><br>
                    Número de páginas:<input type='text' name='numPaginas' value='$libro->numPaginas'><br>";

            // Vamos a añadir un selector para el id del autor o autores.
            // Para que salgan preseleccionados los autores del libro que estamos modificando, vamos a buscar
            // también a esos autores.
            $todosLosAutores = $this->db->query("SELECT * FROM personas");  // Obtener todos los autores
            $autoresLibro = $this->db->query("SELECT idPersona FROM escriben WHERE idLibro = '$idLibro'");             // Obtener solo los autores del libro que estamos buscando
            // Vamos a convertir esa lista de autores del libro en un array de ids de personas
            $listaAutoresLibro = array();
            while ($autor = $autoresLibro->fetch_object()) {
                $listaAutoresLibro[] = $autor->idPersona;
            }

            // Ya tenemos todos los datos para añadir el selector de autores al formulario
            echo "Autores: <select name='autor[]' multiple size='3'>";
            while ($fila = $todosLosAutores->fetch_object()) {
                if (in_array($fila->idPersona, $listaAutoresLibro))
                    echo "<option value='$fila->idPersona' selected>$fila->nombre $fila->apellido</option>";
                else
                    echo "<option value='$fila->idPersona'>$fila->nombre $fila->apellido</option>";
            }
            echo "</select>";

            // Por último, un enlace para crear un nuevo autor
            echo "<a href='" . $_SERVER['PHP_SELF'] . "?action=formularioInsertarAutores'>Añadir nuevo</a><br>";

            // Finalizamos el formulario
            echo "  <input type='hidden' name='action' value='modificarLibro'>
                    <input type='submit'>
                  </form>";
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "'>Volver</a></p>";
        }

        public function modificarLibro()
        {
            echo "<h1>Modificación de libros</h1>";

            // Vamos a procesar el formulario de modificación de libros
            // Primero, recuperamos todos los datos del formulario
            $idLibro = $_REQUEST["idLibro"];
            $titulo = $_REQUEST["titulo"];
            $genero = $_REQUEST["genero"];
            $pais = $_REQUEST["pais"];
            $ano = $_REQUEST["ano"];
            $numPaginas = $_REQUEST["numPaginas"];
            $autores = $_REQUEST["autor"];

            // Lanzamos el UPDATE contra la base de datos.
            $this->db->query("UPDATE libros SET
							titulo = '$titulo',
							genero = '$genero',
							pais = '$pais',
							ano = '$ano',
							numPaginas = '$numPaginas'
							WHERE idLibro = '$idLibro'");

            if ($this->db->affected_rows == 1) {
                // Si la modificación del libro ha funcionado, continuamos actualizando la tabla "escriben".
                // Primero borraremos todos los registros del libro actual y luego los insertaremos de nuevo
                $this->db->query("DELETE FROM escriben WHERE idLibro = '$idLibro'");
                // Ya podemos insertar todos los autores junto con el libro en "escriben"
                foreach ($autores as $idAutor) {
                    $this->db->query("INSERT INTO escriben(idLibro, idPersona) VALUES('$idLibro', '$idAutor')");
                }
                echo "Libro actualizado con éxito";
            } else {
                // Si la modificación del libro ha fallado, mostramos mensaje de error
                echo "Ha ocurrido un error al modificar el libro. Por favor, inténtelo más tarde.";
            }
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "'>Volver</a></p>";
        }

        public function buscarLibros()
        {
            // Recuperamos el texto de búsqueda de la variable de formulario
            $textoBusqueda = $_REQUEST["textoBusqueda"];
            echo "<h1>Resultados de la búsqueda: \"$textoBusqueda\"</h1>";

            // Buscamos los libros de la biblioteca que coincidan con el texto de búsqueda
            if ($result = $this->db->query("SELECT * FROM libros
					INNER JOIN escriben ON libros.idLibro = escriben.idLibro
					INNER JOIN personas ON escriben.idPersona = personas.idPersona
					WHERE libros.titulo LIKE '%$textoBusqueda%'
					OR libros.genero LIKE '%$textoBusqueda%'
					OR personas.nombre LIKE '%$textoBusqueda%'
					OR personas.apellido LIKE '%$textoBusqueda%'
					ORDER BY libros.titulo")) {

                // La consulta se ha ejecutado con éxito. Vamos a ver si contiene registros
                if ($result->num_rows != 0) {
                    // La consulta ha devuelto registros: vamos a mostrarlos
                    // Primero, el formulario de búsqueda
                    echo "<form action='" . $_SERVER['PHP_SELF'] . "'>
								<input type='hidden' name='action' value='buscarLibros'>
                            	<input type='text' name='textoBusqueda'>
								<input type='submit' value='Buscar'>
                          </form><br>";
                    // Después, la tabla con los datos
                    echo "<table border ='1'>";
                    while ($fila = $result->fetch_object()) {
                        echo "<tr>";
                        echo "<td>" . $fila->titulo . "</td>";
                        echo "<td>" . $fila->genero . "</td>";
                        echo "<td>" . $fila->numPaginas . "</td>";
                        echo "<td>" . $fila->nombre . "</td>";
                        echo "<td>" . $fila->apellido . "</td>";
                        echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=formularioModificarLibro&idLibro=" . $fila->idLibro . "'>Modificar</a></td>";
                        echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=borrarLibro&idLibro=" . $fila->idLibro . "'>Borrar</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    // La consulta no contiene registros
                    echo "No se encontraron datos";
                }
            } else {
                // La consulta ha fallado
                echo "Error al tratar de recuperar los datos de la base de datos. Por favor, inténtelo más tarde";
            }
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "?action=formularioInsertarLibros'>Nuevo</a></p>";
            echo "<p><a href='" . $_SERVER['PHP_SELF'] . "'>Volver</a></p>";
        }
    } // class
    ?>

