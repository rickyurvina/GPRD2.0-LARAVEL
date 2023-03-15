@permission('create.support_services.inventory_roads_catalogs')

<div id="myModal" class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-road"></i> {{ trans('social_information.labels.new_support_services') }}
        </h4>
    </div>

    <div class="mt-5">
        <form role="form" action="{{ route('store.create.support_services.inventory_roads_catalogs') }}" method="post"
              class="form-horizontal form-label-left" id="support_services_create_fm" novalidate>

            @csrf

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id">
                    {{ trans('social_information.labels.code') }} <span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="id" id="id" maxlength="11" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="servicio">
                    {{ trans('social_information.labels.service') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="servicio" id="servicio" maxlength="25" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="numero">
                    {{ trans('social_information.labels.number') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="numero" id="numero" maxlength="11" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lat">
                    {{ trans('social_information.labels.lat') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="lat" id="lat" maxlength="255" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="longi">
                    {{ trans('social_information.labels.longi') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="longi" id="longi" maxlength="255" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="gid">
                    {{ trans('social_information.labels.gid') }} <span class="text-danger">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="number" name="gid" id="gid" maxlength="11" autocomplete="off"
                           class="form-control col-md-7 col-sm-7 col-xs-12"/>
                </div>
            </div>

            <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imagen">
                    {{ trans('social_information.labels.imagen') }}
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="imagen" id="imagen"
                           class="form-control col-md-7 col-sm-7 col-xs-12"
                           accept="image/*">
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

        let $form = $('#support_services_create_fm');

        $validateDefaults.rules = {
            id: {
                required: true
            },
            gid: {
                required: true,
                remote: {
                    url: "{!! route('checkuniquefield') !!}",
                    async: false,
                    data: {
                        fieldName: 'gid',
                        fieldValue: () => {
                            return $('#gid').val();
                        },
                        model: 'App\\Models\\Business\\Roads\\Catalogs\\SupportServices',
                    }
                }
            }
        };

        $validateDefaults.messages = {
            gid: {
                remote: '{{ trans('social_information.messages.validations.support_services_uniqueGid') }}'
            }
        };

        $form.validate($.extend(false, $validateDefaults));

        let datatable = $('#support_services_tb').DataTable();

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