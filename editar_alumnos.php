<?php
$conexion = new mysqli("localhost", "root", "", "univalle");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        $stmt = $conexion->prepare("UPDATE alumnos SET nombre=?, correo=?, codigocurso=? WHERE nombre=? AND correo=?");
        $stmt->bind_param("ssiss", $_POST['edit_nombre'], $_POST['edit_correo'], $_POST['edit_codigocurso'], $_POST['original_nombre'], $_POST['original_correo']);
        echo $stmt->execute() ? "<div class='success-message'>Alumno actualizado.</div>" : "<div class='error-message'>Error: " . $stmt->error . "</div>";
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $stmt = $conexion->prepare("DELETE FROM alumnos WHERE nombre=? AND correo=?");
        $stmt->bind_param("ss", $_POST['delete_nombre'], $_POST['delete_correo']);
        echo $stmt->execute() ? "<div class='success-message'>Alumno eliminado.</div>" : "<div class='error-message'>Error: " . $stmt->error . "</div>";
        $stmt->close();
    }
}

$result = $conexion->query("SELECT nombre, correo, codigocurso FROM alumnos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Actualización de Alumnos</title>
    <link rel="stylesheet" href="CSS/editar.css">
</head>
<body>
    <h1>Actualización de Alumnos</h1>
    <table>
        <tr><th>Nombre</th><th>Correo</th><th>Curso</th><th>Acción</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['correo']) ?></td>
                <td><?= htmlspecialchars($row['codigocurso']) ?></td>
                <td>
                    <button onclick="openEditForm('<?= $row['nombre'] ?>', '<?= $row['correo'] ?>', '<?= $row['codigocurso'] ?>')">Editar</button>
                    <form method='post' style='display:inline;' onsubmit="return confirm('¿Eliminar este alumno?')">
                        <input type='hidden' name='delete_nombre' value='<?= $row['nombre'] ?>'>
                        <input type='hidden' name='delete_correo' value='<?= $row['correo'] ?>'>
                        <button type='submit' name='delete'>Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div id="editFormContainer" style="display:none;">
        <form method="post">
            <h2>Editar Estudiante</h2>
            <input type="hidden" id="original_nombre" name="original_nombre">
            <input type="hidden" id="original_correo" name="original_correo">
            <label>Nombre: <input type="text" id="edit_nombre" name="edit_nombre" required></label>
            <label>Correo: <input type="email" id="edit_correo" name="edit_correo" required></label>
            <label>Curso:
                <select id="edit_codigocurso" name="edit_codigocurso">
                    <option value="1">Base de Datos</option>
                    <option value="2">Desarrollo Web</option>
                    <option value="3">Inteligencia Artificial</option>
                </select>
            </label>
            <button type="submit" name="update">Actualizar</button>
            <button type="button" onclick="document.getElementById('editFormContainer').style.display='none'">Cancelar</button>
        </form>
    </div>
    
    <a href="index.html" class="button">Regresar a Matricula</a>

    <script>
        function openEditForm(nombre, correo, codigocurso) {
            document.getElementById('original_nombre').value = nombre;
            document.getElementById('original_correo').value = correo;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_correo').value = correo;
            document.getElementById('edit_codigocurso').value = codigocurso;
            document.getElementById('editFormContainer').style.display = 'block';
        }
    </script>
</body>
</html>
