@permission('create.main_shape')
@inject('MainShape', 'App\Models\Business\Roads\MainShape')

<div class="modal-content" id="intersection_create">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
            <i class="fa fa-automobile"></i> {{ trans('main_shape.labels.create') }}
        </h4>
    </div>

    <div class="clearfix"></div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_content">
            <form role="form" action="{{ route('store.create.main_shape') }}"
                  method="post"
                  class="form-horizontal form-label-left" id="main_shape_create_fm">
                @csrf

                <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="shape">
                        {{ trans('main_shape.labels.name') }}
                    </label>
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        <input type="file" name="shape[]" id="shape"
                               class="form-control col-md-7 col-sm-7 col-xs-12" multiple/>
                    </div>
                </div>

                <div class="ln_solid"></div>

                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <a class="btn btn-info ajaxify closeModal">
                        <i class="fa fa-times"></i> {{ trans('app.labels.cancel') }}
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-check"></i> {{ trans('app.labels.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="modal-footer">
    </div>
</div>

<script>
    $(() => {

        $('.select2').select2({});

        let $form = $('#main_shape_create_fm');

        $validateDefaults.rules = {
            'shape[]': {
                required: true,
                countFiles: true,
                sizeFiles: true,
                extension: 'shp'
            }
        };

        $validateDefaults.messages = {
            'shape[]': {
                extension: '{{ trans('shape.messages.errors.only_shp') }}'
            }
        }

        // Permite subir hasta 5 archivos a la vez
        jQuery.validator.addMethod("countFiles", () => {
            let $fileUpload = $("input[type='file']");
            if (parseInt($fileUpload.get(0).files.length) <= {{ $MainShape::MAX_FILE_UPLOAD }}) {
                return true
            }
        }, '{{ trans("main_shape.messages.errors.max_file") }}');

        // Delimitar el tamaño de los archivos
        jQuery.validator.addMethod("sizeFiles", (value, element) => {
            if ($(element).attr("type") === "file") {
                if (element.files && element.files.length) {
                    files = element.files;
                    let fileSize = 0;
                    $.each(files, function (index, element) {
                        fileSize += element.size;
                    });
                    return (parseInt(fileSize) <= {{ $MainShape::MAX_SIZE_UPLOAD }});
                }
            }
            return false;
        }, '{{ trans("main_shape.messages.errors.size_file") }}: ' + '{{ $MainShape::STRING_MAX_SIZE_UPLOAD }}');

        $form.validate($validateDefaults);

        $form.ajaxForm($.extend(false, $formAjaxDefaults, {
            success: (response) => {
                processResponse(response, null, () => {
                    $modal.modal('hide');
                });
            }
        }));

        $('.closeModal').on('click', (e) => {
            $modal.modal('hide');
        });
    });
</script>

@else
    @include('errors.403')
    @endpermission