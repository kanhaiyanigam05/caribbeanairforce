<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese" rel="stylesheet">

    <!-- jQuery -->
    <script type="text/javascript" src="{{ asset('core/js/jquery-3.6.4.min.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('core/bootstrap/css/bootstrap.min.css') }}">
    <script type="text/javascript" src="{{ asset('core/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('core/select2/css/select2.min.css') }}">
    <script type="text/javascript" src="{{ asset('core/select2/js/select2.min.js') }}"></script>

    <!-- Validate -->
    <script type="text/javascript" src="{{ asset('core/validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/validate.js') }}"></script>
    <script type="text/javascript">
        jQuery.extend(jQuery.validator.messages, {
            required: "This field is required.",
            remote: "Please fix this field.",
            email: "Please enter a valid email address.",
            url: "Please enter a valid URL.",
            date: "Please enter a valid date.",
            dateISO: "Please enter a valid date (ISO).",
            number: "Please enter a valid number.",
            digits: "Please enter only digits.",
            creditcard: "Please enter a valid credit card number.",
            equalTo: "Please enter the same value again.",
            accept: "Please enter a value with a valid extension.",
            maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
            minlength: jQuery.validator.format("Please enter at least {0} characters."),
            rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
            range: jQuery.validator.format("Please enter a value between {0} and {1}."),
            max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
            min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
        });
    </script>


    <!-- Numeric -->
    <script type="text/javascript" src="{{ asset('core/numeric/jquery.numeric.min.js') }}"></script>

    <!-- Tooltip -->
    <link rel="stylesheet" href="{{ asset('core/tooltipster/css/tooltipster.bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('core/tooltipster/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-light.min.css') }}">
    <script type="text/javascript" src="{{ asset('core/tooltipster/js/tooltipster.bundle.min.js') }}"></script>

    <!-- Google icon -->
    <link href="{{ asset('core/css/google-font-icon.css') }}?v=2" rel="stylesheet">

    <!-- Autofill -->
    <link rel="stylesheet" type="text/css" href="{{ asset('core/css/autofill.css') }}">
    <script type="text/javascript" src="{{ asset('core/js/autofill.js') }}"></script>

    <!-- Theme -->
    <link rel="stylesheet" type="text/css" href="{{ asset('core/css/dark.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('core/css/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('core/css/app.css') }}">

    <!-- Custom css -->

    <script type="text/javascript" src="{{ asset('core/js/functions.js') }}"></script>

    <script type="text/javascript" src="{{ asset('core/js/link.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/box.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/popup.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/sidebar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/list.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/anotify.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/dialog.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/iframe_modal.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/search.js') }}"></script>

    <script type="text/javascript" src="{{ asset('core/js/app.js') }}"></script>
    <script>
        var APP_URL = '{{ url('/') }}';
        var LANG_OK = 'OK';
        var LANG_CONFIRM = 'Confirm';
        var LANG_YES = 'Yes';
        var LANG_NO = 'No';
        var LANG_ARE_YOU_SURE = 'Are you sure?';
        var LANG_CANCEL = 'Cancel';
        var LANG_DELETE_VALIDATE = 'Please enter the text exactly as it is displayed to confirm deletion.';
        var LANG_DATE_FORMAT = 'yyyy-mm-dd';
        var LANG_ANY_DATETIME_FORMAT = '%Z-%m-%d, %H:%i';
        var CSRF_TOKEN = "{{ csrf_token() }}";
        var LANG_SUCCESS = 'Success';
        var LANG_ALERT = 'Alert';
        var LANG_ERROR = 'Error';
        var LANG_CONFIRMATION = 'Confirmation';
        var LANG_NOTIFY = {
            'success': 'Success',
            'error': 'Error',
            'notice': 'Notice'
        };
        var LOADING_WAIT = 'Loading, please wait...';
    </script>
    {{-- <script type="text/javascript" src="{{ asset('core/tinymce/tinymce.min.js') }}"></script> --}}
    {{-- <link rel="stylesheet" href="{{ asset('email-module/libraries/tinymce@v7.3.0/skins/ui/oxide-dark/skin.min.css') }}"> --}}
    <script type="text/javascript" src="{{ asset('email-module/libraries/tinymce@v7.3.0/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('core/js/editor.js') }}"></script>

    <script src="{{ asset('core/js/UrlAutoFill.js') }}"></script>
    <style>
        .tox-tinymce {
            height: calc(100vh - 54px) !important;
        }
    </style>
