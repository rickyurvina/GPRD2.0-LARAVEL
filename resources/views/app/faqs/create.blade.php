<div>
    <div class="page-title">
        <div class="title_left">
            <h3>{{ trans('app/faqs.labels.title') }}
                <small>{{ trans('app.labels.app_mobil') }}</small>
            </h3>
        </div>
        <div class="title_right hidden-xs">
            <ol class="breadcrumb pull-right">
                <li>
                    <a class="ajaxify" href="{{ route('index.faqs') }}"> {{ trans('app/faqs.labels.title') }}</a>
                </li>

                <li class="active"> {{ trans('app.labels.new') }}</li>
            </ol>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-sitemap"></i> {{ trans('app.labels.new') }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a href="{{ route('index.faqs') }}" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form role="form" action="{{ route('store.create.faqs') }}" method="post"
                          class="form-horizontal form-label-left" id="faqs_create_fm" novalidate>
                        @csrf

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                                {{ trans('app/faqs.labels.title') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title"
                                       class="form-control col-md-7 col-sm-7 col-xs-12"/>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                                {{ trans('app.headers.description') }} <span class="text-danger">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="description" id="description"
                                          class="form-control col-md-7 col-sm-7 col-xs-12 vertical"></textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <a href="{{ route('index.faqs') }}" class="btn btn-info ajaxify">
                                <i class="fa fa-times"></i> {{ trans('app.labels.cancel') }}
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check"></i> {{ trans('app.labels.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        let $form = $('#faqs_create_fm');

        $validateDefaults.rules = {
            title: {
                required: true,
                minlength: 3,
                maxlength: 50
            },
            description: {
                required: true
            }
        };

        $form.validate($validateDefaults);
        $form.ajaxForm($formAjaxDefaults);
    });
</script>