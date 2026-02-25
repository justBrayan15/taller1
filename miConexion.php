<html>

<head>
  <title>Base de datos</title>
</head>

<body>
  <?php
  $conexion = mysqli_connect("localhost", "root", "", "univalle") or
    die("Problemas con la conexión");

  $nombre = $_REQUEST['nombre'];
  $correo = $_REQUEST['correo'];
  $codigocurso = $_REQUEST['codigocurso'];

  $consulta = mysqli_query($conexion, "SELECT * FROM alumnos WHERE nombre='$nombre' AND correo='$correo'");
  if (mysqli_num_rows($consulta) > 0) {
     echo "El alumno ya está registrado.";
  } else {

     mysqli_query($conexion, "INSERT INTO alumnos(nombre, correo, codigocurso) VALUES 
                              ('$nombre','$correo','$codigocurso')")
         or die("Problemas en el insert " . mysqli_error($conexion));

     echo "El alumno fue dado de alta.";
}

mysqli_close($conexion);
  ?>
</body>

</html>