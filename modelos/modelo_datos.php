<?php
// Modelo Datos (Datos.php)

class Datos {
    private $conexion;

    public function __construct() {
        // Incluir el archivo de conexión
        include("../config/conexion.php");
        $this->conexion = $conexion;
    }

    // Método para crear un cliente
    public function crearCliente($nombre, $email, $telefono, $direccion, $contraseña) {
        // Encriptar la contraseña
        $contraseñaEncriptada = hash('sha512', $contraseña);

        // Fecha actual
        $fecha = date("Y-m-d");

        // Consulta SQL
        $sql = "INSERT INTO datos (nombre, email, telefono, direccion, contraseña, fecha) 
                VALUES ('$nombre', '$email', '$telefono', '$direccion', '$contraseñaEncriptada', '$fecha')";

        return mysqli_query($this->conexion, $sql);
    }

    // Método para actualizar un cliente
    public function actualizarCliente($id, $nombre, $email, $telefono, $direccion) {
        $sql = "UPDATE datos 
                SET nombre = '$nombre', email = '$email', telefono = '$telefono', direccion = '$direccion' 
                WHERE id = $id";

        return mysqli_query($this->conexion, $sql);
    }

    // Método para eliminar un cliente
    public function eliminarCliente($id) {
        $sql = "DELETE FROM datos WHERE id = $id";

        return mysqli_query($this->conexion, $sql);
    }
}
?>

