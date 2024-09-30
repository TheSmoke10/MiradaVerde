<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirige al login si no está autenticado
    exit;
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirada Verde</title>
    <link rel="shortcut icon" href="/Img/icon-back.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <?php
    include("complement/header.php");
    ?>

    <div class="container my-5">
      <div class="p-5 text-center bg-body-tertiary rounded-3">
        <h1 class="text-body-emphasis">Item <a type="button" class="btn btn-primary" href="/itemN.php">Nuevo</a></h1>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Descripción</th>
              <th scope="col">Opción</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Incluir la conexión a la base de datos
            include("Controller/connect.php");

            // Consulta para obtener los items de la base de datos
            $query = "SELECT IdItems, Name, Description FROM items";
            $stmt = sqlsrv_query($conn, $query);

            // Verificar si se obtuvieron resultados
            if ($stmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            // Contador de filas
            $rowNumber = 1;

            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                echo "<tr>";
                echo "<th scope='row'>{$rowNumber}</th>"; // Número de fila
                echo "<td>" . htmlspecialchars(utf8_encode($row['Name'])) . "</td>"; // Nombre del item
                echo "<td>" . htmlspecialchars(utf8_encode($row['Description'])) . "</td>"; // Descripción del item
                echo "<td>";
                echo "<a type='button' class='btn btn-success' href='/itemU.php?id=" . $row['IdItems'] . "'>Editar</a> ";
                echo "<a type='button' class='btn btn-danger' href='/Controller/delete_item.php?id=" . $row['IdItems'] . "' onclick='return confirm(\"¿Estás seguro de eliminar este ítem?\")'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";

                // Incrementar el contador de filas
                $rowNumber++;
            }

            // Cerrar la conexión y liberar recursos
            sqlsrv_free_stmt($stmt);
            sqlsrv_close($conn);
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php
    include("complement/footer.php");
    ?>

  </body>
</html>
