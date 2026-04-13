<?php
class VendedorController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
            header("Location: index.php?controlador=usuario&accion=login");
            exit();
        }
    }

    public function dashboard() {
        $stmt = $this->pdo->prepare("SELECT * FROM empresas WHERE usuario_id = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $empresa = $stmt->fetch();

        $stmt_oferta = $this->pdo->prepare("SELECT * FROM ofertas WHERE empresa_id = ?");
        $stmt_oferta->execute([$empresa['id']]);
        $ofertas = $stmt_oferta->fetchAll();

        // Obtener requerimientos de compradores de ruedas abiertas
        $stmt_reqs = $this->pdo->query("
            SELECT d.*, e.nombre_empresa, rn.titulo as rueda_titulo 
            FROM demandas d 
            JOIN empresas e ON d.empresa_id = e.id 
            JOIN ruedas_negocios rn ON rn.estado = 'abierta'
        ");
        $oportunidades = $stmt_reqs->fetchAll();

        // Obtener mis citas (solicitadas por mí)
        $stmt_mis_citas = $this->pdo->prepare("
            SELECT r.*, e.nombre_empresa as nombre_comprador, rn.titulo as rueda_titulo
            FROM reuniones r
            JOIN empresas e ON r.comprador_id = e.id
            JOIN ruedas_negocios rn ON r.rueda_id = rn.id
            WHERE r.vendedor_id = ?
            ORDER BY r.fecha_hora DESC
        ");
        $stmt_mis_citas->execute([$empresa['id']]);
        $mis_citas = $stmt_mis_citas->fetchAll();

        $stmt_ruedas = $this->pdo->query("SELECT * FROM ruedas_negocios WHERE estado = 'abierta'");
        $ruedas = $stmt_ruedas->fetchAll();

        require_once '../app/views/vendedor/vendedor_dashboard.php';
    }

    public function registrarResultado() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cita_id = $_POST['cita_id'];
            $monto = $_POST['monto_negocio'];
            $notas = $_POST['notas_resultado'];

            $stmt = $this->pdo->prepare("UPDATE reuniones SET monto_negocio = ?, notas_resultado = ?, estado = 'realizada' WHERE id = ?");
            $stmt->execute([$monto, $notas, $cita_id]);

            header("Location: index.php?controlador=vendedor&accion=dashboard&msg=resultado_registrado");
            exit();
        }
    }

    public function registrarOferta() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $empresa_id = $_POST['empresa_id'];
            $producto_servicio = $_POST['producto_servicio'];
            $descripcion = $_POST['descripcion'];

            $stmt = $this->pdo->prepare("INSERT INTO ofertas (empresa_id, producto_servicio, descripcion) VALUES (?, ?, ?)");
            $stmt->execute([$empresa_id, $producto_servicio, $descripcion]);

            header("Location: index.php?controlador=vendedor&accion=dashboard");
            exit();
        }
    }

    public function solicitarCita() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rueda_id = $_POST['rueda_id'];
            $comprador_id = $_POST['comprador_id'];
            $vendedor_id = $_POST['vendedor_id'];
            $fecha_hora = $_POST['fecha_hora'];

            $stmt = $this->pdo->prepare("INSERT INTO reuniones (rueda_id, comprador_id, vendedor_id, fecha_hora, estado) VALUES (?, ?, ?, ?, 'pendiente')");
            $stmt->execute([$rueda_id, $comprador_id, $vendedor_id, $fecha_hora]);

            header("Location: index.php?controlador=vendedor&accion=dashboard&msg=solicitud_enviada");
            exit();
        }
    }
}
?>
