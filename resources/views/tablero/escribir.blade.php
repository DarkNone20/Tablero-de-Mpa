<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Tablero</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen p-6 relative overflow-x-hidden">
    <!-- Resplandor ambiental sutil de fondo -->
    <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-900/20 via-slate-950 to-slate-950 -z-10"></div>

    <div class="max-w-7xl mx-auto">
        <!-- Barra superior -->
        <header class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-900/80 backdrop-blur-md px-6 py-4 rounded-2xl mb-6 border border-slate-800 shadow-xl">
            <div class="text-center sm:text-left">
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-wide bg-gradient-to-r from-indigo-300 via-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    PANEL DE CONTROL DEL TABLERO
                </h1>
                <p class="text-xs text-slate-400 mt-1">Gestión de mensajes fijos, programación diaria y pruebas de software</p>
            </div>

            <a href="{{ route('tablero.mostrar') }}" target="_blank"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 active:scale-[0.98] text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-600/25 border border-indigo-400/30 transition-all duration-200">
                <span>Abrir Pantalla de Visualización</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                </svg>
            </a>
        </header>

        <!-- Alerta de éxito -->
        @if(session('success'))
            <div class="flex items-center gap-3 bg-emerald-950/80 border border-emerald-500/40 text-emerald-300 px-4 py-3.5 rounded-xl mb-6 shadow-lg backdrop-blur-sm">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Formulario de creación -->
        <section class="bg-slate-900/75 backdrop-blur-md border border-slate-800 p-6 rounded-2xl shadow-xl mb-8">
            <div class="flex items-center gap-2.5 border-b border-slate-800 pb-4 mb-5">
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(129,140,248,0.6)]"></span>
                <h2 class="text-lg font-bold tracking-wide text-slate-100">Publicar Nuevo Mensaje</h2>
            </div>

            <form action="{{ route('tablero.guardar') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="tipoSelector" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                            Tipo de Información
                        </label>
                        <select name="tipo" id="tipoSelector" onchange="toggleCamposCrear()"
                                class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none cursor-pointer">
                            <option value="fecha">Por Fecha (Solo se muestra ese día)</option>
                            <option value="general">General (Fija / Permanente)</option>
                            <option value="pruebas_software">Prueba de Software (Por fecha)</option>
                        </select>
                    </div>

                    <div id="campoFecha">
                        <label for="inputFechaCrear" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                            Fecha a mostrar
                        </label>
                        <input type="date" id="inputFechaCrear" name="fecha" value="{{ $fechaSeleccionada }}"
                               class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none cursor-pointer [color-scheme:dark]">
                    </div>

                    <div id="campoTitulo">
                        <label id="labelTituloCrear" for="inputTitulo" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                            Título
                        </label>
                        <input type="text" id="inputTitulo" name="titulo" placeholder="Ej. Turno mañana / Aviso"
                               class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none">
                    </div>
                </div>

                <div>
                    <label for="inputContenido" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                        Contenido
                    </label>
                    <textarea id="inputContenido" name="contenido" rows="3" required placeholder="Escribe aquí la información del tablero..."
                              class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-3 text-sm leading-relaxed transition-all outline-none"></textarea>
                </div>

                <div class="flex justify-end pt-1">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 active:scale-[0.98] text-white font-semibold text-sm px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/25 border border-blue-400/30 transition-all duration-200 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Guardar en Tablero</span>
                    </button>
                </div>
            </form>
        </section>

        <!-- Barra de filtro global de fecha -->
        <div class="flex flex-wrap justify-between items-center gap-3 bg-slate-900/50 border border-slate-800/80 px-5 py-3 rounded-2xl mb-6">
            <span class="text-xs font-medium uppercase tracking-wider text-slate-400">
                Mostrando programación y pruebas del día:
            </span>
            <form method="GET" action="{{ route('tablero.escribir') }}" class="flex items-center gap-2">
                <input type="date" name="fecha" value="{{ $fechaSeleccionada }}" onchange="this.form.submit()"
                       class="bg-slate-950/90 hover:bg-slate-950 border border-slate-700 hover:border-indigo-500/60 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3.5 py-1.5 text-xs font-medium transition-all outline-none cursor-pointer [color-scheme:dark]">
            </form>
        </div>

        <!-- Listado actual -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Columna 1: General -->
            <section class="bg-slate-900/75 backdrop-blur-md border border-amber-500/30 p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.6)]"></span>
                        <h3 class="font-bold text-base tracking-wide text-amber-400">INFORMACIÓN GENERAL</h3>
                    </div>
                    <span class="text-[11px] text-slate-500">Clic para editar</span>
                </div>

                <div class="space-y-3">
                    @forelse($generales as $item)
                        <div onclick="abrirModalEditar(this)"
                             data-id="{{ $item->id }}"
                             data-titulo="{{ $item->titulo }}"
                             data-contenido="{{ $item->contenido }}"
                             data-tipo="general"
                             data-fecha=""
                             title="Haz clic para editar"
                             class="group cursor-pointer bg-slate-950/70 hover:bg-slate-900/90 border border-slate-800/80 hover:border-amber-500/40 p-4 rounded-xl border-l-4 border-l-amber-400 flex justify-between items-start gap-3 transition-all duration-200 shadow-md">
                            <div class="min-w-0 flex-1">
                                @if($item->titulo)
                                    <p class="font-bold text-amber-300 group-hover:text-amber-200 text-base mb-1 transition-colors">{{ $item->titulo }}</p>
                                @endif
                                <p class="text-sm text-slate-200 whitespace-pre-line leading-relaxed">{{ $item->contenido }}</p>
                            </div>
                            <form action="{{ route('tablero.eliminar', $item->id) }}" method="POST" onclick="event.stopPropagation()" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/25 hover:border-red-500/50 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 cursor-pointer">
                                    <span>Eliminar</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-500">
                            <p class="text-sm italic">No hay información general registrada.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Columna 2: Por Fecha -->
            <section class="bg-slate-900/75 backdrop-blur-md border border-indigo-500/30 p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(129,140,248,0.6)]"></span>
                        <h3 class="font-bold text-base tracking-wide text-indigo-400">POR FECHA</h3>
                    </div>
                    <span class="text-xs font-mono text-indigo-300/80">{{ $fechaSeleccionada }}</span>
                </div>

                <div class="space-y-3">
                    @forelse($porFecha as $item)
                        <div onclick="abrirModalEditar(this)"
                             data-id="{{ $item->id }}"
                             data-titulo="{{ $item->titulo }}"
                             data-contenido="{{ $item->contenido }}"
                             data-tipo="fecha"
                             data-fecha="{{ $item->fecha }}"
                             title="Haz clic para editar"
                             class="group cursor-pointer bg-slate-950/70 hover:bg-slate-900/90 border border-slate-800/80 hover:border-indigo-500/40 p-4 rounded-xl border-l-4 border-l-indigo-400 flex justify-between items-start gap-3 transition-all duration-200 shadow-md">
                            <div class="min-w-0 flex-1">
                                @if($item->titulo)
                                    <p class="font-bold text-indigo-300 group-hover:text-indigo-200 text-base mb-1 transition-colors">{{ $item->titulo }}</p>
                                @endif
                                <p class="text-sm text-slate-200 whitespace-pre-line leading-relaxed">{{ $item->contenido }}</p>
                            </div>
                            <form action="{{ route('tablero.eliminar', $item->id) }}" method="POST" onclick="event.stopPropagation()" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/25 hover:border-red-500/50 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 cursor-pointer">
                                    <span>Eliminar</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 text-slate-500">
                            <p class="text-sm italic text-center">No hay registros para el {{ $fechaSeleccionada }}.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- Columna 3: Pruebas de Software -->
            <section class="bg-slate-900/75 backdrop-blur-md border border-emerald-500/30 p-6 rounded-2xl shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.6)]"></span>
                        <h3 class="font-bold text-base tracking-wide text-emerald-400">PRUEBAS DE SOFTWARE</h3>
                    </div>
                    <span class="text-xs font-mono text-emerald-300/80">{{ $fechaSeleccionada }}</span>
                </div>

                <div class="space-y-3">
                    @forelse($pruebasSoftware as $item)
                        <div onclick="abrirModalEditar(this)"
                             data-id="{{ $item->id }}"
                             data-titulo="{{ $item->titulo }}"
                             data-contenido="{{ $item->contenido }}"
                             data-tipo="pruebas_software"
                             data-fecha="{{ $item->fecha }}"
                             title="Haz clic para editar"
                             class="group cursor-pointer bg-slate-950/70 hover:bg-slate-900/90 border border-slate-800/80 hover:border-emerald-500/40 p-4 rounded-xl border-l-4 border-l-emerald-400 flex justify-between items-start gap-3 transition-all duration-200 shadow-md">
                            <div class="min-w-0 flex-1">
                                @if($item->titulo)
                                    <p class="font-bold text-emerald-300 group-hover:text-emerald-200 text-sm mb-1 transition-colors">
                                        Prof. {{ $item->titulo }}
                                    </p>
                                @endif
                                <p class="text-sm text-slate-200 whitespace-pre-line leading-relaxed">{{ $item->contenido }}</p>
                            </div>
                            <form action="{{ route('tablero.eliminar', $item->id) }}" method="POST" onclick="event.stopPropagation()" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 border border-red-500/25 hover:border-red-500/50 px-3 py-1.5 rounded-lg text-xs font-medium transition-all duration-200 cursor-pointer">
                                    <span>Eliminar</span>
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-10 text-slate-500">
                            <p class="text-sm italic text-center">No hay pruebas de software para el {{ $fechaSeleccionada }}.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>

    <!-- Ventana Emergente (Modal) de Edición -->
    <div id="modalEditar" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl shadow-2xl w-full max-w-xl p-6 relative">
            <div class="flex justify-between items-center border-b border-slate-800 pb-4 mb-5">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(129,140,248,0.6)]"></span>
                    <h3 class="text-lg font-bold tracking-wide text-slate-100">Editar Mensaje del Tablero</h3>
                </div>
                <button type="button" onclick="cerrarModalEditar()" class="text-slate-400 hover:text-white transition-colors p-1 rounded-lg hover:bg-slate-800 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="formEditar" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="editTipo" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                            Tipo de Información
                        </label>
                        <select name="tipo" id="editTipo" onchange="toggleCamposEditar()"
                                class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none cursor-pointer">
                            <option value="fecha">Por Fecha (Solo ese día)</option>
                            <option value="general">General (Fija / Permanente)</option>
                            <option value="pruebas_software">Prueba de Software (Por fecha)</option>
                        </select>
                    </div>

                    <div id="editCampoFecha">
                        <label for="editFecha" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                            Fecha a mostrar
                        </label>
                        <input type="date" name="fecha" id="editFecha"
                               class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none cursor-pointer [color-scheme:dark]">
                    </div>
                </div>

                <div>
                    <label id="labelTituloEditar" for="editTitulo" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                        Título
                    </label>
                    <input type="text" name="titulo" id="editTitulo" placeholder="Ej. Turno mañana / Aviso"
                           class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 placeholder-slate-500 rounded-xl px-3.5 py-2.5 text-sm transition-all outline-none">
                </div>

                <div>
                    <label for="editContenido" class="block text-xs font-medium uppercase tracking-wider text-slate-400 mb-2">
                        Contenido
                    </label>
                    <textarea name="contenido" id="editContenido" rows="4" required
                              class="w-full bg-slate-950/80 hover:bg-slate-950 border border-slate-700/80 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-3 text-sm leading-relaxed transition-all outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="cerrarModalEditar()"
                            class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium transition-colors cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 active:scale-[0.98] text-white font-semibold text-sm px-5 py-2.5 rounded-xl shadow-lg shadow-blue-600/25 border border-blue-400/30 transition-all duration-200 cursor-pointer">
                        <span>Guardar Cambios</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleCamposCrear() {
            const tipo = document.getElementById('tipoSelector').value;
            const labelTitulo = document.getElementById('labelTituloCrear');
            const inputTitulo = document.getElementById('inputTitulo');

            document.getElementById('campoFecha').style.display = (tipo === 'general') ? 'none' : 'block';

            if (tipo === 'pruebas_software') {
                labelTitulo.textContent = 'Nombre del Profesor';
                inputTitulo.placeholder = 'Ej. Ing. Carlos Mendoza';
            } else {
                labelTitulo.textContent = 'Título';
                inputTitulo.placeholder = 'Ej. Turno mañana / Aviso';
            }
        }
        toggleCamposCrear();

        const modalEditar = document.getElementById('modalEditar');
        const formEditar = document.getElementById('formEditar');
        const editTipo = document.getElementById('editTipo');
        const editFecha = document.getElementById('editFecha');
        const editCampoFecha = document.getElementById('editCampoFecha');
        const labelTituloEditar = document.getElementById('labelTituloEditar');
        const editTitulo = document.getElementById('editTitulo');
        const editContenido = document.getElementById('editContenido');

        function toggleCamposEditar() {
            editCampoFecha.style.display = (editTipo.value === 'general') ? 'none' : 'block';

            if (editTipo.value === 'pruebas_software') {
                labelTituloEditar.textContent = 'Nombre del Profesor';
                editTitulo.placeholder = 'Ej. Ing. Carlos Mendoza';
            } else {
                labelTituloEditar.textContent = 'Título';
                editTitulo.placeholder = 'Ej. Turno mañana / Aviso';
            }
        }

        function abrirModalEditar(elemento) {
            const id = elemento.dataset.id;
            formEditar.action = `{{ url('/tablero/actualizar') }}/${id}`;

            editTitulo.value = elemento.dataset.titulo || '';
            editContenido.value = elemento.dataset.contenido || '';
            editTipo.value = elemento.dataset.tipo || 'fecha';
            editFecha.value = elemento.dataset.fecha || '{{ $fechaSeleccionada }}';

            toggleCamposEditar();

            modalEditar.classList.remove('hidden');
            modalEditar.classList.add('flex');
        }

        function cerrarModalEditar() {
            modalEditar.classList.add('hidden');
            modalEditar.classList.remove('flex');
        }

        modalEditar.addEventListener('click', (e) => {
            if (e.target === modalEditar) cerrarModalEditar();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modalEditar.classList.contains('hidden')) {
                cerrarModalEditar();
            }
        });
    </script>
</body>
</html>