</head>

<body class="layout-dark topbar">
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark fixed-top navbar-main py-0">
        <div class="container-fluid ms-0">
            <a class="navbar-brand d-flex align-items-center me-2" href="{{ url('/') }}">
                <img class="logo" src="{{ asset('asset/images/logo-25.png') }}" alt="">
            </a>
            <button class="navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#mainAppNav" aria-controls="mainAppNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainAppNav">
                <ul class="navbar-nav me-auto mb-md-0">
                    <li class="nav-item">
                        <div class="d-flex align-items-center">
                            <div class="d-inline-block d-flex mr-auto align-items-center ml-1 lvl-1">
                                <h4 class="my-0 me-2 menu-title text-white">{{ $template->name }}</h4>
                                <i class="material-symbols-rounded">alarm</i>
                            </div>
                        </div>
                    </li>
                </ul>
                <div class="navbar-right">
                    <ul class="navbar-nav me-auto mb-md-0">
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ route('admin.email.templates.index') }}"
                                class="nav-link py-3 lvl-1 d-flex align-items-center">
                                <i class="material-symbols-rounded me-2">arrow_back</i>
                                <span>Go back</span>
                            </a>
                        </li>
                        <li class="d-flex align-items-center px-3">
                            <button class="btn btn-primary" onclick="$('#classic-builder-form').submit()">Save</button>
                        </li>
                        <li>
                            <a href="{{ route('admin.email.templates.index') }}"
                                onclick="parent.$('body').removeClass('overflow-hidden');parent.$('.full-iframe-popup').fadeOut()"
                                class="nav-link close-button action black-close-button">
                                <i class="material-symbols-rounded">close</i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div middle-bar-control="container" class="middle-bar pt-1">
        <div class="middle-bar-head px-1">
            <button middle-bar-control="close" class="btn btn-link fs-4 middle-bar-close-button" style="box-shadow: -1rem 0rem 1rem rgba(0,0,0,.025)!important;"><span
                    class="material-symbols-rounded">west</span></button>
        </div>
        <div class="content">
        </div>
    </div>

    <script>
        $(function() {
            // middle bar close
            $('[middle-bar-control="close"]').on('click', function() {
                hideMiddleBar();
            });
            $(document).on('mouseup', function(e) {
                var container = $('[middle-bar-control="container"], [middle-bar-control="element"]');

                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    hideMiddleBar();
                }
            });
        })
    </script>

    <form id="classic-builder-form" action="{{ route('admin.email.templates.update', $template->uid) }}" method="POST" class="ajax_upload_form form-validate-jqueryz builder-classic-form">
        {{ csrf_field() }}

        <div class="row mr-0 ml-0">
            <div class="col-md-9 pl-0 pb-0 pr-0 form-group-mb-0">
                <div class="loading classic-loader">
                    <div class="text-center inner">
                        <div class="box-loading">
                            <div class="lds-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group control-textarea">
                    <textarea type="text" name="content" class="form-control required template-editor" id="content" aria-hidden="true">{!! $template->content !!}</textarea>
                </div>
            </div>
            <div class="col-md-3 pr-0 pb-0 sidebar pr-4 pt-4 pl-4" style="overflow:auto;background:#f5f5f5">
                <div class="form-group control-text">
                    <label>Template name <span class="text-danger">*</span></label>
                    <input id="name" placeholder="" value="{{ $template->name ?? 'Untitled template' }}" type="text" name="name" class="form-control required valid"
                        aria-invalid="false">
                </div>
                <hr>
                <div class="tags_list">
                    <label class="text-semibold text-teal">Available tags:</label>
                    <br />
                    @foreach (tags() as $key => $value)
                        <a data-popup="tooltip" title='Click to insert tag' href="javascript:;"
                            style="padding: 3px 7px !important;
                                font-weight: normal;"
                            draggable="false"
                            class="btn btn-secondary mb-2 mr-1 text-semibold btn-xs insert_tag_button" data-tag-name="{{ "[$key]" }}">
                            {{ $key }}
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </form>

    <script>
        $(function() {
            // Click to insert tag
            $(document).on("click", ".insert_tag_button", function() {
                var tag = $(this).attr("data-tag-name");

                if ($('textarea[name="html"]').length || $('textarea[name="content"]').length) {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, tag);
                } else {
                    speechSynthesis;
                    $('textarea[name="plain"]').val($('textarea[name="plain"]').val() + tag);
                }
            });
        });
    </script>

    <script>
        var urlFill = new UrlAutoFill([{
                value: '{UNSUBSCRIBE_URL}',
                text: 'Click here to unsubscribe'
            },
            {
                value: '{UPDATE_PROFILE_URL}',
                text: 'Update your profile'
            },
            {
                value: '{WEB_VIEW_URL}',
                text: 'Click to view web version of this email'
            }
        ]);

        $('.builder-classic-form').submit(function(e) {
            e.preventDefault();

            tinymce.triggerSave();

            var url = $(this).attr('action');
            var data = $(this).serialize();

            if ($(this).valid()) {
                // open builder effects
                addMaskLoading("Saving template...", function() {
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: data,
                        statusCode: {
                            // validate error
                            400: function(res) {
                                removeMaskLoading();

                                // notify
                                parent.notify('error', 'Error', res.responseText);
                            }
                        },
                        success: function(response) {
                            removeMaskLoading();

                            // notify
                            parent.notify({
                                type: 'success',
                                title: 'Success',
                                message: response.message
                            });
                        }
                    });
                });
            }
        });

        $('.sidebar').css('height', parent.$('.full-iframe-popup').height() - 53);

        var editor;
        $(document).ready(function() {
            editor = tinymce.init({
                language: 'en',
                selector: '.template-editor',
                directionality: "ltr",
                height: parent.$('.full-iframe-popup').height() - 53,
                convert_urls: false,
                remove_script_host: false,
                forced_root_block: "",
                plugins: 'fullpage print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar: [
                    'ltr rtl | acelletags | undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify',
                    'outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl'
                ],
                toolbar_location: 'top',
                menubar: true,
                statusbar: false,
                toolbar_sticky: true,
                valid_elements: '*[*],meta[*]',
                valid_children: '+h1[div],+h2[div],+h3[div],+h4[div],+h5[div],+h6[div],+a[div]',
                extended_valid_elements: "meta[*]",
                valid_children: "+body[style],+body[meta],+div[h2|span|meta|object],+object[param|embed]",
                setup: function(editor) {

                    /* Menu button that has a simple "insert date" menu item, and a submenu containing other formats. */
                    /* Clicking the first menu item or one of the submenu items inserts the date in the selected format. */
                    editor.ui.registry.addMenuButton('acelletags', {
                        text: 'Click to insert tag',
                        fetch: function(callback) {
                            var items = [];

                            @foreach (tags() as $key => $value)
                                items.push({
                                    type: 'menuitem',
                                    text: '{{ $key }}',
                                    onAction: function(_) {
                                        editor.insertContent('{{ "[$key]" }}');
                                    }
                                });
                            @endforeach

                            callback(items);
                        }
                    });

                    editor.on('init', function(e) {
                        $('.classic-loader').remove();
                    });
                }
            });
        });
    </script>
</body>

</html>
