
<?php
session_start();

// PRODUCTOS DE LA TIENDA
$productos = [
    [
        "id" => 1,
        "nombre" => "Laptop HP",
        "descripcion" => "Potencia y rendimiento para estudiar y trabajar.",
        "precio" => 650.00,
        "imagen" => "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500"
    ],
    [
        "id" => 2,
        "nombre" => "Smartphone Samsung",
        "descripcion" => "Tecnología moderna y excelente pantalla.",
        "precio" => 350.00,
        "imagen" => "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500"
    ],
    [
        "id" => 3,
        "nombre" => "Audífonos inalámbricos",
        "descripcion" => "Disfruta de tu música con gran calidad.",
        "precio" => 45.00,
        "imagen" => "https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500"
    ],
    [
        "id" => 4,
        "nombre" => "Teclado mecánico",
        "descripcion" => "Comodidad y precisión para cada actividad.",
        "precio" => 55.00,
        "imagen" => "https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=500"
    ],
    [
        "id" => 5,
        "nombre" => "Smartwatch",
        "descripcion" => "Mantente conectado durante todo el día.",
        "precio" => 80.00,
        "imagen" => "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500"
    ],
    [
        "id" => 6,
        "nombre" => "Cámara digital",
        "descripcion" => "Captura tus mejores momentos.",
        "precio" => 220.00,
        "imagen" => "https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=500"
    ]
];

// INICIAR CARRITO
if (!isset($_SESSION["carrito"])) {
    $_SESSION["carrito"] = [];
}

// AGREGAR PRODUCTOS
if (isset($_POST["agregar"])) {
    $id = (int) $_POST["agregar"];

    foreach ($productos as $producto) {
        if ($producto["id"] === $id) {
            if (isset($_SESSION["carrito"][$id])) {
                $_SESSION["carrito"][$id]["cantidad"]++;
            } else {
                $_SESSION["carrito"][$id] = [
                    "nombre" => $producto["nombre"],
                    "precio" => $producto["precio"],
                    "cantidad" => 1
                ];
            }

            unset($_SESSION["pedido"]);
            break;
        }
    }
}

// ELIMINAR PRODUCTOS
if (isset($_POST["eliminar"])) {
    $id = (int) $_POST["eliminar"];
    unset($_SESSION["carrito"][$id]);
    unset($_SESSION["pedido"]);
}

// CALCULAR TOTAL
$total = 0;
$cantidadTotal = 0;

foreach ($_SESSION["carrito"] as $item) {
    $total += $item["precio"] * $item["cantidad"];
    $cantidadTotal += $item["cantidad"];
}

// SIMULAR FINALIZACIÓN DE COMPRA
$metodosPago = [
    "efectivo" => "Pago en efectivo",
    "transferencia" => "Transferencia bancaria",
    "tarjeta" => "Tarjeta (simulación)"
];

if (isset($_POST["pagar"]) && !empty($_SESSION["carrito"])) {

    $metodo = $_POST["metodo_pago"] ?? "";

    if (isset($metodosPago[$metodo])) {

        $_SESSION["pedido"] = [
            "productos" => $_SESSION["carrito"],
            "total" => $total,
            "metodo" => $metodosPago[$metodo],
            "numero" => rand(10000, 99999)
        ];

        $_SESSION["carrito"] = [];
    }
}

// VARIABLES PARA MOSTRAR EL CARRITO
$total = 0;
$cantidadTotal = 0;

