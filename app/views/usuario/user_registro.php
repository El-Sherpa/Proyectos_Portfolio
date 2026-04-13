<?php include '../app/views/layout/header.php'; ?>

<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-xl shadow-lg">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Crea tu cuenta</h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Únete a la rueda de negocios de AGECSO
            </p>
        </div>
        
        <?php if(isset($mensaje)) echo $mensaje; ?>

        <form class="mt-8 space-y-6" action="index.php?controlador=usuario&accion=registro" method="POST">
            <div class="rounded-md shadow-sm space-y-4">
                <div>
                    <label for="nombre_usuario" class="block text-sm font-medium text-gray-700">Nombre del Representante</label>
                    <input id="nombre_usuario" name="nombre_usuario" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Juan Pérez">
                </div>
                <div>
                    <label for="nombre_empresa" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
                    <input id="nombre_empresa" name="nombre_empresa" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="Mi Empresa S.A.S">
                </div>
                <div>
                    <label for="correo" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                    <input id="correo" name="correo" type="email" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="correo@ejemplo.com">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" placeholder="********">
                </div>
                <div>
                    <label for="rol_id" class="block text-sm font-medium text-gray-700">Tipo de Perfil</label>
                    <select id="rol_id" name="rol_id" class="block w-full px-3 py-2 border border-gray-300 bg-white rounded-b-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="2">Comprador (Busco productos/servicios)</option>
                        <option value="3">Vendedor (Ofrezco productos/servicios)</option>
                    </select>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Registrarse
                </button>
            </div>
        </form>
        <div class="text-center">
            <a href="index.php?controlador=usuario&accion=login" class="text-sm text-blue-600 hover:underline">¿Ya tienes cuenta? Inicia sesión aquí</a>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
