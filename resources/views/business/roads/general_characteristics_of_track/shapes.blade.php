@if(count($shapes) || count($shapesDefault))
    <!-- shapes estilos -->
    <link href="{{ mix('vendor/shapes/page.css') }}" rel="stylesheet"/>

    <!-- vista del complemento visor de Shapes -->
    <div class="hidden">
        <svg version="1.1" id="home-icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px"
             y="0px" width="14px" height="19px" viewBox="0 0 14 16">
            <g>
                <polygon points="13,7 13,6 12,6 12,5 11,5 11,4 10,4 10,3 9,3 9,2 8,2 8,1 6,1 6,2 5,2 5,3 4,3 4,4 3,4 3,5 2,5
                2,6 1,6 1,7 0,7 0,9 2,9 2,14 6,14 6,10 8,10 8,14 12,14 12,9 14,9 14,7"/>
            </g>
        </svg>
        <svg version="1.1" id="zoom-in-icon" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
             y="0px" width="14px" height="21px" viewBox="0 0 14 14">
            <g>
                <polygon points="13,5 9,5 9,1 5,1 5,5 1,5 1,9 5,9 5,13 9,13 9,9 13,9"/>
            </g>
        </svg>
        <svg version="1.1" id="zoom-out-icon" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink"
             x="0px" y="0px" width="14px" height="16px" viewBox="0 -1 14 10">
            <g>
                <polygon points="1,1 13,1 13,5 1,5 1,1"/>
            </g>
        </svg>
        <svg version="1.1" id="info-icon2"
             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="13px"
             height="18px" viewBox="-510 390 13 18" xml:space="preserve">
            <circle fill="#30D4EF" cx="-503.4" cy="392.8" r="2.7"/>
            <rect x="-508" y="405" fill="#30D4EF" width="10" height="3"/>
            <rect x="-507" y="398" fill="#30D4EF" width="6" height="3"/>
            <rect x="-505" y="400" fill="#30D4EF" width="4" height="6"/>
        </svg>
        <svg id="info-menu-icon" xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12">
            <defs>
                <style>
                    .cls-1 {
                        fill: #0c0a0a;
                    }
                </style>
            </defs>
            <g id="left_arrow">
                <polygon class="cls-1" points="0.5 6 6.5 11.5 6.5 0.5 0.5 6"/>
            </g>
        </svg>
    </div>

    <!-- cabecera del visor de Shapes -->
    <div class="page-header_">
        <div class="mapshaper-logo divHidden"><span class="logo-highlight"></span></div>
        <div class="layer-control-btn"><span class="btn header-btn layer-name font_color_white"></span></div>
        <div class="simplify-control-wrapper divHidden">
            <div class="simplify-control div_hidden">
                <div class="header-btn btn simplify-settings-btn "></div>
                <div class="slider">
                    <div class="handle">
                        <img src="{{ mix('vendor/shapes/images/slider_handle_v1.png') }}"/>
                    </div>
                    <div class="track"></div>
                </div>
                <input type="text" value="label" class="clicktext"/>
            </div>
        </div>
        <div id="mode-buttons" class="page-header_-buttons">
            <span class="simplify-btn header-btn btn div_hidden"></span>
            <span class="separator div_hidden"></span>
            <span class="console-btn header-btn btn div_hidden"></span>
            <span class="separator div_hidden"></span>
            <span class="export-btn header-btn btn div_hidden"></span>
        </div>
        <div id="splash-buttons" class="page-header_-buttons div_hidden">
            <a>
                <span id="wiki-btn" class="header-btn btn div_hidden"></span>
            </a>
            <span class="separator div_hidden"></span>
            <a>
                <span id="github-btn" class="header-btn btn div_hidden"></span>
            </a>
        </div>
    </div>

    <!-- barra de opciones -->
    <div class="layer-control main-area popup-dialog divHidden">
        <div class="info-box margin_top_30">
            <div class="info-box-scrolled">
                <div class="layer-menu width_111">
                    <h3 class="align-center">{{ trans('shape.labels.list') }}</h3>
                    <div class="pin-all pinnable">
                        <img class="pin-btn unpinned" src="{{ mix('vendor/shapes/images/eye.png') }}">
                        <img class="pin-btn pinned" src="{{ mix('vendor/shapes/images/eye2.png') }}">
                    </div>
                    <div class="layer-list"></div>
                    <div class="divHidden">
                        <div id="add-file-btn" class="dialog-btn btn"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pantalla de selección de archivo(s) -->
    <div id="splash-screen" class="main-area divHidden">
        <div id="drop-areas" class="drop-area-wrapper main-area">
            <i class="fa fa-spinner fa-spin" style="font-size: 5em;"></i>
        </div>
        <div class="file-catalog catalog-area div_hidden"></div>
        <div class="file-catalog-spacer spacer div_hidden"></div>
        <div id="import-drop" class="drop-area div_hidden">
            <h4>
                <span class="inline-btn btn" id="file-selection-btn">
                    <span class="label-text">
                    </span>
                </span>
            </h4>
            <div class="subtitle"></div>
            <div class="subtitle"></div>
        </div>
        <div class="spacer div_hidden"></div>
        <div id="import-quick-drop" class="drop-area div_hidden">
            <div class="subtitle"></div>
        </div>
    </div>

    <!-- Opciones en la carga de archivo(s) -->
    <div id="import-options" class="main-area popup-dialog divHidden">
        <div class="info-box margin_top_30">
            <div class="dropped-file-list"></div>
            <div class="option-menu">
                <div id="path-import-options">
                    <h4></h4>
                    <div>
                        <label for="repair-intersections-opt">
                            <input type="checkbox" checked class="checkbox" id="repair-intersections-opt"/>
                        </label>
                        <div class="tip-button">
                            <div class="tip-anchor">
                                <div class="tip">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="snap-points-opt">
                            <input type="checkbox" checked class="checkbox" id="snap-points-opt"/>
                        </label>
                        <div class="tip-button">
                            <div class="tip-anchor">
                                <div class="tip">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>
                <div><input type="text" class="advanced-options" placeholder="command line options"/>
                    <div class="tip-button">
                        <div class="tip-anchor">
                            <div class="tip">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="import-buttons">
                <div class="cancel-btn btn dialog-btn"></div>
                <div class="add-btn btn dialog-btn"></div>
                <div class="submit-btn btn dialog-btn default-btn" id="import_shapes"></div>
            </div>
        </div>
    </div>

    <!-- visualizador de canvas de shapes -->
    <div id="mshp-main-page" style="height: 500px !important;">
        <div class="console main-area console-area divHidden">
            <div class="console-window">
                <div class="console-buffer selectable"></div>
            </div>
        </div>
        <div class="mshp-main-map main-area map-area">
            <div class="coordinate-info colored-text selectable"></div>
            <div class="intersection-display divHidden">
                <div class="intersection-count divHidden"></div>
                <div class="repair-btn text-btn colored-text"></div>
            </div>
            <div class="map-layers"></div>
        </div>
    </div>

    <!-- Shapes scripts -->
    <script src="{{ mix('vendor/shapes/zip.js') }}"></script>
    <script src="{{ mix('vendor/shapes/modules.js') }}"></script>
    <script src="{{ mix('vendor/shapes/mapshaper.js') }}"></script>
    @includeWhen((count($shapes) || count($shapesDefault)),'business.roads.general_characteristics_of_track.map_shaper')

@else
    {{ trans('shape.labels.not_data') }}
@endif
