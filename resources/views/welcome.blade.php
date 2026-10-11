@php
    // Todos los datos comerciales se editan en config/alandesa.php
    $marca = config('alandesa');
    $whatsapp = fn (string $mensaje) => 'https://wa.me/'.$marca['whatsapp'].'?text='.rawurlencode($mensaje);
    $whatsappGeneral = $whatsapp($marca['mensaje_general']);
    $precio = fn (int $valor) => '$'.number_format($valor, 0, ',', '.');
    $productos = $marca['productos'];
    $precioDesde = collect($productos)->pluck('precio')->filter()->min();
@endphp
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>document.documentElement.classList.add('js')</script>

        <title>ALANDESA · Queso semi y costeño | Lácteos de origen</title>
        <meta name="description" content="ALANDESA, lácteos de origen. Queso semi y queso costeño{{ $precioDesde ? ' a '.$precio($precioDesde).' la libra' : '' }}. Haz tu pedido directo por WhatsApp.">
        <meta name="theme-color" content="#152d5b">
        <link rel="canonical" href="{{ url('/') }}">

        <meta property="og:type" content="website">
        <meta property="og:locale" content="es_CO">
        <meta property="og:site_name" content="ALANDESA">
        <meta property="og:title" content="ALANDESA · Frescura y sabor en cada bocado">
        <meta property="og:description" content="Queso semi y queso costeño. Pide por libra directamente por WhatsApp.">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:image" content="{{ asset('images/queso-semi-costeno.webp') }}">

        <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden font-sans">
        <a href="#contenido" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-marino focus:px-5 focus:py-3 focus:text-crema">Saltar al contenido</a>

        {{-- Íconos reutilizables --}}
        <svg width="0" height="0" class="absolute" aria-hidden="true">
            <symbol id="i-whatsapp" viewBox="0 0 24 24"><path fill="currentColor" d="M12.04 2a9.9 9.9 0 0 0-8.5 14.98L2 22l5.16-1.5A9.93 9.93 0 1 0 12.04 2Zm0 18.1a8.2 8.2 0 0 1-4.2-1.16l-.3-.18-3.06.89.9-2.98-.2-.31a8.17 8.17 0 1 1 6.86 3.74Zm4.5-6.12c-.25-.12-1.46-.72-1.69-.8-.23-.09-.39-.13-.55.12-.17.25-.64.8-.78.96-.15.17-.29.19-.54.06a6.7 6.7 0 0 1-3.3-2.88c-.25-.43.25-.4.71-1.33a.45.45 0 0 0-.02-.42c-.06-.12-.55-1.33-.76-1.82-.2-.48-.4-.41-.55-.42h-.47a.9.9 0 0 0-.65.3 2.74 2.74 0 0 0-.86 2.04 4.76 4.76 0 0 0 1 2.53 10.9 10.9 0 0 0 4.17 3.69c1.55.67 2.16.73 2.94.61.47-.07 1.46-.6 1.66-1.18.21-.57.21-1.07.15-1.17-.06-.11-.22-.17-.47-.29Z"/></symbol>
            <symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14m-6-6 6 6-6 6" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></symbol>
            <symbol id="i-leaf" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 19c0-8 5-13 14-14 0 9-5 14-13 14"/><path d="M5 19c3-4 6-7 10-9"/></g></symbol>
            <symbol id="i-cheese" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"><path d="M3 15.5 14 7l7 3.5v8.5H3z"/><path d="M3 15.5h18"/><circle cx="8" cy="17.3" r=".9"/><circle cx="15.5" cy="12.6" r="1.1"/><circle cx="17.5" cy="17" r=".7"/></g></symbol>
            <symbol id="i-shield" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 5 6v5.5c0 4.4 3 8 7 9.5 4-1.5 7-5.1 7-9.5V6z"/><path d="m9 12 2.2 2.2L15.5 10"/></g></symbol>
            <symbol id="i-chat" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12a8 8 0 0 1-11.8 7L4 20l1.1-3.9A8 8 0 1 1 20 12z"/><path d="M9 11h6M9 14h4"/></g></symbol>
            <symbol id="i-scale" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14l-1.5 12h-11z"/><path d="M9 8a3 3 0 0 1 6 0"/><path d="M12 12v4"/></g></symbol>
       </svg>

        {{-- ================= NAVEGACIÓN ================= --}}
        <header class="nav-shell fixed inset-x-0 top-0 z-50" data-nav>
            <nav class="mx-auto flex max-w-7xl items-center justify-between gap-6 px-5 py-4 sm:px-8" aria-label="Principal">
                <a href="#inicio" class="group flex items-center gap-3" aria-label="ALANDESA, ir al inicio">
                    <img src="{{ asset('images/logo-alandesa.webp') }}" alt="" width="480" height="351" class="h-12 w-auto transition-transform duration-500 group-hover:-translate-y-0.5">
                    <span class="leading-none">
                        <span class="block font-display text-2xl font-semibold tracking-tight">Alandesa</span>
                        <span class="mt-1 block text-[0.6rem] font-semibold uppercase tracking-[0.28em] text-tierra">{{ $marca['eslogan'] }}</span>
                    </span>
                </a>

                <ul class="hidden items-center gap-9 text-[0.95rem] font-medium lg:flex">
                    <li><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li><a class="nav-link" href="#quesos">Nuestros quesos</a></li>
                    <li><a class="nav-link" href="#nosotros">Nosotros</a></li>
                    <li><a class="nav-link" href="#contacto">Contacto</a></li>
                </ul>

                <div class="flex items-center gap-3">
                    <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="btn btn-primario hidden !min-h-11 !px-5 !py-2.5 text-sm sm:inline-flex">
                        <svg class="size-5" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                        Pedir por WhatsApp
                    </a>
                    <button type="button" class="grid size-11 place-items-center rounded-full border border-marino/20 lg:hidden" data-menu-toggle aria-expanded="false" aria-controls="menu-movil" aria-label="Abrir menú">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M4 8h16M4 16h16"/></svg>
                    </button>
                </div>
            </nav>

            <div id="menu-movil" class="menu-movil absolute inset-x-3 top-full rounded-3xl bg-crema p-6 shadow-[0_30px_60px_-30px_rgb(21_45_91/0.5)] ring-1 ring-marino/10 lg:hidden" data-menu data-open="false">
                <ul class="grid gap-1 font-display text-3xl">
                    <li><a class="block py-2" href="#inicio">Inicio</a></li>
                    <li><a class="block py-2" href="#quesos">Nuestros quesos</a></li>
                    <li><a class="block py-2" href="#nosotros">Nosotros</a></li>
                    <li><a class="block py-2" href="#contacto">Contacto</a></li>
                </ul>
                <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="btn btn-primario mt-6 w-full">
                    <svg class="size-5" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                    Pedir por WhatsApp
                </a>
            </div>
        </header>

        <main id="contenido">
            {{-- ================= HERO ================= --}}
            <section id="inicio" class="relative isolate flex min-h-[100svh] flex-col overflow-hidden pt-28 lg:pt-24">
                {{-- Trazos de nubes, como en el afiche --}}
                <svg class="absolute left-[-2rem] top-32 -z-10 hidden w-64 text-marino/25 md:block" viewBox="0 0 260 40" aria-hidden="true"><path class="trazo" d="M2 30h70c6-14 26-14 32-2 8-8 22-6 26 2h110M30 38h120"/></svg>
                <svg class="absolute right-[-1rem] top-44 -z-10 hidden w-56 text-marino/25 md:block" viewBox="0 0 260 40" aria-hidden="true"><path class="trazo" d="M258 26h-80c-6-12-24-12-30 0-8-6-20-4-24 2H10M120 36h110"/></svg>

                <div class="mx-auto grid w-full max-w-7xl flex-1 items-center gap-10 px-5 sm:px-8 lg:grid-cols-12 lg:gap-6">
                    <div class="lg:col-span-7">
                        <p class="eyebrow text-tierra" data-reveal>Queso artesanal · {{ $marca['eslogan'] }}</p>
                        <h1 class="mt-6 font-display text-[clamp(3rem,8.5vw,6.6rem)] leading-[0.92] font-semibold tracking-[-0.02em]" data-reveal style="--delay: 80ms">
                            Frescura y sabor<br>
                            <em class="font-normal text-tierra">en cada bocado.</em>
                        </h1>
                        <p class="mt-7 max-w-xl text-lg leading-relaxed text-marino/80 sm:text-xl" data-reveal style="--delay: 160ms">
                            Queso semi y queso costeño{{ $precioDesde ? ' a '.$precio($precioDesde).' la libra' : '' }}. Escoge el tuyo y haz tu pedido directamente por WhatsApp.
                        </p>
                        <div class="mt-10 flex flex-wrap items-center gap-3 sm:gap-4" data-reveal style="--delay: 240ms">
                            <a href="#quesos" class="btn btn-primario">
                                Ver nuestros quesos
                                <svg class="size-5" aria-hidden="true"><use href="#i-arrow"/></svg>
                            </a>
                            <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="btn btn-contorno">
                                <svg class="size-5" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                                Pedir por WhatsApp
                            </a>
                        </div>
                    </div>

                    <div class="relative mx-auto w-full max-w-[22rem] sm:max-w-md lg:col-span-5 lg:max-w-none">
                        {{-- Sello que gira con el scroll --}}
                        <svg class="sello absolute -inset-[6%] -z-10 text-marino/70" viewBox="0 0 200 200" data-sello aria-hidden="true">
                            <defs><path id="circulo" d="M100 100m-82 0a82 82 0 1 1 164 0a82 82 0 1 1-164 0"/></defs>
                            <circle cx="100" cy="100" r="70" fill="var(--color-mantequilla)" opacity=".75"/>
                            <circle cx="100" cy="100" r="94" fill="none" stroke="currentColor" stroke-width=".6" stroke-dasharray="2 4"/>
                            <text font-size="9.4" letter-spacing="3.4" fill="currentColor" font-weight="600"><textPath href="#circulo">LÁCTEOS DE ORIGEN · QUESO SEMI · QUESO COSTEÑO · ALANDESA ·</textPath></text>
                        </svg>
                        <div class="cheese-anchor" data-cheese-anchor data-rx="4" data-ry="-12" data-rz="-5" data-scale=".95">
                            <img class="cheese-fallback" src="{{ asset('images/queso.webp') }}" width="900" height="649" alt="Bloque de queso ALANDESA">
                        </div>
                    </div>
                </div>

                {{-- Paisaje ilustrado extraído del afiche de la marca --}}
                <div class="paisaje relative -z-10 -mt-6 sm:-mt-16 lg:-mt-36" aria-hidden="true">
                    <img src="{{ asset('images/paisaje-ilustrado.png') }}" alt="" width="922" height="290" class="ml-auto w-[150%] max-w-none sm:w-[min(100%,1180px)]" decoding="async">
                </div>
            </section>

            {{-- ================= CINTA ================= --}}
            <div class="overflow-hidden bg-marino py-5 text-crema" aria-hidden="true">
                <div class="cinta">
                    @for ($i = 0; $i < 2; $i++)
                        <div class="flex shrink-0 items-center font-display text-2xl italic sm:text-3xl">
                            @foreach (['Queso semi', 'Queso costeño', 'Venta por libra', 'Pedidos por WhatsApp', 'Frescura y sabor', $marca['eslogan']] as $item)
                                <span class="px-8">{{ $item }}</span>
                                <span class="size-3 shrink-0 rounded-full bg-mantequilla"></span>
                            @endforeach
                        </div>
                    @endfor
                </div>
            </div>

            {{-- ================= NOSOTROS ================= --}}
            <section id="nosotros" class="relative py-24 sm:py-32">
                <div class="mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-12 lg:gap-10">
                    <div class="relative mx-auto w-full max-w-[20rem] sm:max-w-sm lg:col-span-5 lg:max-w-none">
                        <div class="absolute inset-[4%] -z-10 rounded-[45%_55%_52%_48%/55%_45%_55%_45%] bg-durazno/80"></div>
                        <div class="absolute -right-2 top-4 -z-10 size-16 rounded-full bg-cielo sm:size-20"></div>
                        <div class="absolute bottom-8 left-2 -z-10 size-8 rounded-full bg-salvia"></div>
                        <div class="cheese-anchor" data-cheese-anchor data-rx="-4" data-ry="14" data-rz="6" data-scale=".95"></div>
                    </div>

                    <div class="lg:col-span-6 lg:col-start-7">
                        <p class="eyebrow text-tierra" data-reveal>Nosotros</p>
                        <h2 class="mt-5 font-display text-[clamp(2.4rem,5vw,4rem)] leading-[1.02] font-semibold tracking-tight" data-reveal style="--delay: 80ms">
                            Lácteos de origen, <em class="font-normal text-tierra">para la mesa de todos los días.</em>
                        </h2>
                        {{-- Textos neutrales: reemplazar con la historia real de la marca (origen, región, familia, finca). --}}
                        <div class="mt-8 space-y-5 text-lg leading-relaxed text-marino/80" data-reveal style="--delay: 160ms">
                            <p>En ALANDESA creemos que un buen queso no necesita complicaciones: frescura, buen sabor y una atención cercana desde el primer mensaje.</p>
                            <p>Por eso lo hacemos simple. Eliges tu queso, nos escribes por WhatsApp y coordinamos tu pedido directamente contigo.</p>
                        </div>

                        <dl class="mt-12 grid grid-cols-3 divide-x divide-marino/15 border-y border-marino/15" data-reveal style="--delay: 240ms">
                            <div class="py-5 pr-3">
                                <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-tierra">Variedades</dt>
                                <dd class="mt-2 font-display text-3xl font-semibold sm:text-4xl">{{ count($productos) }}</dd>
                            </div>
                            <div class="px-3 py-5 sm:px-5">
                                <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-tierra">Venta</dt>
                                <dd class="mt-2 font-display text-3xl font-semibold sm:text-4xl">Por libra</dd>
                            </div>
                            <div class="py-5 pl-3 sm:pl-5">
                                <dt class="text-xs font-semibold uppercase tracking-[0.18em] text-tierra">Pedidos</dt>
                                <dd class="mt-2 font-display text-3xl font-semibold sm:text-4xl">Directos</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </section>

            {{-- ================= CATÁLOGO ================= --}}
            <section id="quesos" class="relative bg-white/60 py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-5 sm:px-8">
                    <div class="grid items-end gap-8 md:grid-cols-12">
                        <div class="md:col-span-8">
                            <p class="eyebrow text-tierra" data-reveal>Nuestros quesos</p>
                            <h2 class="mt-5 font-display text-[clamp(2.6rem,6vw,5rem)] leading-[0.98] font-semibold tracking-tight" data-reveal style="--delay: 80ms">
                                Dos clásicos <em class="font-normal text-tierra">para tu mesa.</em>
                            </h2>
                            <p class="mt-6 max-w-lg text-lg leading-relaxed text-marino/75" data-reveal style="--delay: 160ms">
                                Precios por libra. Escríbenos para confirmar disponibilidad y coordinar tu pedido.
                            </p>
                        </div>
                        <div class="relative isolate hidden md:col-span-4 md:block">
                            <div class="absolute inset-[12%] -z-10 rounded-full bg-cielo/70"></div>
                            <div class="cheese-anchor mx-auto max-w-72" data-cheese-anchor data-rx="6" data-ry="-10" data-rz="-8" data-scale=".95"></div>
                        </div>
                    </div>

                    <div class="mt-16 space-y-20 sm:mt-24 sm:space-y-28">
                        @foreach ($productos as $producto)
                            @php
                                $invertido = $loop->odd === false;
                                $mensaje = str_replace('{producto}', mb_strtolower($producto['nombre']), $marca['mensaje_producto']);
                            @endphp
                            <article class="producto grid items-center gap-8 md:grid-cols-12 md:gap-12" aria-labelledby="producto-{{ $loop->index }}">
                                <div class="md:col-span-7 {{ $invertido ? 'md:order-2' : '' }}" data-reveal>
                                    @php $recortar = $producto['recorte'] ?? true; @endphp
                                    <div class="producto-foto aspect-[4/3] {{ $recortar ? 'bg-crema' : 'bg-cielo/70' }}">
                                        @unless ($recortar)
                                            <img src="{{ asset('images/paisaje-ilustrado.png') }}" alt="" class="absolute inset-x-0 bottom-0 w-full opacity-50" loading="lazy" aria-hidden="true">
                                        @endunless
                                        <img src="{{ asset($producto['imagen']) }}" alt="{{ $producto['alt'] }}" class="relative size-full {{ $recortar ? 'object-cover' : 'object-contain p-10 drop-shadow-[0_24px_24px_rgb(21_45_91/0.25)] sm:p-16' }}" loading="lazy" decoding="async">
                                        <span class="absolute left-5 top-5 rounded-full bg-crema/90 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] backdrop-blur">{{ $producto['etiqueta'] }}</span>
                                    </div>
                                </div>
                                <div class="md:col-span-5 {{ $invertido ? 'md:order-1' : '' }}" data-reveal style="--delay: 120ms">
                                    <span class="font-display text-6xl font-normal italic text-durazno sm:text-7xl" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h3 id="producto-{{ $loop->index }}" class="mt-2 font-display text-4xl font-semibold tracking-tight sm:text-5xl">{{ $producto['nombre'] }}</h3>
                                    <p class="mt-5 text-lg leading-relaxed text-marino/80">{{ $producto['descripcion'] }}</p>

                                    <div class="mt-8 flex flex-wrap items-center gap-6">
                                        @if ($producto['precio'])
                                            <p class="etiqueta-precio">
                                                <span class="font-display text-3xl font-semibold leading-none">{{ $precio($producto['precio']) }}</span>
                                                <span class="mt-1 text-[0.65rem] font-semibold uppercase tracking-[0.25em]">{{ $producto['unidad'] }}</span>
                                            </p>
                                        @else
                                            <p class="text-sm font-medium text-tierra">Consulta el precio por WhatsApp</p>
                                        @endif
                                        <a href="{{ $whatsapp($mensaje) }}" target="_blank" rel="noopener" class="btn btn-primario" aria-label="Pedir {{ mb_strtolower($producto['nombre']) }} por WhatsApp (se abre en una pestaña nueva)">
                                            <svg class="size-5" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                                            Pedir {{ mb_strtolower($producto['nombre']) }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="relative mt-24 overflow-hidden rounded-[2rem] bg-mantequilla px-7 py-10 sm:px-12 sm:py-12" data-reveal>
                        <div class="ojos pointer-events-none absolute inset-0 opacity-60 [--ojo:#f7dc86]" aria-hidden="true"></div>
                        <div class="relative flex flex-col items-start justify-between gap-6 md:flex-row md:items-center">
                            <p class="max-w-xl font-display text-2xl leading-snug sm:text-3xl">¿Buscas una cantidad especial? <em class="text-tierra">Cuéntanos qué necesitas y te respondemos.</em></p>
                            <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="btn btn-primario shrink-0">
                                <svg class="size-5" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                                Escríbenos
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ================= DIFERENCIACIÓN ================= --}}
            {{-- "100% natural", "Sabor auténtico" y "Calidad garantizada" provienen del afiche oficial de la marca. --}}
            <section class="relative overflow-hidden bg-salvia py-24 sm:py-32">
                <div class="ojos pointer-events-none absolute inset-0 opacity-40 [--ojo:#b7c4b0]" aria-hidden="true"></div>
                <div class="relative mx-auto grid max-w-7xl gap-14 px-5 sm:px-8 lg:grid-cols-12">
                    <div class="lg:col-span-5">
                        <p class="eyebrow text-marino" data-reveal>Por qué Alandesa</p>
                        <h2 class="mt-5 font-display text-[clamp(2.4rem,5vw,4.2rem)] leading-[1] font-semibold tracking-tight" data-reveal style="--delay: 80ms">
                            Lo bueno, <em class="font-normal">sin vueltas.</em>
                        </h2>
                        <div class="mt-10 hidden max-w-xs lg:block" data-reveal style="--delay: 160ms">
                            <img src="{{ asset('images/logo-alandesa.webp') }}" alt="" width="480" height="351" class="w-full opacity-90" loading="lazy" decoding="async">
                        </div>
                    </div>

                    @php
                        $atributos = [
                            ['icono' => 'i-leaf', 'titulo' => '100% natural', 'texto' => 'Queso natural, tal como lo presentamos en cada pedido.'],
                            ['icono' => 'i-cheese', 'titulo' => 'Sabor auténtico', 'texto' => 'El sabor de siempre del queso semi y del costeño.'],
                            ['icono' => 'i-shield', 'titulo' => 'Calidad garantizada', 'texto' => 'Un producto que respaldamos con nuestro nombre.'],
                            ['icono' => 'i-scale', 'titulo' => 'Venta por libra', 'texto' => 'Pides la cantidad que necesitas, ni más ni menos.'],
                            ['icono' => 'i-chat', 'titulo' => 'Pedido directo', 'texto' => 'Nos escribes por WhatsApp y coordinamos contigo.'],
                        ];
                    @endphp
                    <ul class="divide-y divide-marino/15 border-y border-marino/15 lg:col-span-7">
                        @foreach ($atributos as $atributo)
                            <li class="group grid grid-cols-[auto_1fr] items-center gap-5 py-6 sm:grid-cols-[auto_14rem_1fr] sm:gap-8" data-reveal style="--delay: {{ $loop->index * 70 }}ms">
                                <span class="grid size-14 place-items-center rounded-full border border-marino/30 bg-crema/40 transition-colors duration-300 group-hover:bg-marino group-hover:text-crema">
                                    <svg class="size-7" aria-hidden="true"><use href="#{{ $atributo['icono'] }}"/></svg>
                                </span>
                                <h3 class="font-display text-2xl font-semibold sm:text-3xl">{{ $atributo['titulo'] }}</h3>
                                <p class="col-span-2 text-marino/80 sm:col-span-1">{{ $atributo['texto'] }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>

            {{-- ================= LLAMADA A LA ACCIÓN ================= --}}
            <section id="contacto" class="relative isolate overflow-hidden bg-marino py-24 text-crema sm:py-32">
                <div class="ojos pointer-events-none absolute inset-0 -z-10 opacity-70 [--ojo:#1a3569]" aria-hidden="true"></div>
                <img src="{{ asset('images/paisaje-ilustrado-claro.png') }}" alt="" width="922" height="290" class="pointer-events-none absolute right-0 bottom-0 -z-10 w-[160%] max-w-none opacity-20 sm:w-[min(100%,1100px)]" loading="lazy" aria-hidden="true">
                <div class="mx-auto grid max-w-7xl items-center gap-14 px-5 sm:px-8 lg:grid-cols-12">
                    <div class="lg:col-span-7">
                        <p class="eyebrow text-mantequilla" data-reveal>Haz tu pedido</p>
                        <h2 class="mt-5 font-display text-[clamp(2.6rem,6.4vw,5.4rem)] leading-[0.98] font-semibold tracking-tight" data-reveal style="--delay: 80ms">
                            ¿Se te antojó?<br>
                            <em class="font-normal text-durazno">Tu queso está a un mensaje.</em>
                        </h2>
                        <p class="mt-7 max-w-lg text-lg leading-relaxed text-crema/80" data-reveal style="--delay: 160ms">
                            Dinos qué queso quieres y cuántas libras. Te confirmamos disponibilidad y coordinamos la entrega por WhatsApp.
                        </p>
                        <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-5" data-reveal style="--delay: 240ms">
                            <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="btn btn-mantequilla text-lg">
                                <svg class="size-6" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                                Hacer mi pedido
                            </a>
                            <p class="text-crema/80">
                                <span class="block text-xs font-semibold uppercase tracking-[0.2em] text-crema/60">WhatsApp</span>
                                <span class="font-display text-2xl text-crema">{{ $marca['telefono_visible'] }}</span>
                            </p>
                        </div>
                    </div>

                    @if ($precioDesde)
                        <div class="flex justify-center lg:col-span-5" data-reveal style="--delay: 200ms">
                            <div class="relative w-full max-w-sm -rotate-3 rounded-[1.25rem] border-2 border-mantequilla p-2 transition-transform duration-700 hover:rotate-0">
                                <div class="rounded-xl border border-mantequilla/60 px-8 py-10 text-center">
                                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-mantequilla">Queso semi y costeño</p>
                                    <p class="mt-4 font-display text-6xl font-semibold leading-none sm:text-7xl">{{ $precio($precioDesde) }}</p>
                                    <p class="mt-3 text-sm font-semibold uppercase tracking-[0.3em] text-crema/80">La libra</p>
                                </div>
                                <span class="absolute -right-5 -top-5 grid size-16 rotate-12 place-items-center rounded-full bg-durazno text-marino" aria-hidden="true">
                                    <svg class="size-8"><use href="#i-cheese"/></svg>
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </main>

        {{-- ================= FOOTER ================= --}}
        <footer class="relative bg-marino-hondo pt-16 pb-10 text-crema/80">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="grid gap-12 border-b border-crema/10 pb-12 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <a href="#inicio" class="inline-flex items-center gap-3 text-crema" aria-label="ALANDESA, ir al inicio">
                            <img src="{{ asset('images/logo-alandesa-claro.webp') }}" alt="" width="480" height="351" class="h-14 w-auto" loading="lazy">
                            <span class="font-display text-3xl font-semibold">Alandesa</span>
                        </a>
                        <p class="mt-4 max-w-xs">{{ $marca['eslogan'] }}. Frescura y sabor en cada bocado.</p>
                    </div>
                    <nav class="md:col-span-3" aria-label="Secundaria">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-crema/50">Navegación</p>
                        <ul class="mt-4 space-y-2">
                            <li><a class="nav-link hover:text-crema" href="#inicio">Inicio</a></li>
                            <li><a class="nav-link hover:text-crema" href="#quesos">Nuestros quesos</a></li>
                            <li><a class="nav-link hover:text-crema" href="#nosotros">Nosotros</a></li>
                            <li><a class="nav-link hover:text-crema" href="#contacto">Contacto</a></li>
                        </ul>
                    </nav>
                    <div class="md:col-span-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-crema/50">Pedidos</p>
                        <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-3 text-crema transition-colors hover:text-mantequilla">
                            <svg class="size-6" aria-hidden="true"><use href="#i-whatsapp"/></svg>
                            <span class="font-display text-2xl">{{ $marca['telefono_visible'] }}</span>
                        </a>
                        <p class="mt-2 text-sm">Escríbenos por WhatsApp.</p>
                    </div>
                </div>
                <p class="pt-8 text-sm text-crema/60">© {{ date('Y') }} ALANDESA. Todos los derechos reservados.</p>
            </div>
        </footer>

        {{-- Botón flotante de pedido en móviles --}}
        <a href="{{ $whatsappGeneral }}" target="_blank" rel="noopener" class="fixed right-4 bottom-4 z-40 grid size-14 place-items-center rounded-full bg-marino text-crema shadow-[0_14px_30px_-12px_rgb(21_45_91/0.8)] ring-2 ring-crema sm:hidden" aria-label="Pedir por WhatsApp">
            <svg class="size-7" aria-hidden="true"><use href="#i-whatsapp"/></svg>
        </a>

        {{-- Queso (PNG real) que recorre la página sincronizado con el scroll --}}
        <div class="cheese-stage" data-cheese-stage aria-hidden="true">
            <div class="cheese">
                <div class="cheese-shadow"></div>
                <div class="cheese-float">
                    <img class="cheese-block" src="{{ asset('images/queso.webp') }}" alt="" width="900" height="649" decoding="async">
                </div>
            </div>
        </div>
    </body>
</html>
