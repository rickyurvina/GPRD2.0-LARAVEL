@permission('edit.prioritization_templates')
<div>
    <div class="page-title">
        <div class="title_left">
            <h3>{{ trans('prioritization_templates.title') }}
                <small>{{ trans('app.labels.projects') }}</small>
            </h3>
        </div>
        <div class="title_right hidden-xs">
            <ol class="breadcrumb pull-right">

                @permission('index.prioritization_templates')
                <li>
                    <a class="ajaxify" href="{{ route('index.prioritization_templates') }}"> {{ trans('prioritization_templates.title') }}</a>
                </li>
                @endpermission

                <li class="active">{{ trans('prioritization_templates.labels.edit') }}</li>
            </ol>
        </div>
    </div>

    <div class="row mb-16">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><i class="fa fa-recycle"></i> {{ trans('prioritization_templates.title') }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li class="pull-right">
                            <a href="{{ route('index.prioritization_templates') }}" class="btn btn-box-tool ajaxify">
                                <i class="fa fa-times"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <form role="form" method="post" class="form-horizontal form-label-left" id="edit_template_fm">

                        @method('PUT')
                        @csrf

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fiscal_year_id">
                                {{ trans('prioritization_templates.labels.fiscal_year') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="fiscal_year_id" name="fiscal_year_id" disabled class="form-control" value="{{ $template->fiscalYear->year }}">
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="description">
                                {{ trans('app.headers.description') }}
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="description" id="description"
                                          class="form-control vertical"
                                          placeholder="{{ trans('prioritization_templates.placeholders.description') }}">{{ $template->description }}</textarea>
                            </div>
                        </div>

                        <div id="scopes_div" class="mt-4"></div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="navbar-default navbar-fixed-bottom text-center">
        <div>
            <div class="tile-stats prioritization-total mb-4 prioritization_index">
                <span class="count_bottom">{{ trans('prioritization_templates.labels.total_weight') }}: <b><i class="green" id="total_weight"></i></b></span>
                <i id="invalidWeight" role="button" data-toggle="tooltip" data-placement="right"
                   data-original-title="{{ trans('prioritization_templates.messages.validation.total_weight') }}"
                   class="fa fa-info-circle red hidden"></i>
            </div>
        </div>
        <div>
            <a href="{{ route('index.prioritization_templates') }}" class="btn btn-info ajaxify">
                <i class="fa fa-times"></i> {{ trans('app.labels.cancel') }}
            </a>
            <button id="btnEditTemplate" name="btnEditTemplate" class="btn btn-success" type="button">
                <i class="fa fa-check"></i> {{ trans('app.labels.save') }}
            </button>
        </div>
    </footer>

</div>

<script>
    $(() => {
        let templateForm = $('#edit_template_fm')
        let selectInputs = $('.select2')
        let wrapper = $('#scopes_div')
        let totalWeight = $('#total_weight')
        let editTemplateButton = $('#btnEditTemplate')
        let invalidWeightTooltip = $('#invalidWeight')
        let description = $('#description')
        const initialDescription = '{!! $template->description !!}'
        let initialTemplate

        // Add validations to form
        const addFormValidations = () => {
            let validator = templateForm.validate($.extend(false, $validateDefaults, {}))

            $('.required-answer').rules('add', {
                required: true,
                onlyIntegers: true
            })

            // Validate selects on change
            selectInputs.each((index, element) => {
                $(element).on('change', () => {
                    validator.element(element)
                })
            })

            templateForm.ajaxForm($.extend(false, $formAjaxDefaults, {}))
        }

        /**
         * Calcular el peso total (suma del peso de cada ámbito)
         */
        const calculateTotalWeight = () => {
            let weightSum = 0
            let maxWeightSum = 100
            $('[id^=weight_]').each((index, element) => {
                weightSum += parseInt($(element).val()) || 0
            })

            if (weightSum !== maxWeightSum) {
                totalWeight.removeClass('green')
                totalWeight.addClass('red')
                invalidWeightTooltip.removeClass('hidden')
                editTemplateButton.prop('disabled', true)
            } else {
                totalWeight.removeClass('red')
                totalWeight.addClass('green')
                invalidWeightTooltip.addClass('hidden')
            }

            totalWeight.text(weightSum)
        }

        // Load template scopes, criteria, questions, answers and values
        const loadTemplateInfo = () => {
            let scopes = JSON.parse('{!! json_encode($template->scopes()) !!}')
            let appendItem = ''

            wrapper.empty()

            $.each(scopes, (scopeIndex, scope) => {
                appendItem += '<div class="row">'
                appendItem += '    <div class="col-lg-9 col-md-10 col-sm-11 col-xs-12">'
                appendItem += '        <div class="dashboard-title title_left col-lg-8 col-md-8 col-sm-12 col-xs-12">'
                appendItem += '            <h3><a class="template-accordion" data-toggle="collapse" href="#scope_' + scope.id + '"><i class="fa fa-plus pl-2 pr-2"></i><i class="fa fa-minus hidden pl-2 pr-2"></i></a> ' + scope.scope + '</h3>'
                appendItem += '        </div>'
                appendItem += '        <div class="item form-group text-center col-lg-4 col-md-4 col-sm-12 col-xs-12 pt-2 mt-2">'
                appendItem += '            <label class="col-md-4 col-sm-4 col-xs-4 pt-2 col-xs-offset-1">{{ trans('prioritization_templates.labels.weight') }} <span class="text-danger">*</span></label>'
                appendItem += '            <div class="col-md-6 col-sm-6 col-xs-4">'
                appendItem += '                <input id="weight_' + scope.id + '" required data-scope="' + scope.id + '" data-type="weight" type="number" min="0" max="100" maxlength="3" value="' + Math.round(scope.weight * 100) + '" class="form-control required-answer" oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">'
                appendItem += '            </div>'
                appendItem += '        </div>'
                appendItem += '        <div class="x_content mb-4 collapse" id="scope_' + scope.id + '">'

                $.each(scope.criteria, (criterionIndex, criterion) => {
                    appendItem += '        <div class="x_title mb-4">'
                    appendItem += '            <h2>' + criterion.question + '</h2>'
                    appendItem += '            <div class="clearfix"></div>'
                    appendItem += '        </div>'

                    $.each(criterion.answers, (answerIndex, answer) => {
                        appendItem += '        <div class="item form-group">'
                        appendItem += '            <div class="col-md-4 col-sm-6 col-xs-8 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">'
                        appendItem += '                <label class="control-label col-md-4 col-sm-4 col-xs-4">' + answer.name + ' <span class="text-danger">*</span></label>'
                        appendItem += '                <div class="col-md-6 col-sm-6 col-xs-6">'
                        appendItem += '                    <input data-type="option" data-scope="' + scope.id + '" data-criteria="' + criterion.id + '" data-option="' + answer.name + '"'
                        appendItem += '                           type="number" min="0" max="5" maxlength="1" required value="' + parseInt(answer.value) + '" class="form-control required-answer" oninput="if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">'
                        appendItem += '                </div>'
                        appendItem += '                <div class="col-md-1 col-sm-1 col-xs-1 pl-0">'
                        appendItem += '                    <i role="button" data-toggle="tooltip" data-placement="right"'
                        appendItem += '                       data-original-title="{{ trans('prioritization_templates.messages.info.range') }}"'
                        appendItem += '                       class="fa fa-info-circle fa-tooltip blue"></i>'
                        appendItem += '                </div>'
                        appendItem += '            </div>'
                        appendItem += '        </div>'
                    })
                })

                appendItem += '        </div>'
                appendItem += '    </div>'
                appendItem += '</div>'
            })

            wrapper.append(appendItem)

            // Initiliaze accordion expand and collapse actions
            $('.template-accordion').on('click', (e) => {
                $(e.currentTarget).find('i').each((index, element) => {
                    $(element).hasClass('hidden') ? $(element).removeClass('hidden') : $(element).addClass('hidden')
                })
            })

            // Initialize change event for required inputs
            $('input.required-answer').change((e) => {
                let input = $(e.currentTarget)

                if (input.val() === null) {
                    input.val(0)
                }

                toggleEditButton()
                calculateTotalWeight()
            })

            // Initialize tooltips
            $('body').tooltip({selector: '[data-toggle=tooltip]'})

            addFormValidations()
            calculateTotalWeight()

            initialTemplate = createTemplateObject();
        }

        /**
         * Crear el objeto tipo JSON con los valores del template
         *
         * @returns {string}
         */
        let createTemplateObject = () => {

            let template = {}

            $('input.required-answer').each((index, element) => {

                if (!template[$(element).attr('data-scope')]) {
                    template[$(element).attr('data-scope')] = {}
                }

                if ($(element).attr('data-type') === 'weight') {
                    template[$(element).attr('data-scope')].weight = $(element).val()
                } else if ($(element).attr('data-type') === 'option') {

                    if (!template[$(element).attr('data-scope')][$(element).attr('data-criteria')]) {
                        template[$(element).attr('data-scope')][$(element).attr('data-criteria')] = {}
                    }
                    template[$(element).attr('data-scope')][$(element).attr('data-criteria')][$(element).attr('data-option')] = $(element).val()
                }
            })

            return template
        }

        editTemplateButton.on('click', (e) => {

            if (!templateForm.valid()) {
                return false
            }

            let confirmMessage = '{{ trans('prioritization_templates.messages.confirm.edit') }}'

            confirmModal(confirmMessage, () => {

                let url = '{{ route('update.edit.prioritization_templates', ['id' => $template->id]) }}'

                pushRequest(url, null, null, 'PUT', {
                    _token: '{{ csrf_token() }}',
                    configuration: createTemplateObject(),
                    description: description.val()
                })
            })
        })

        /**
         * Verificar si el template ha sido modificado
         *
         * @returns {boolean}
         */
        const templateChanged = () => {
            return !equalArrays(initialTemplate, createTemplateObject())
        };

        // Add change event to description
        description.on('keyup', (e) => {
            toggleEditButton()
        })

        const toggleEditButton = () => {
            (templateChanged() || (initialDescription !== description.val())) ? editTemplateButton.prop('disabled', false) : editTemplateButton.prop('disabled', true)
        }

        loadTemplateInfo()
        toggleEditButton()
    })
</script>

@else
    @include('errors.403')
    @endpermission