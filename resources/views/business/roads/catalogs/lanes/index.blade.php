@permission('index.lanes.inventory_roads_catalogs')

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
                        <i class="fa fa-road"></i> {{ trans('characteristics_of_track.labels.carriles') }}
                    </h2>

                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <table class="table table-striped text-center" id="lanes_tb">
                        <thead>
                        <tr>
                            <th>{{ trans('characteristics_of_track.labels.code') }}</th>
                            <th>{{ trans('characteristics_of_track.labels.description') }}</th>
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
        let $table = $('#lanes_tb');
        build_datatable($table, {
            ajax: '{!! route('data.index.lanes.inventory_roads_catalogs') !!}',
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