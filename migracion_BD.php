<?php
include 'conexion2.php';

// Verificar la conexión
if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}

// Nombre único de la migración

$nombre_migracion = 'Nuevos campos a la tabla alumnos';
$lote = 3;


$nombre_migracion = '20241069_crear_tabla_nuevo_semestre';
$lote = 2;


$nombre_migracion = '20241069_crear_tabla_nuevo_semestre';
$lote = 2;

$nombre_migracion = '20240926_crear_tabla_pruebas';
$lote = 1;




// Verificar si la migración ya fue aplicada
$verificar_sql = "SELECT * FROM migraciones WHERE nombre_migracion = '$nombre_migracion'";
$resultado = $db->query($verificar_sql);

if ($resultado->num_rows == 0) {
    // Si no ha sido aplicada, crear la tabla 'pruebas'

    $sql_migraciones = "ALTER TABLE alumnos
        ADD COLUMN sr VARCHAR(100) NULL,
        ADD COLUMN domicilio VARCHAR(100) NULL,
        ADD COLUMN colonia VARCHAR(100) NULL,
        ADD COLUMN ciudad VARCHAR(100) NULL,
        ADD COLUMN codigo_postal INT(20) NULL
    ";
    
    if ($db->query($sql_migraciones) === TRUE) {
        echo "Migración aplicada exitosamente: Se agregaron los nuevos campos a la tabla de alumnos' Creados.<br>";
=======




    $sql_migraciones = "CREATE TABLE `new_sem` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `id_semestre` int(11) DEFAULT NULL,
        `id_facultad` int(11) DEFAULT NULL,
        `id_grupo` int(11) DEFAULT NULL,
        `id_materia` int(11) DEFAULT NULL,
        `id_profesor` int(11) DEFAULT NULL,
        `Hora_inicio` time DEFAULT NULL,
        `Hora_fin` time DEFAULT NULL,
        FOREIGN KEY (`id_semestre`) REFERENCES `semestres` (`semestre_id`),
        FOREIGN KEY (`id_facultad`) REFERENCES `facultades` (`facultad_id`),
        FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`grupo_id`),
        FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`profesor_id`),
        FOREIGN KEY (`id_materia`) REFERENCES `materias` (`materia_id`)
    )";
    
    if ($db->query($sql_migraciones) === TRUE) {
        echo "Migración aplicada exitosamente: tabla 'Nuevo semestre' creada.<br>";

    $sql_migraciones = "CREATE TABLE IF NOT EXISTS pruebas (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        prueba_1 VARCHAR(100) NOT NULL,
        descripcion TEXT,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($db->query($sql_migraciones) === TRUE) {
        echo "Migración aplicada exitosamente: tabla 'pruebas' creada.<br>";




        // Registrar la migración en la tabla 'migraciones'
        $sql_registrar_migracion = "INSERT INTO migraciones (nombre_migracion, lote) VALUES ('$nombre_migracion', $lote)";
        
        if ($db->query($sql_registrar_migracion) === TRUE) {
            echo "Migración registrada en la tabla 'migraciones'.<br>";
        } else {
            echo "Error al registrar la migración: " . $db->error . "<br>";
        }
    } else {
        echo "Error al aplicar la migración: " . $db->error . "<br>";
    }
} else {
    echo "La migración '$nombre_migracion' ya ha sido aplicada anteriormente.<br>";
}

// Verificación de registro
$consulta_verificar = "SELECT * FROM migraciones WHERE nombre_migracion = '$nombre_migracion'";
$resultado_verificacion = $db->query($consulta_verificar);

if ($resultado_verificacion->num_rows > 0) {
    echo "La migración '$nombre_migracion' ha sido registrada correctamente.<br>";
} else {
    echo "La migración '$nombre_migracion' no ha sido registrada.<br>";
}

// Cerrar la conexión
$db->close();
?>
