<?php
class CompradorController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar si el usuario está logueado y es comprador (rol_id = 2)
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
            header("Location: index.php?controlador=usuario&accion=login");
            exit();
        }
    }

    public function dashboard() {
        // Obtener datos de la empresa del comprador
        $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE usuario_id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $empresa = $stmt->fetch();

        // Obtener sus requerimientos actuales
        $stmt_req = $this->pdo->prepare("SELECT * FROM demandas WHERE empresa_id = ?");
        $stmt_req->execute([$empresa['id']]);
        $requerimientos = $stmt_req->fetchAll();

        // Obtener solicitudes de citas recibidas
        $stmt_citas = $this->pdo->prepare("
            SELECT r.*, e.nombre_empresa as nombre_vendedor, rn.titulo as rueda_titulo
            FROM reuniones r
            JOIN empresas e ON r.vendedor_id = e.id
            JOIN ruedas_negocios rn ON r.rueda_id = rn.id
            WHERE r.comprador_id = ?
            ORDER BY r.fecha_hora DESC
        ");
        $stmt_citas->execute([$empresa['id']]);
        $citas_recibidas = $stmt_citas->fetchAll();

        // Obtener ruedas de negocios activas
        $stmt_ruedas = $this->pdo->query("SELECT * FROM ruedas_negocios WHERE estado = 'abierta'");
        $ruedas = $stmt_ruedas->fetchAll();

        require_once '../app/views/comprador/comprador_dashboard.php';
    }

    public function gestionarCita() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cita_id = $_POST['cita_id'];
            $nuevo_estado = $_POST['estado']; // 'aceptada' o 'rechazada'

            $stmt = $this->pdo->prepare("UPDATE reuniones SET estado = ? WHERE id = ?");
            $stmt->execute([$nuevo_estado, $cita_id]);

            header("Location: index.php?controlador=comprador&accion=dashboard&msg=cita_actualizada");
            exit();
        }
    }

    public function registrarRequerimiento() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $empresa_id = $_POST['empresa_id'];
            $requerimiento = $_POST['requerimiento'];
            $descripcion = $_POST['descripcion'];

            $stmt = $this->pdo->prepare("INSERT INTO demandas (empresa_id, requerimiento, descripcion) VALUES (?, ?, ?)");
            $stmt->execute([$empresa_id, $requerimiento, $descripcion]);

            header("Location: index.php?controlador=comprador&accion=dashboard");
            exit();
        }
    }
}
?>
