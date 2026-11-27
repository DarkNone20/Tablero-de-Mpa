<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablero Informativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-950 text-white min-h-screen p-3 sm:p-6 relative overflow-x-hidden">
    <!-- Resplandor ambiental sutil de fondo -->
    <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-900/20 via-slate-950 to-slate-950 -z-10"></div>

    <div class="max-w-[1600px] mx-auto">
        <!-- Barra superior fluida y adaptable -->
        <header class="relative flex flex-col xl:flex-row items-center justify-center bg-slate-900/80 backdrop-blur-md px-4 sm:px-6 py-4 rounded-2xl mb-6 border border-slate-800 shadow-xl gap-3 sm:gap-4">
            
            <!-- Título con tamaño fluido (clamp) que nunca se desborda -->
            <div class="w-full xl:px-56 text-center">
                <h1 class="text-[clamp(1.25rem,3vw,2.5rem)] leading-tight font-extrabold tracking-wider bg-gradient-to-r from-indigo-300 via-indigo-400 to-purple-400 bg-clip-text text-transparent break-words">
                    TABLERO DE INFORMACIÓN DE MPA
                </h1>
                <p class="text-[11px] sm:text-xs text-slate-400 mt-1.5 flex flex-wrap items-center justify-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                    <span>Actualización automática cada 5s</span>
                    <span class="hidden sm:inline">•</span>
                    <span>Última sync: <span id="ultimaHora" class="text-slate-300 font-mono">--:--:--</span></span>
                </p>
            </div>

            <!-- Selector de fecha: centrado debajo en móvil/tablet, fijado a la derecha en pantallas grandes -->
            <div class="xl:absolute xl:right-6 flex items-center gap-2.5 shrink-0">
                <label for="filtroFecha" class="text-xs font-medium uppercase tracking-wider text-slate-400">
                    Fecha:
                </label>
                <input type="date" id="filtroFecha" value="{{ $fechaSeleccionada }}"
                       class="bg-slate-800/90 hover:bg-slate-800 border border-slate-700 hover:border-indigo-500/60 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30 text-slate-100 rounded-xl px-3 py-1.5 sm:px-3.5 sm:py-2 text-xs sm:text-sm font-medium shadow-inner transition-all duration-200 outline-none cursor-pointer [color-scheme:dark]">
            </div>
        </header>

        <!-- Contenedor principal en 2 columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            
            <!-- Bloque 1: Información General (Fija - 1/3 de pantalla) -->
            <section class="bg-slate-900/75 backdrop-blur-md border border-amber-500/30 rounded-2xl p-4 sm:p-6 shadow-xl min-w-0">
                <div class="flex items-center gap-2.5 border-b border-slate-800 pb-3 sm:pb-4 mb-4 sm:mb-5">
                    <span class="w-3 h-3 rounded-full bg-amber-400 shadow-[0_0_10px_rgba(251,191,36,0.6)] shrink-0"></span>
                    <h2 class="text-base sm:text-lg xl:text-xl font-bold tracking-wide text-amber-400 truncate">INFORMACIÓN GENERAL</h2>
                </div>
                <div id="contenedorGeneral" class="space-y-3 sm:space-y-4">
                    <p class="text-slate-400 text-sm">Cargando...</p>
                </div>
            </section>

            <!-- Bloque 2: Información del Día Seleccionado (2/3 de pantalla) -->
            <section class="lg:col-span-2 bg-slate-900/75 backdrop-blur-md border border-indigo-500/30 rounded-2xl p-4 sm:p-6 shadow-xl flex flex-col min-w-0">
                <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-800 pb-3 sm:pb-4 mb-4 sm:mb-5">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-3 h-3 rounded-full bg-indigo-400 shadow-[0_0_10px_rgba(129,140,248,0.6)] shrink-0"></span>
                        <h2 class="text-base sm:text-lg xl:text-xl font-bold tracking-wide text-indigo-400 truncate">PROGRAMACIÓN DEL DÍA</h2>
                    </div>
                    <span id="etiquetaFecha" class="bg-indigo-950/90 border border-indigo-500/40 text-indigo-300 px-3 py-1 rounded-full text-xs sm:text-sm font-mono font-semibold shadow-sm shrink-0">
                        {{ $fechaSeleccionada }}
                    </span>
                </div>
                <div id="contenedorFecha" class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 flex-1 items-start">
                    <p class="text-slate-400 text-sm">Cargando...</p>
                </div>
            </section>

        </div>

        <!-- Bloque 3: Pruebas de Software (Oculto automáticamente cuando no hay pruebas en la fecha) -->
        <section id="seccionPruebasSoftware" class="hidden mt-4 sm:mt-6 bg-slate-900/75 backdrop-blur-md border border-emerald-500/30 rounded-2xl p-4 sm:p-6 shadow-xl min-w-0">
            <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-800 pb-3 sm:pb-4 mb-4 sm:mb-5">
                <div class="flex items-center gap-2.5 min-w-0">
                    <span class="w-3 h-3 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.6)] shrink-0"></span>
                    <h2 class="text-base sm:text-lg xl:text-xl font-bold tracking-wide text-emerald-400 truncate">PRUEBAS DE SOFTWARE</h2>
                </div>
                <span id="etiquetaFechaPruebas" class="bg-emerald-950/90 border border-emerald-500/40 text-emerald-300 px-3 py-1 rounded-full text-xs sm:text-sm font-mono font-semibold shadow-sm shrink-0">
                    {{ $fechaSeleccionada }}
                </span>
            </div>
            <div id="contenedorPruebasSoftware" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 items-start"></div>
        </section>
    </div>

    <script>
        const inputFecha = document.getElementById('filtroFecha');
        const contenedorGeneral = document.getElementById('contenedorGeneral');
        const contenedorFecha = document.getElementById('contenedorFecha');
        const seccionPruebasSoftware = document.getElementById('seccionPruebasSoftware');
        const contenedorPruebasSoftware = document.getElementById('contenedorPruebasSoftware');
        const etiquetaFecha = document.getElementById('etiquetaFecha');
        const etiquetaFechaPruebas = document.getElementById('etiquetaFechaPruebas');
        const ultimaHora = document.getElementById('ultimaHora');

        function escapeHTML(str) {
            if (!str) return '';
            return str.replace(/[&<>'"]/g, tag => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#39;', '"': '&quot;'
            }[tag]));
        }

        async function actualizarTablero() {
            const fecha = inputFecha.value;
            etiquetaFecha.textContent = fecha;
            etiquetaFechaPruebas.textContent = fecha;

            try {
                const response = await fetch(`{{ route('tablero.datos') }}?fecha=${fecha}`);
                const data = await response.json();

                ultimaHora.textContent = data.hora;

                // Renderizar Información General (no depende de la fecha)
                if (data.generales.length === 0) {
                    contenedorGeneral.innerHTML = `<p class="text-slate-500 italic text-sm text-center py-8">Sin avisos generales.</p>`;
                } else {
                    contenedorGeneral.innerHTML = data.generales.map(item => `
                        <div class="bg-slate-950/70 hover:bg-slate-950 border border-slate-800/80 p-3.5 sm:p-4 rounded-xl border-l-4 border-l-amber-400 transition-all duration-200 shadow-md overflow-hidden">
                            ${item.titulo ? `<h3 class="font-bold text-amber-300 mb-1.5 text-sm sm:text-base xl:text-lg break-words">${escapeHTML(item.titulo)}</h3>` : ''}
                            <p class="text-slate-200 whitespace-pre-line text-xs sm:text-sm xl:text-base leading-relaxed break-words">${escapeHTML(item.contenido)}</p>
                        </div>
                    `).join('');
                }

                // Renderizar Información Por Fecha (solo del día seleccionado)
                if (data.porFecha.length === 0) {
                    contenedorFecha.innerHTML = `
                        <div class="col-span-full flex flex-col items-center justify-center py-12 text-slate-500">
                            <svg class="w-12 h-12 mb-3 text-slate-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <p class="italic text-sm text-center">No hay información programada para esta fecha.</p>
                        </div>`;
                } else {
                    contenedorFecha.innerHTML = data.porFecha.map(item => `
                        <div class="bg-slate-950/70 hover:bg-slate-950 border border-slate-800/80 p-3.5 sm:p-4 rounded-xl border-l-4 border-l-indigo-400 transition-all duration-200 shadow-md overflow-hidden">
                            ${item.titulo ? `<h3 class="font-bold text-indigo-300 mb-1.5 text-sm sm:text-base xl:text-lg break-words">${escapeHTML(item.titulo)}</h3>` : ''}
                            <p class="text-slate-200 whitespace-pre-line text-xs sm:text-sm xl:text-base leading-relaxed break-words">${escapeHTML(item.contenido)}</p>
                        </div>
                    `).join('');
                }

                // Renderizar Pruebas de Software (solo se muestra si hay registros para esa fecha)
                if (!data.pruebasSoftware || data.pruebasSoftware.length === 0) {
                    seccionPruebasSoftware.classList.add('hidden');
                    contenedorPruebasSoftware.innerHTML = '';
                } else {
                    seccionPruebasSoftware.classList.remove('hidden');
                    contenedorPruebasSoftware.innerHTML = data.pruebasSoftware.map(item => `
                        <div class="bg-slate-950/70 hover:bg-slate-950 border border-slate-800/80 p-3.5 sm:p-4 rounded-xl border-l-4 border-l-emerald-400 transition-all duration-200 shadow-md overflow-hidden">
                            <p class="text-slate-200 whitespace-pre-line text-xs sm:text-sm xl:text-base leading-relaxed break-words">${escapeHTML(item.contenido)}</p>
                        </div>
                    `).join('');
                }
            } catch (error) {
                console.error('Error al actualizar el tablero:', error);
            }
        }

        // Actualizar inmediatamente si el usuario cambia el selector de fecha
        inputFecha.addEventListener('change', actualizarTablero);

        // Carga inicial y ciclo cada 5 segundos (5000 ms)
        actualizarTablero();
        setInterval(actualizarTablero, 5000);
    </script>
</body>
</html>