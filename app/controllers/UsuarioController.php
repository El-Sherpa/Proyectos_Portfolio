<?php
require_once '../app/models/UsuarioModel.php';

class UsuarioController {
    private $pdo;
    private $usuarioModel;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->usuarioModel = new UsuarioModel($this->pdo);
    }

    public function registro() {
        $mensaje = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre_usuario = $_POST['nombre_usuario'];
            $correo = $_POST['correo'];
            $password = $_POST['password'];
            $rol_id = $_POST['rol_id'];
            $nombre_empresa = $_POST['nombre_empresa'];

            $registro = $this->usuarioModel->registrar($nombre_usuario, $correo, $password, $rol_id, $nombre_empresa);

            if ($registro === true) {
                $mensaje = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4'>Registro exitoso. Ya puedes <a href='index.php?controlador=usuario&accion=login' class='font-bold underline'>iniciar sesión</a>.</div>";
            } else {
                $mensaje = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4'>Error: " . $registro . "</div>";
            }
        }
        require_once '../app/views/usuario/user_registro.php';
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $mensaje = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $correo = trim($_POST['correo']);
            $password = $_POST['password'];

            $usuario = $this->usuarioModel->login($correo, $password);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['rol_id'] = $usuario['rol_id'];
                $_SESSION['rol_nombre'] = $usuario['rol_nombre'];

                // Redirigir según el rol
                switch ($usuario['rol_id']) {
                    case 1: header("Location: index.php?controlador=admin&accion=dashboard"); break;
                    case 2: header("Location: index.php?controlador=comprador&accion=dashboard"); break;
                    case 3: header("Location: index.php?controlador=vendedor&accion=dashboard"); break;
                    default: header("Location: index.php"); break;
                }
                exit();
            } else {
                // DEPURACIÓN TEMPORAL: Mostrar por qué falló
                $mensaje = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4'>";
                $mensaje .= "Error: Credenciales no válidas para $correo.";
                $mensaje .= "</div>";
            }
        }
        require_once '../app/views/usuario/user_login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php");
        exit();
    }
}
?>
