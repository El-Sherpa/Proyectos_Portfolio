<?php include '../app/views/layout/header.php'; ?>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Panel del Vendedor</h1>
                <p class="text-gray-600 mt-1">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?> (<?php echo htmlspecialchars($empresa['nombre_empresa']); ?>)</p>
            </div>
            <div class="mt-4 md:mt-0">
                <button onclick="document.getElementById('modalOferta').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium shadow-sm transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Registrar Oferta
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Columna Izquierda: Mis Productos y Citas Solicitadas -->
            <div class="md:col-span-2 space-y-6">
                <!-- Mis Citas Solicitadas y sus Estados -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-indigo-50">
                        <h3 class="text-lg leading-6 font-medium text-indigo-900">Mis Solicitudes de Reunión</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($mis_citas)): ?>
                            <li class="px-4 py-8 text-center text-gray-500 italic">No has solicitado citas aún.</li>
                        <?php else: ?>
                            <?php foreach ($mis_citas as $cita): ?>
                                <li class="px-4 py-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-gray-900">Comprador: <?php echo htmlspecialchars($cita['nombre_comprador']); ?></p>
                                            <p class="text-xs text-gray-500 mt-1">Fecha: <?php echo $cita['fecha_hora']; ?></p>
                                            <p class="text-xs font-medium mt-1">
                                                Estado: 
                                                <span class="px-2 py-0.5 rounded-full <?php 
                                                    echo $cita['estado'] == 'aceptada' ? 'bg-green-100 text-green-800' : 
                                                        ($cita['estado'] == 'rechazada' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800'); 
                                                ?>">
                                                    <?php echo ucfirst($cita['estado']); ?>
                                                </span>
                                            </p>
                                        </div>
                                        <?php if ($cita['estado'] == 'aceptada'): ?>
                                            <div class="ml-4 flex-shrink-0">
                                                <button onclick="abrirModalResultado(<?php echo $cita['id']; ?>, '<?php echo htmlspecialchars($cita['nombre_comprador']); ?>')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                                    Registrar Resultado
                                                </button>
                                            </div>
                                        <?php elseif ($cita['estado'] == 'realizada'): ?>
                                            <div class="ml-4 flex-shrink-0 text-right text-xs text-gray-500">
                                                <p class="font-bold text-green-600">Negocio: $<?php echo number_format($cita['monto_negocio'], 2); ?></p>
                                                <p>Cerrada</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-gray-50">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Mi Oferta Comercial</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($ofertas)): ?>
                            <li class="px-4 py-8 text-center text-gray-500 italic">No has registrado productos o servicios aún.</li>
                        <?php else: ?>
                            <?php foreach ($ofertas as $ofe): ?>
                                <li class="px-4 py-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-indigo-600 truncate"><?php echo htmlspecialchars($ofe['producto_servicio']); ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($ofe['descripcion']); ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Disponible</span>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Oportunidades de Negocio (Demandas de Compradores) -->
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-green-50">
                        <h3 class="text-lg leading-6 font-medium text-green-900">Oportunidades de Negocio (Demandas)</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($oportunidades)): ?>
                            <li class="px-4 py-8 text-center text-gray-500 italic">No hay demandas publicadas por compradores en este momento.</li>
                        <?php else: ?>
                            <?php foreach ($oportunidades as $op): ?>
                                <li class="px-4 py-4 hover:bg-gray-50 transition duration-150">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-2">
                                                <span class="px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800"><?php echo htmlspecialchars($op['rueda_titulo']); ?></span>
                                                <p class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($op['nombre_empresa']); ?></p>
                                            </div>
                                            <p class="text-sm text-indigo-600 mt-1 font-medium"><?php echo htmlspecialchars($op['requerimiento']); ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($op['descripcion']); ?></p>
                                        </div>
                                        <div class="ml-4 flex-shrink-0">
                                            <button onclick="abrirModalCita(<?php echo $ruedas[0]['id']; ?>, <?php echo $op['empresa_id']; ?>, '<?php echo htmlspecialchars($op['nombre_empresa']); ?>')" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Solicitar Cita
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Columna Derecha: Oportunidades -->
            <div>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6 bg-indigo-50">
                        <h3 class="text-lg leading-6 font-medium text-indigo-900">Ruedas Activas</h3>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        <?php if (empty($ruedas)): ?>
                            <li class="px-4 py-4 text-sm text-gray-500">No hay eventos activos.</li>
                        <?php else: ?>
                            <?php foreach ($ruedas as $r): ?>
                                <li class="px-4 py-4">
                                    <p class="text-sm font-bold text-gray-900"><?php echo htmlspecialchars($r['titulo']); ?></p>
                                    <p class="text-xs text-gray-500 italic">Fecha fin: <?php echo $r['fecha_fin']; ?></p>
                                    <button class="mt-2 text-xs text-indigo-600 hover:text-indigo-800 font-bold uppercase">Postularme</button>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar oferta -->
<div id="modalOferta" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalOferta').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=vendedor&accion=registrarOferta" method="POST">
                <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">¿Qué ofreces al mercado?</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre del Producto o Servicio</label>
                            <input type="text" name="producto_servicio" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ej: Consultoría en Marketing Digital">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción Técnica / Comercial</label>
                            <textarea name="descripcion" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Detalla las características y beneficios de tu oferta..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Publicar Oferta</button>
                    <button type="button" onclick="document.getElementById('modalOferta').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para solicitar cita -->
<div id="modalCita" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalCita').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=vendedor&accion=solicitarCita" method="POST">
                <input type="hidden" name="rueda_id" id="cita_rueda_id">
                <input type="hidden" name="comprador_id" id="cita_comprador_id">
                <input type="hidden" name="vendedor_id" value="<?php echo $empresa['id']; ?>">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Solicitar Reunión con <span id="nombre_comprador_modal" class="text-indigo-600"></span></h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Selecciona Fecha y Hora sugerida</label>
                            <input type="datetime-local" name="fecha_hora" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <p class="text-xs text-gray-500 italic">El comprador deberá aceptar o rechazar esta solicitud de acuerdo al flujograma.</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">Enviar Solicitud</button>
                    <button type="button" onclick="document.getElementById('modalCita').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para registrar resultado de la reunión -->
<div id="modalResultado" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('modalResultado').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="index.php?controlador=vendedor&accion=registrarResultado" method="POST">
                <input type="hidden" name="cita_id" id="resultado_cita_id">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Resultado de Reunión con <span id="nombre_comprador_resultado" class="text-indigo-600"></span></h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monto aproximado del Negocio ($)</label>
                            <input type="number" step="0.01" name="monto_negocio" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notas y Acuerdos</label>
                            <textarea name="notas_resultado" rows="4" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Resumen de la reunión y próximos pasos..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">Finalizar Reunión</button>
                    <button type="button" onclick="document.getElementById('modalResultado').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalCita(ruedaId, compradorId, nombreComprador) {
    document.getElementById('cita_rueda_id').value = ruedaId;
    document.getElementById('cita_comprador_id').value = compradorId;
    document.getElementById('nombre_comprador_modal').innerText = nombreComprador;
    document.getElementById('modalCita').classList.remove('hidden');
}

function abrirModalResultado(citaId, nombreComprador) {
    document.getElementById('resultado_cita_id').value = citaId;
    document.getElementById('nombre_comprador_resultado').innerText = nombreComprador;
    document.getElementById('modalResultado').classList.remove('hidden');
}
</script>

<?php include '../app/views/layout/footer.php'; ?>
