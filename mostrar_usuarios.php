<!DOCTYPE html>
<html>
<head>
  <title>Mostrar alumnos</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/mostrar.css">
  </head>
<body>
  <div class="Pagina">
    <h2>Lista de alumnos Registrados</h2>
    <table>
      <thead>
        <tr>
          <th>nombre</th>
          <th>correo</th>
          <th>codigocurso</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $dbname = "univalle";

          $conexion = new mysqli($servername, $username, $password, $dbname);

          if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
          }

          $sql = "SELECT nombre, correo, codigocurso FROM alumnos";
          $result = $conexion->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['nombre']}</td>
                      <td>{$row['correo']}</td>
                      <td>{$row['codigocurso']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='3'>No se encontraron datos</td></tr>";
          }

          $conexion->close();
        ?>
      </tbody>
    </table>
    <div class="boton-regreso">
      <a href="index.html" class="button">Regresar</a>
    </div>
    <div class="boton-editar">
    <a href="editar_alumnos.php" class="button">Editar Alumnos</a>
    </div>
  </div>
</body>
</html>