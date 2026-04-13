<?php
class UsuarioModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function registrar($nombre_usuario, $correo, $password, $rol_id, $nombre_empresa) {
        try {
            $this->db->beginTransaction();

            $sql_user = "INSERT INTO usuarios (nombre_usuario, correo, password, rol_id) VALUES (?, ?, ?, ?)";
            $stmt_user = $this->db->prepare($sql_user);
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt_user->execute([$nombre_usuario, $correo, $hashed_password, $rol_id]);
            $usuario_id = $this->db->lastInsertId();

            $sql_empresa = "INSERT INTO empresas (usuario_id, nombre_empresa) VALUES (?, ?)";
            $stmt_empresa = $this->db->prepare($sql_empresa);
            $stmt_empresa->execute([$usuario_id, $nombre_empresa]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return $e->getMessage();
        }
    }

    public function login($correo, $password) {
        $sql = "SELECT u.*, r.nombre as rol_nombre FROM usuarios u JOIN roles r ON u.rol_id = r.id WHERE TRIM(u.correo) = TRIM(?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$correo]);
        $usuario = $stmt->fetch();

        if ($usuario) {
            if (password_verify($password, $usuario['password'])) {
                return $usuario;
            }
        }
        return false;
    }
}
?>
