<?php
class AdminController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario está logueado y es administrador (rol_id = 1)
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
            header("Location: index.php?controlador=usuario&accion=login");
            exit();
        }
    }

    public function crearAdmin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $rol_id = 1; // Forzar a que sea Administrador

            try {
                $this->pdo->beginTransaction();
                
                $sql = "INSERT INTO usuarios (nombre_usuario, correo, password, rol_id) VALUES (?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$nombre, $correo, $password, $rol_id]);
                
                $usuario_id = $this->pdo->lastInsertId();
                $sql_empresa = "INSERT INTO empresas (usuario_id, nombre_empresa) VALUES (?, ?)";
                $stmt_empresa = $this->pdo->prepare($sql_empresa);
                $stmt_empresa->execute([$usuario_id, 'AGECSO Staff']);

                $this->pdo->commit();
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                // Manejar error (podría pasarse a la vista)
            }
        }
        header("Location: index.php?controlador=admin&accion=dashboard");
        exit();
    }

    public function dashboard() {
        // Obtener todas las ruedas de negocios
        $stmt_ruedas = $this->pdo->query("SELECT * FROM ruedas_negocios ORDER BY fecha_inicio DESC");
        $ruedas = $stmt_ruedas->fetchAll();

        // Obtener estadísticas rápidas
        $total_empresas = $this->pdo->query("SELECT COUNT(*) FROM empresas")->fetchColumn();
        
        // Obtener todas las reuniones con detalles de empresas
        $stmt_reuniones = $this->pdo->query("
            SELECT r.*, c.nombre_empresa as comprador, v.nombre_empresa as vendedor, rn.titulo as rueda
            FROM reuniones r
            JOIN empresas c ON r.comprador_id = c.id
            JOIN empresas v ON r.vendedor_id = v.id
            JOIN ruedas_negocios rn ON r.rueda_id = rn.id
            ORDER BY r.fecha_hora DESC
        ");
        $reuniones_detalladas = $stmt_reuniones->fetchAll();
        $total_reuniones = count($reuniones_detalladas);
        
        $negocios_cerrados = $this->pdo->query("SELECT SUM(monto_negocio) FROM reuniones WHERE estado = 'realizada'")->fetchColumn() ?: 0;

        require_once '../app/views/admin/admin_dashboard.php';
    }

    public function crearRueda() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $fecha_inicio = $_POST['fecha_inicio'];
            $fecha_fin = $_POST['fecha_fin'];
            $estado = $_POST['estado'];
            $usuario_id = $_SESSION['usuario_id'];

            $sql = "INSERT INTO ruedas_negocios (titulo, descripcion, fecha_inicio, fecha_fin, estado, creado_por) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titulo, $descripcion, $fecha_inicio, $fecha_fin, $estado, $usuario_id]);

            header("Location: index.php?controlador=admin&accion=dashboard");
            exit();
        }
    }

    public function cambiarEstadoRueda() {
        if (isset($_GET['id']) && isset($_GET['estado'])) {
            $id = $_GET['id'];
            $estado = $_GET['estado'];
            $stmt = $this->pdo->prepare("UPDATE ruedas_negocios SET estado = ? WHERE id = ?");
            $stmt->execute([$estado, $id]);
        }
        header("Location: index.php?controlador=admin&accion=dashboard");
        exit();
    }
}
?>
