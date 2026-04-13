<?php include '../app/views/layout/header.php'; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Panel de Administración</h1>

        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-600">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                        <i class="fas fa-building fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold">Total Empresas</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $total_empresas; ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-600">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold">Reuniones</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo $total_reuniones; ?></p>
                    </div>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-600">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold">Negocios (Monto)</p>
                        <p class="text-2xl font-bold text-gray-900">$<?php echo number_format($negocios_cerrados, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestión de Ruedas de Negocios -->
        <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Ruedas de Negocios</h3>
                <div class="space-x-2">
                    <button onclick="document.getElementById('modalCrearAdmin').classList.remove('hidden')" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-user-shield mr-2"></i> Nuevo Administrador
                    </button>
                    <button onclick="document.getElementById('modalCrearRueda').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-plus mr-2"></i> Nueva Rueda
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fechas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($ruedas)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 italic">No hay ruedas de negocios creadas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ruedas as $r): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($r['titulo']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo $r['fecha_inicio']; ?> al <?php echo $r['fecha_fin']; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if($r['estado'] == 'abierta'): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Abierta</span>
                                        <?php elseif($r['estado'] == 'cerrada'): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cerrada</span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Finalizada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <?php if($r['estado'] == 'cerrada'): ?>
                                            <a href="index.php?controlador=admin&accion=cambiarEstadoRueda&id=<?php echo $r['id']; ?>&estado=abierta" class="text-green-600 hover:text-green-900 mr-3">Abrir</a>
                                        <?php elseif($r['estado'] == 'abierta'): ?>
                                            <a href="index.php?controlador=admin&accion=cambiarEstadoRueda&id=<?php echo $r['id']; ?>&estado=cerrada" class="text-red-600 hover:text-red-900 mr-3">Cerrar</a>
                                        <?php endif; ?>
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Estadísticas</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Seguimiento Detallado de Citas (Nuevo Reporte para Dayana) -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-indigo-50">
                <h3 class="text-lg font-bold text-indigo-900">Seguimiento de Citas y Negocios</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comprador</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vendedor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($reuniones_detalladas)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">No se han agendado citas aún.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reuniones_detalladas as $rd): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($rd['rueda']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($rd['comprador']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($rd['vendedor']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $rd['estado'] == 'aceptada' ? 'bg-green-100 text-green-800' : 
                                                ($rd['estado'] == 'realizada' ? 'bg-blue-100 text-blue-800' : 
                                                ($rd['estado'] == 'rechazada' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                            <?php echo ucfirst($rd['estado']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                                        $<?php echo number_format((float)($rd['monto_negocio'] ?? 0), 2); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Crear Admin -->
<div id="modalCrearAdmin" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalCrearAdmin').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=admin&accion=crearAdmin" method="POST">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Nuevo Administrador</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input type="text" name="nombre" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm" placeholder="Ej: Ana María García">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                            <input type="email" name="correo" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm" placeholder="admin2@agecso.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm" placeholder="********">
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 sm:ml-3 sm:w-auto sm:text-sm">Crear Administrador</button>
                    <button type="button" onclick="document.getElementById('modalCrearAdmin').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Crear Rueda -->
<div id="modalCrearRueda" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalCrearRueda').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=admin&accion=crearRueda" method="POST">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Nueva Rueda de Negocios</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm" placeholder="Ej: Rueda Regional de Agro 2026">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm" placeholder="Detalles del evento..."></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                                <input type="date" name="fecha_fin" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado Inicial</label>
                            <select name="estado" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm">
                                <option value="cerrada">Cerrada (Solo lectura)</option>
                                <option value="abierta">Abierta (Permite inscripciones)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm">Crear Evento</button>
                    <button type="button" onclick="document.getElementById('modalCrearRueda').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../app/views/layout/footer.php'; ?>
