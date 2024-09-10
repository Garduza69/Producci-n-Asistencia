<?php

session_start();
require_once "conexion.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

$email_usuario = $_SESSION['email'];

// Consultar el idUsuario asociado al correo del usuario actual
$sql_usuario = "SELECT idUsuario FROM usuario WHERE Email = :email";
$stmt_usuario = $pdo->prepare($sql_usuario);
$stmt_usuario->bindParam(':email', $email_usuario, PDO::PARAM_STR);
$stmt_usuario->execute();
$row_usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
$id_usuario = $row_usuario['idUsuario'];

// Consultar el alumno_id asociado al idUsuario en la tabla alumnos
$sql_alumno = "SELECT alumno_id FROM alumnos WHERE id_usuario = :id_usuario";
$stmt_alumno = $pdo->prepare($sql_alumno);
$stmt_alumno->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
$stmt_alumno->execute();
$row_alumno = $stmt_alumno->fetch(PDO::FETCH_ASSOC);
$alumno_id = $row_alumno['alumno_id'];

// Consultar los grupo_id asociados al alumno_id en la tabla matricula
$sql_grupos = "SELECT grupo_id FROM matricula WHERE alumno_id = :alumno_id";
$stmt_grupos = $pdo->prepare($sql_grupos);
$stmt_grupos->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
$stmt_grupos->execute();

// Recuperar todos los grupo_id asociados
$grupos = $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);

// Si quieres guardar los IDs de los grupos en un array
$grupo_ids = array_column($grupos, 'grupo_id');

foreach ($grupo_ids as $grupo_id) {
    // Consultar si el grupo_id está vigente en la tabla grupos
    $sql_grupovig = "SELECT grupo_id FROM grupos WHERE grupo_id = :grupo_id AND vigenciaSem = 1 GROUP BY grupo_id";
    $stmt_grupovig = $pdo->prepare($sql_grupovig);
    $stmt_grupovig->bindParam(':grupo_id', $grupo_id, PDO::PARAM_INT);
    $stmt_grupovig->execute();
}

$options = '';
while ($row_grupovig = $stmt_grupovig->fetch(PDO::FETCH_ASSOC)) {
    $grupo_id1 = $row_grupovig['grupo_id'];

    $sql_materias = "SELECT a.materia_id AS materia_id, m.nombre AS nombre FROM matricula a 
                    JOIN materias m ON m.materia_id = a.materia_id
                    WHERE a.grupo_id = :grupo_id GROUP BY nombre";
    $stmt_materias = $pdo->prepare($sql_materias);
    $stmt_materias->bindParam(':grupo_id', $grupo_id1, PDO::PARAM_INT);
    $stmt_materias->execute();

    while ($row = $stmt_materias->fetch(PDO::FETCH_ASSOC)) {
        $options .= '<option value="' . $row['materia_id'] . '">' . $row['nombre'] . '</option>';
    }
}

echo $options;

?>