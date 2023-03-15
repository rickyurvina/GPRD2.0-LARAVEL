@permission('index.productive_sector.inventory_roads_catalogs')

<div>
    <div class="page-title">
        <div class="title_left">
            <h3>{{ trans('app.labels.catalogs') }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-road"></i> {{ trans('production.labels.productive_sector') }}
                    </h2>

                    @permission('create.productive_sector.inventory_roads_catalogs')
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a href="{{ route('create.productive_sector.inventory_roads_catalogs') }}" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-plus"></i> {{ trans('production.labels.create_productive_sector') }}
                            </a>
                        </li>
                    </ul>
                    @endpermission

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped text-center" id="productive_sector_tb">
                        <thead>
                        <tr>
                            <th>{{ trans('production.labels.code') }}</th>
                            <th>{{ trans('production.labels.description') }}</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        let $table = $('#productive_sector_tb');
        build_datatable($table, {
            ajax: '{!! route('data.index.productive_sector.inventory_roads_catalogs') !!}',
            columns: [
                {data: 'codigo', width: '50%', sortable: true, searchable: true},
                {data: 'descrip', width: '50%', sortable: true, searchable: true}
            ]
        });

    });
</script>

@else
    @include('errors.403')
    @endpermission