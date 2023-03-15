@permission('index.population_type.inventory_roads_catalogs')

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
                        <i class="fa fa-road"></i> {{ trans('social_information.labels.tipopob') }}
                    </h2>

                    @permission('create.population_type.inventory_roads_catalogs')
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a href="{{ route('create.population_type.inventory_roads_catalogs') }}" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-plus"></i> {{ trans('social_information.labels.create_population_type') }}
                            </a>
                        </li>
                    </ul>
                    @endpermission

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped text-center" id="population_type_tb">
                        <thead>
                        <tr>
                            <th>{{ trans('social_information.labels.code') }}</th>
                            <th>{{ trans('social_information.labels.description') }}</th>
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
        let $table = $('#population_type_tb');
        build_datatable($table, {
            ajax: '{!! route('data.index.population_type.inventory_roads_catalogs') !!}',
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