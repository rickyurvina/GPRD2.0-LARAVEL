@permission('index.support_services.inventory_roads_catalogs')

<div>
    <div class="page-title">
        <div class="col-md-11 col-sm-11 col-xs-11">
            <h3>{{ trans('app.labels.catalogs') }}</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        <i class="fa fa-road"></i> {{ trans('social_information.labels.support_services') }}
                    </h2>

                    @permission('create.support_services.inventory_roads_catalogs')
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a href="{{ route('create.support_services.inventory_roads_catalogs') }}" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-plus"></i> {{ trans('social_information.labels.create_support_services') }}
                            </a>
                        </li>
                    </ul>
                    @endpermission

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped text-center" id="support_services_tb">
                        <thead>
                        <tr>
                            <th>{{ trans('social_information.labels.code') }}</th>
                            <th>{{ trans('social_information.labels.service') }}</th>
                            <th>{{ trans('social_information.labels.number') }}</th>
                            <th>{{ trans('social_information.labels.lat') }}</th>
                            <th>{{ trans('social_information.labels.longi') }}</th>
                            <th>{{ trans('social_information.labels.gid') }}</th>
                            <th>{{ trans('social_information.labels.imagen') }}</th>
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
        let $table = $('#support_services_tb');
        build_datatable($table, {
            ajax: '{!! route('data.index.support_services.inventory_roads_catalogs') !!}',
            columns: [
                {data: 'id', width: '10%', sortable: true, searchable: true},
                {data: 'servicio', width: '20%', sortable: true, searchable: true},
                {data: 'numero', width: '10%', sortable: true, searchable: true},
                {data: 'lat', width: '15%', sortable: false, searchable: false},
                {data: 'longi', width: '15%', sortable: false, searchable: false},
                {data: 'gid', width: '15%', sortable: true, searchable: true},
                {data: 'imagen', width: '15%', sortable: false, searchable: false}
            ]
        });

    });
</script>

@else
    @include('errors.403')
    @endpermission
