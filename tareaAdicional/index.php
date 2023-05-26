<?php
include_once 'conexion.php';

// Agregar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precioUnitario = $_POST['precio_unitario'];
    $precioPromedio = $_POST['precio_promedio'];
    $ultimoPrecio = $_POST['ultimo_precio'];
    $fechaInicialCompra = $_POST['fecha_inicial_compra'];
    $fechaUltimaCompra = $_POST['fecha_ultima_compra'];
    
    $sql = "INSERT INTO producto (codigo, descripcion, cantidad, Precio_unitario, Precio_promedio, Ultimo_precio, fecha_inicial_compra, fecha_ultima_compra) VALUES ('$codigo', '$descripcion', $cantidad, $precioUnitario, $precioPromedio, $ultimoPrecio, '$fechaInicialCompra', '$fechaUltimaCompra')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Actualizar un producto existente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $precioUnitario = $_POST['precio_unitario'];
    $precioPromedio = $_POST['precio_promedio'];
    $ultimoPrecio = $_POST['ultimo_precio'];
    $fechaInicialCompra = $_POST['fecha_inicial_compra'];
    $fechaUltimaCompra = $_POST['fecha_ultima_compra'];
    
    $sql = "UPDATE producto SET descripcion = '$descripcion', cantidad = $cantidad, Precio_unitario = $precioUnitario, Precio_promedio = $precioPromedio, Ultimo_precio = $ultimoPrecio, fecha_inicial_compra = '$fechaInicialCompra', fecha_ultima_compra = '$fechaUltimaCompra' WHERE id_producto = $id";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener todos los productos
$sql = "SELECT * FROM producto";
$resultado = $conn->query($sql);
$productos = array();

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Productos</title>
    <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
<body>
    <h2>Lista de Productos</h2>

    <button onclick="mostrarFormulario()">Agregar Producto</button>

    <table id="productosTable">
        <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Precio Promedio</th>
            <th>Último Precio</th>
            <th>Fecha Inicial Compra</th>
            <th>Fecha Última Compra</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo $producto['codigo']; ?></td>
            <td><?php echo $producto['descripcion']; ?></td>
            <td><?php echo $producto['cantidad']; ?></td>
            <td><?php echo $producto['Precio_unitario']; ?></td>
            <td><?php echo $producto['Precio_promedio']; ?></td>
            <td><?php echo $producto['Ultimo_precio']; ?></td>
            <td><?php echo $producto['fecha_inicial_compra']; ?></td>
            <td><?php echo $producto['fecha_ultima_compra']; ?></td>
            <td>
                <button onclick="editarProducto('<?php echo $producto['id_producto']; ?>', '<?php echo $producto['descripcion']; ?>', '<?php echo $producto['cantidad']; ?>', '<?php echo $producto['Precio_unitario']; ?>', '<?php echo $producto['Precio_promedio']; ?>', '<?php echo $producto['Ultimo_precio']; ?>', '<?php echo $producto['fecha_inicial_compra']; ?>', '<?php echo $producto['fecha_ultima_compra']; ?>')">Editar</button>
                <a href="eliminar_producto.php?id=<?php echo $producto['id_producto']; ?>" class="eliminar-link">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div id="formulario" style="display: none;">
        <h3>Agregar Producto</h3>
        <form action="index.php" method="POST">
            <label>Código:</label>
            <input type="text" name="codigo"><br>
            <label>Descripción:</label>
            <input type="text" name="descripcion"><br>
            <label>Cantidad:</label>
            <input type="number" name="cantidad"><br>
            <label>Precio Unitario:</label>
            <input type="text" name="precio_unitario"><br>
            <label>Precio Promedio:</label>
            <input type="text" name="precio_promedio"><br>
            <label>Último Precio:</label>
            <input type="text" name="ultimo_precio"><br>
            <label>Fecha Inicial Compra:</label>
            <input type="date" name="fecha_inicial_compra"><br>
            <label>Fecha Última Compra:</label>
            <input type="date" name="fecha_ultima_compra"><br>
            <input type="submit" name="agregar" value="Agregar">
        </form>
    </div>

    <div id="editarFormulario" style="display: none;">
        <h3>Editar Producto</h3>
        <form id="editForm" method="POST">
            <input type="hidden" id="editId" name="id">
            <label>Descripción:</label>
            <input type="text" id="editDescripcion" name="descripcion"><br>
            <label>Cantidad:</label>
            <input type="number" id="editCantidad" name="cantidad"><br>
            <label>Precio Unitario:</label>
            <input type="text" id="editPrecioUnitario" name="precio_unitario"><br>
            <label>Precio Promedio:</label>
            <input type="text" id="editPrecioPromedio" name="precio_promedio"><br>
            <label>Último Precio:</label>
            <input type="text" id="editUltimoPrecio" name="ultimo_precio"><br>
            <label>Fecha Inicial Compra:</label>
            <input type="date" id="editFechaInicialCompra" name="fecha_inicial_compra"><br>
            <label>Fecha Última Compra:</label>
            <input type="date" id="editFechaUltimaCompra" name="fecha_ultima_compra"><br>
            <input type="button" value="Guardar" onclick="guardarEdicion()">
            <input type="button" value="Cancelar" onclick="cancelarEdicion()">
        </form>
    </div>

    <script>
        function mostrarFormulario() {
            document.getElementById("formulario").style.display = "block";
        }

        function editarProducto(id, descripcion, cantidad, precioUnitario, precioPromedio, ultimoPrecio, fechaInicialCompra, fechaUltimaCompra) {
            // Llenar los campos del formulario de edición con los valores del producto
            document.getElementById("editId").value = id;
            document.getElementById("editDescripcion").value = descripcion;
            document.getElementById("editCantidad").value = cantidad;
            document.getElementById("editPrecioUnitario").value = precioUnitario;
            document.getElementById("editPrecioPromedio").value = precioPromedio;
            document.getElementById("editUltimoPrecio").value = ultimoPrecio;
            document.getElementById("editFechaInicialCompra").value = fechaInicialCompra;
            document.getElementById("editFechaUltimaCompra").value = fechaUltimaCompra;

            // Mostrar el formulario de edición
            document.getElementById("editarFormulario").style.display = "block";
        }

        function guardarEdicion() {
            // Enviar el formulario de edición
            document.getElementById("editForm").submit();
        }

        function cancelarEdicion() {
            // Ocultar el formulario de edición
            document.getElementById("editarFormulario").style.display = "none";
        }
    </script>
</body>
</html>
