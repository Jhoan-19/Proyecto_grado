<?php
// Modelo Cita (Cita.php)

class Cita {
    private $db;

    public function __construct() {
        // Incluye la conexión existente
        include("../config/conexion.php");
        $this->db = $conexion;
    }

    // Método para agendar una cita (crear)
    public function agendarCita($datos) {
        $sql = "INSERT INTO citas 
            (nombre, tipo_cliente, email, telefono, vehiculo, tipo_equipo, serial_equipo, servicio, descripcion, fecha, hora, archivo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssssssss",
                $datos['nombre'],
                $datos['tipo_cliente'],
                $datos['email'],
                $datos['telefono'],
                $datos['vehiculo'],
                $datos['tipo_equipo'],
                $datos['serial_equipo'],
                $datos['servicio'],
                $datos['descripcion'],
                $datos['fecha'],
                $datos['hora'],
                $datos['archivo']
            );
            if (mysqli_stmt_execute($stmt)) {
                return mysqli_insert_id($this->db);
            } else {
                return "Error al agendar la cita: " . mysqli_stmt_error($stmt);
            }
        } else {
            return "Error al preparar la consulta: " . mysqli_error($this->db);
        }
    }

    // Método para actualizar una cita
    public function actualizarCita($id, $datos, $archivoNuevo = false) {
        if ($archivoNuevo) {
            $sql = "UPDATE citas SET 
                nombre=?, tipo_cliente=?, email=?, telefono=?, vehiculo=?, tipo_equipo=?, serial_equipo=?, 
                servicio=?, descripcion=?, fecha=?, hora=?, archivo=?
                WHERE id=?";
            $stmt = mysqli_prepare($this->db, $sql);
            mysqli_stmt_bind_param($stmt, "ssssssssssssi",
                $datos['nombre'],
                $datos['tipo_cliente'],
                $datos['email'],
                $datos['telefono'],
                $datos['vehiculo'],
                $datos['tipo_equipo'],
                $datos['serial_equipo'],
                $datos['servicio'],
                $datos['descripcion'],
                $datos['fecha'],
                $datos['hora'],
                $datos['archivo'],
                $id
            );
        } else {
            $sql = "UPDATE citas SET 
                nombre=?, tipo_cliente=?, email=?, telefono=?, vehiculo=?, tipo_equipo=?, serial_equipo=?, 
                servicio=?, descripcion=?, fecha=?, hora=?
                WHERE id=?";
            $stmt = mysqli_prepare($this->db, $sql);
            mysqli_stmt_bind_param($stmt, "sssssssssssi",
                $datos['nombre'],
                $datos['tipo_cliente'],
                $datos['email'],
                $datos['telefono'],
                $datos['vehiculo'],
                $datos['tipo_equipo'],
                $datos['serial_equipo'],
                $datos['servicio'],
                $datos['descripcion'],
                $datos['fecha'],
                $datos['hora'],
                $id
            );
        }
        if ($stmt && mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return "Error al actualizar la cita: " . ($stmt ? mysqli_stmt_error($stmt) : mysqli_error($this->db));
        }
    }

    // Método para borrar una cita
    public function borrarCita($id) {
        $sql = "DELETE FROM citas WHERE id = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt)) {
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    return true;
                } else {
                    return "El ID proporcionado no existe en la base de datos.";
                }
            } else {
                return "Error al eliminar la cita: " . mysqli_stmt_error($stmt);
            }
        } else {
            return "Error al preparar la consulta: " . mysqli_error($this->db);
        }
    }

    // Verifica si una hora ya está ocupada en una fecha dada
    public function horaOcupada($fecha, $hora) {
        $sql = "SELECT COUNT(*) as total FROM citas WHERE fecha = ? AND hora = ?";
        $stmt = mysqli_prepare($this->db, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $fecha, $hora);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultado);
        return $row['total'] > 0; // true si ya está ocupada
    }
}
?>
