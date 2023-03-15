<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Message Response Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default messages used by
    | the controller for response.
    |
    */

    'title' => 'Shapes por Provincia',
    'labels' => [
        'create' => 'Cargar Shapes',
        'update' => 'Actualizar Shape',
        'edit' => 'Editar Shape',
        'details' => 'Detalles del Shape',
        'name' => 'Shape',
        'is_primary' => 'Shape de fondo',
        'load_map' => 'Mostrar mapa'
    ],
    'messages' => [
        'confirm' => [
            'delete' => '¿Está seguro que desea eliminar el shape?',
            'status_on' => '¿Está seguro que desea poner como shape de fondo?',
            'status_off' => '¿Está seguro que desea quitar como shape de fondo?'
        ],
        'success' => [
            'created' => 'Shape(s) cargado satisfactoriamente',
            'updated' => 'Shape actualizado satisfactoriamente',
            'delete' => 'Shape eliminado satisfactoriamente'
        ],
        'errors' => [
            'create' => 'Ha ocurrido un error al intentar crear el Shape',
            'update' => 'Ha ocurrido un error al intentar actualizar el Shape',
            'delete' => 'Ha ocurrido un error al intentar eliminar el Shape',
            'max_file' => 'Solo puede subir 5 archivos a la vez',
            'size_file' => 'El tamaño maximo de subida es',
            'status_error' => 'Ya tiene registrado un shape de fondo',
            'file_extension_error' => 'El archivo seleccionado no es un Shape'
        ],
        'exceptions' => [
            'not_found' => 'El Shape no existe o no está disponible'
        ],
        'info' => [
            'is_primary' => 'Agregar shape como fondo'
        ]
    ]
];
