<?php include '../app/views/layout/header.php'; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Panel del Comprador</h1>
                <p class="text-gray-600 mt-1">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?> (<?php echo htmlspecialchars($empresa['nombre_empresa']); ?>)</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('modalRequerimiento').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Nuevo Requerimiento
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Mis Requerimientos y Citas -->
            <div class="md:col-span-2 space-y-6">
                <!-- Gestión de Citas Recibidas -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-blue-50">
                        <h3 class="text-lg leading-6 font-medium text-blue-900">Solicitudes de Reunión Recibidas</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($citas_recibidas)): ?>
                            <li class="px-4 py-8 text-center text-gray-500 italic">No tienes solicitudes de citas pendientes.</li>
                        <?php else: ?>
                            <?php foreach ($citas_recibidas as $cita): ?>
                                <li class="px-4 py-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900">Vendedor: <?php echo htmlspecialchars($cita['nombre_vendedor']); ?></p>
                                            <p class="text-xs text-gray-500 mt-1">Evento: <?php echo htmlspecialchars($cita['rueda_titulo']); ?></p>
                                            <p class="text-sm text-blue-600 mt-1 font-medium"><i class="far fa-calendar-alt mr-1"></i> <?php echo $cita['fecha_hora']; ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0 flex space-x-2">
                                            <?php if ($cita['estado'] == 'pendiente'): ?>
                                                <form action="index.php?controlador=comprador&accion=gestionarCita" method="POST" class="inline">
                                                    <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                                    <input type="hidden" name="estado" value="aceptada">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700">Aceptar</button>
                                                </form>
                                                <form action="index.php?controlador=comprador&accion=gestionarCita" method="POST" class="inline">
                                                    <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                                    <input type="hidden" name="estado" value="rechazada">
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700">Rechazar</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $cita['estado'] == 'aceptada' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                                    <?php echo ucfirst($cita['estado']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Mis Requerimientos (Demanda)</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($requerimientos)): ?>
                            <li class="px-4 py-8 text-center text-gray-500 italic">No has registrado requerimientos aún.</li>
                        <?php else: ?>
                            <?php foreach ($requerimientos as $req): ?>
                                <li class="px-4 py-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-blue-600 truncate"><?php echo htmlspecialchars($req['requerimiento']); ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($req['descripcion']); ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Columna Derecha: Ruedas de Negocios -->
            <div>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-blue-50">
                        <h3 class="text-lg leading-6 font-medium text-blue-900">Ruedas Disponibles</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($ruedas)): ?>
                            <li class="px-4 py-4 text-sm text-gray-500">No hay ruedas activas en este momento.</li>
                        <?php else: ?>
                            <?php foreach ($ruedas as $r): ?>
                                <li class="px-4 py-4">
                                    <p class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($r['titulo']); ?></p>
                                    <p class="text-xs text-gray-500">Fin: <?php echo $r['fecha_fin']; ?></p>
                                    <button class="mt-2 text-xs text-blue-600 hover:text-blue-800 font-bold uppercase">Ver Participantes</button>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar requerimiento -->
<div id="modalRequerimiento" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalRequerimiento').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=comprador&accion=registrarRequerimiento" method="POST">
                <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">¿Qué estás buscando?</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título del Requerimiento</label>
                            <input type="text" name="requerimiento" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Ej: Proveedor de materias primas">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción Detallada</label>
                            <textarea name="descripcion" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Describe lo que necesitas contratar o comprar..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Guardar</button>
                    <button type="button" onclick="document.getElementById('modalRequerimiento').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
