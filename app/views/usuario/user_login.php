<?php include '../app/views/layout/header.php'; ?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Inicia Sesión</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Accede a tu cuenta de AGECSO
            </p>
        </div>
        
        <?php if(isset($mensaje)) echo $mensaje; ?>

        <form class="mt-8 space-y-6" action="index.php?controlador=usuario&accion=login" method="POST">
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input id="correo" name="correo" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="********">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                    Entrar
                </button>
            </div>
        </form>
        <div class="text-center">
            <a href="index.php?controlador=usuario&accion=registro" class="text-sm text-blue-600 hover:underline">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