foreach ($_SESSION["carrito"] as $item) {
    $total += $item["precio"] * $item["cantidad"];
    $cantidadTotal += $item["cantidad"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TechStore | Tecnología para todos</title>

    <link rel="stylesheet" href="estilos.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

<body>

<!-- ENCABEZADO -->
<header class="header">

    <a href="#inicio" class="logo">
        <span class="logo-icon">T</span>
        Tech<span>Store</span>
    </a>

    <nav>
        <a href="#inicio">Inicio</a>
        <a href="#productos">Productos</a>
        <a href="#carrito">Mi carrito 🛒 (<?php echo $cantidadTotal; ?>)</a>
    </nav>

</header>

<!-- PRESENTACIÓN -->
<section class="hero" id="inicio">

    <div class="hero-contenido">
        <span class="etiqueta">TECNOLOGÍA A TU ALCANCE</span>

        <h1>Descubre una nueva forma de comprar tecnología.</h1>

        <p>
            Encuentra tus productos favoritos con calidad,
            innovación y excelentes precios.
        </p>

        <a href="#productos" class="boton-principal">
            Explorar productos →
        </a>
    </div>

    <div class="hero-imagen">
        <img
            src="https://images.unsplash.com/photo-1498049794561-7780e7231661?w=800"
            alt="Productos tecnológicos">
    </div>

</section>

<!-- BENEFICIOS -->
<section class="beneficios">

    <div class="beneficio">
        <span>🚚</span>
        <div>
            <h3>Envíos disponibles</h3>
            <p>Compra desde donde estés</p>
        </div>
    </div>

    <div class="beneficio">
        <span>🔒</span>
        <div>
            <h3>Compra segura</h3>
            <p>Proceso de compra sencillo</p>
        </div>
    </div>

    <div class="beneficio">
        <span>⭐</span>
        <div>
            <h3>Calidad garantizada</h3>
            <p>Productos seleccionados</p>
        </div>
    </div>

</section>

<!-- PRODUCTOS -->
<main>

    <section class="productos-seccion" id="productos">

        <div class="seccion-titulo">
            <span>DESCUBRE NUESTRA COLECCIÓN</span>
            <h2>Productos destacados</h2>
            <p>Encuentra la tecnología que necesitas.</p>
        </div>

        <div class="contenedor-productos">

            <?php foreach ($productos as $producto): ?>

                <article class="producto">

                    <div class="producto-imagen">
                        <img
                            src="<?php echo htmlspecialchars($producto["imagen"]); ?>"
                            alt="<?php echo htmlspecialchars($producto["nombre"]); ?>">
                    </div>

                    <div class="producto-info">

                        <h3><?php echo htmlspecialchars($producto["nombre"]); ?></h3>

                        <p>
                            <?php echo htmlspecialchars($producto["descripcion"]); ?>
                        </p>

                        <div class="producto-pie">

                            <strong>
                                $<?php echo number_format($producto["precio"], 2); ?>
                            </strong>

                            <form method="POST">
                                <button
                                    type="submit"
                                    name="agregar"
                                    value="<?php echo $producto["id"]; ?>">
                                    + Agregar
                                </button>
                            </form>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    </section>

    <!-- CARRITO -->
    <section class="carrito-seccion" id="carrito">

        <div class="seccion-titulo">
            <span>TUS COMPRAS</span>
            <h2>Mi carrito</h2>
        </div>

        <div class="carrito-contenido">

            <?php if (empty($_SESSION["carrito"])): ?>

                <div class="carrito-vacio">
                    <span>🛒</span>
                    <h3>Tu carrito está vacío</h3>
                    <p>Agrega algunos productos para comenzar tu compra.</p>
                    <a href="#productos" class="boton-principal">
                        Ver productos
                    </a>
                </div>

            <?php else: ?>

                <?php foreach ($_SESSION["carrito"] as $id => $item): ?>

                    <div class="item-carrito">

                        <div>
                            <h3><?php echo htmlspecialchars($item["nombre"]); ?></h3>

                            <p>
                                $<?php echo number_format($item["precio"], 2); ?>
                                x <?php echo $item["cantidad"]; ?>
                            </p>
                        </div>

                        <div class="item-derecha">

                            <strong>
                                $<?php echo number_format(
                                    $item["precio"] * $item["cantidad"], 2
                                ); ?>
                            </strong>

                            <form method="POST">
                                <button
                                    type="submit"
                                    name="eliminar"
                                    value="<?php echo $id; ?>"
                                    class="boton-eliminar">
                                    Eliminar
                                </button>
                            </form>

                        </div>

                    </div>

                <?php endforeach; ?>

                <div class="resumen-compra">

                    <h3>Resumen de compra</h3>

                    <p>Productos: <?php echo $cantidadTotal; ?></p>

                    <div class="total">
                        <span>Total a pagar:</span>
                        <strong>$<?php echo number_format($total, 2); ?></strong>
                    </div>

                    <form method="POST" class="formulario-pago">

                        <label for="metodo_pago">Selecciona tu forma de pago:</label>

                        <select name="metodo_pago" id="metodo_pago" required>
                            <option value="">Seleccionar método</option>
                            <option value="efectivo">💵 Pago en efectivo</option>
                            <option value="transferencia">🏦 Transferencia bancaria</option>
                            <option value="tarjeta">💳 Tarjeta (simulación)</option>
                        </select>

                        <button type="submit" name="pagar" class="boton-pagar">
                            Confirmar compra →
                        </button>

                        <small>Demostración académica. No se realizan cobros reales.</small>

                    </form>

                </div>

            <?php endif; ?>

        </div>

    </section>

    <!-- CONFIRMACIÓN DE COMPRA -->
    <?php if (isset($_SESSION["pedido"])): ?>

        <section class="confirmacion">

            <div class="confirmacion-icono">✓</div>

            <h2>¡Compra realizada con éxito!</h2>

            <p>Tu pedido ha sido registrado correctamente.</p>

            <div class="detalle-pedido">

                <p>
                    Número de pedido:
                    <strong>#<?php echo $_SESSION["pedido"]["numero"]; ?></strong>
                </p>

                <p>
                    Forma de pago:
                    <strong><?php echo htmlspecialchars($_SESSION["pedido"]["metodo"]); ?></strong>
                </p>

                <p>
                    Total del pedido:
                    <strong>$<?php echo number_format($_SESSION["pedido"]["total"], 2); ?></strong>
                </p>

            </div>

            <p class="aviso">
                Este es un comprobante de demostración.
                No se ha realizado ningún cobro.
            </p>

            <form method="POST">
                <button type="submit" name="nuevo_pedido" class="boton-principal">
                    Seguir comprando
                </button>
            </form>

        </section>

    <?php endif; ?>

</main>

<!-- PIE DE PÁGINA -->
<footer>

    <a href="#inicio" class="logo logo-footer">
        Tech<span>Store</span>
    </a>

    <p>Tu mundo tecnológico comienza aquí.</p>

    <p class="copyright">
        © 2026 TechStore. Todos los derechos reservados.
    </p>

</footer>

</body>
</html>

<?php
// INICIAR UNA NUEVA COMPRA
if (isset($_POST["nuevo_pedido"])) {
    unset($_SESSION["pedido"]);
    header("Location: index.php");
    exit;
}
?>
