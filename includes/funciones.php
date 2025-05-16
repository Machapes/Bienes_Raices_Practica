<?php
    define('TEMPLATES_URL', __DIR__ . '/templates');
    define('FUNCIONES_URL', __DIR__ . 'funciones.php');
    define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');

    function incluirTemplate( string $nombre, bool $inicio = false ) {
        include TEMPLATES_URL . "/${nombre}.php"; 
    }

    function estaAutenticado() {
        session_start();
    
        if(!$_SESSION['login']) {
            header('Location: /');
        }
    }

    function debuguear($variable){
        echo "<pre>";
            var_dump($variable);
        echo "</pre>";
        exit;    
    }

    function sanitizar($html) : string {
        $sanitizar = htmlspecialchars($html);
        return $sanitizar;
    }

    function validadTipoContenido($tipo){
        $tipos = ['propiedad', 'vendedor'];
        return in_array($tipo, $tipos);
    }

    function mostrarNotificacion($codigo) {
        $mensaje = '';
    
        switch($codigo) {
            case 1:
                $mensaje = 'Creado Correctamente';
                break;
            case 2:
                $mensaje = 'Actualizado Correctamente';
                break;
            case 3:
                $mensaje = 'Eliminado Correctamente';
                break;
            default:
                $mensaje = false;
                break;
        }
    
        return $mensaje;
    }

    function validarORedireccionar(string $url) {
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        
        if(!$id) {
            header('Location: ${url}');
        }
    
        return $id;
    }

function verificarCredenciales($email, $password) {
    $db = conectarDB();
    
    $query = "SELECT * FROM usuarios WHERE email = '${email}'";
    $resultado = mysqli_query($db, $query);
    
    if($resultado->num_rows) {
        $usuario = mysqli_fetch_assoc($resultado);
        $auth = password_verify($password, $usuario['password']);
        
        if($auth) {
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['email'] = $usuario['email'];
            return true;
        }
    }
    
    return false;
}

function iniciarSesion() {
    session_start();
    $auth = $_SESSION['login'] ?? false;
    
    if(!$auth) {
        header('Location: /login');
        exit;
    }
}
  

    