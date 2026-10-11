<?php

/*
|--------------------------------------------------------------------------
| Datos comerciales de ALANDESA
|--------------------------------------------------------------------------
|
| Única fuente de los datos que usa la landing (resources/views/welcome.blade.php).
| Para agregar, quitar o editar un queso basta con modificar el arreglo
| "productos". Las imágenes viven en public/images/.
|
| Fuente de los datos actuales: afiche publicitario "Queso Artesanal" de la marca.
|
*/

return [

    // Número de WhatsApp en formato internacional, solo dígitos (57 = Colombia).
    'whatsapp' => env('ALANDESA_WHATSAPP', '573151792914'),

    // Cómo se muestra el número a los visitantes.
    'telefono_visible' => '315 179 29 14',

    'eslogan' => 'Lácteos de origen',

    'mensaje_general' => 'Hola, ALANDESA. Quiero hacer un pedido de queso. ¿Me pueden compartir información sobre disponibilidad y entrega?',

    // {producto} se reemplaza por el nombre de cada queso.
    'mensaje_producto' => 'Hola, ALANDESA. Estoy interesado en realizar un pedido del {producto}. ¿Podrían compartirme información sobre su disponibilidad, presentaciones y precio?',

    'productos' => [
        [
            'nombre' => 'Queso semi',
            'etiqueta' => 'Para el día a día',
            'descripcion' => 'Firme, suave y fácil de tajar. El compañero de las arepas, los sánduches y el desayuno de todos los días.',
            'imagen' => 'images/queso-semi-costeno.webp',
            'alt' => 'Bloque de queso semi ALANDESA empacado al vacío sobre una mesa de madera',
            'precio' => null,      // null si no hay precio confirmado
            'unidad' => 'la libra',
        ],
        [
            'nombre' => 'Queso costeño',
            'etiqueta' => 'Clásico de la costa',
            'descripcion' => 'El sabor salado de siempre. Rallado sobre patacones, bollos y arepas, o en tajadas junto a un buen café.',
            'imagen' => 'images/queso.webp',
            'alt' => 'Bloque de queso costeño ALANDESA',
            'recorte' => false, // false = muestra la imagen completa (para PNG con fondo transparente)
            'precio' => null ,
            'unidad' => 'la libra',
        ],
    ],

];
