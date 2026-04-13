<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGECSO - Software Rueda de Negocios</title>
    <!-- Recursos Locales para Carga Instantánea -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="assets/js/tailwind.js"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold tracking-wider text-white">AGECSO</a>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="index.php" class="hover:bg-blue-800 px-3 py-2 rounded-md text-sm font-medium">Inicio</a>
                        <?php if(isset($_SESSION['usuario_id'])): ?>
                            <a href="index.php?controlador=usuario&accion=logout" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">Cerrar Sesión</a>
                        <?php else: ?>
                            <a href="index.php?controlador=usuario&accion=login" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md text-sm font-medium">Iniciar Sesión</a>
                            <a href="index.php?controlador=usuario&accion=registro" class="border border-white hover:bg-white hover:text-blue-900 px-4 py-2 rounded-md text-sm font-medium transition duration-300">Registrarse</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-grow">
