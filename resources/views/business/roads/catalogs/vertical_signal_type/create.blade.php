@permission('create.vertical_signal_type.inventory_roads_catalogs')

<div id="myModal" class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-road"></i> {{ trans('signal_vertical.labels.new_vertical_signal_type') }}
        </h4>
    </div>

    <div class="mt-5">
        <form role="form" action="{{ route('store.create.vertical_signal_type.inventory_roads_catalogs') }}" method="post"
              class="form-horizontal form-label-left" id="vertical_signal_type_create_fm" novalidate>

            @csrf

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="codigo">
                    {{ trans('signal_vertical.labels.code') }} <span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="codigo" id="codigo" maxlength="3" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">
                    {{ trans('signal_vertical.labels.description') }} <span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="descripcion" id="descripcion" maxlength="50" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-info" data-dismiss="modal"><i class="fa fa-times"></i> {{ trans('app.labels.cancel') }}</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{ trans('app.labels.save') }}</button>
            </div>

        </form>
    </div>
</div>

<script>
    $(() => {

        let $form = $('#vertical_signal_type_create_fm');

        $validateDefaults.rules = {
            codigo: {
                required: true
            },
            descripcion: {
                required: true,
                remote: {
                    url: "{!! route('checkuniquefield') !!}",
                    async: false,
                    data: {
                        fieldName: 'descripcion',
                        fieldValue: () => {
                            return $('#descripcion').val();
                        },
                        model: 'App\\Models\\Business\\Roads\\Catalogs\\VerticalSignalType',
                    }
                }
            }
        };

        $validateDefaults.messages = {
            descripcion: {
                remote: '{{ trans('signal_vertical.messages.validations.vertical_signal_type') }}'
            }
        };

        $form.validate($.extend(false, $validateDefaults));

        let datatable = $('#vertical_signal_type_tb').DataTable();

        $form.ajaxForm($.extend(false, $formAjaxDefaults, {
            success: (response) => {
                processResponse(response, null, () => {
                    $validateDefaults.rules = {};
                    $validateDefaults.messages = {};
                    $modal_st.modal('hide');
                    datatable.draw();
                });
            }
        }));
    });
</script>

@else
    @include('errors.403')
    @endpermission