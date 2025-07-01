<!doctype html>
<html>

<head>
    <title>Builder</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- BuilderJS CORE -->
    <link href="{{ asset('builder/builder.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('builder/custom.css') }}" rel="stylesheet" type="text/css">

    <!-- Select2 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('builder/select2/css/select2.min.css') }}">
    <!-- Autofill -->
    <link href="{{ asset('builder/UrlAutoFill.css') }}" rel="stylesheet" type="text/css">
    <style>
        body,
        .builderjs-layout {
            background-color: #fff;
        }

        .lds-dual-ring {
            display: inline-block;
            width: 80px;
            height: 80px;
        }

        .lds-dual-ring:after {
            content: " ";
            display: block;
            width: 30px;
            height: 30px;
            margin: 4px;
            border-radius: 80%;
            border: 2px solid #aaa;
            border-color: #007bff transparent #007bff transparent;
            animation: lds-dual-ring 1.2s linear infinite;
        }

        @keyframes lds-dual-ring {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div style="text-align: center;
    height: 100vh;
    vertical-align: middle;
    padding: auto;
    display: flex;">
        <div style="margin:auto" class="lds-dual-ring"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="{{ asset('builder/builder.js') }}"></script>
    @include('admin.email.builder.js.widgets')
    <script type="text/javascript" src="{{ asset('builder/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('builder/UrlAutoFill.js') }}"></script>

    {{-- Builder js --}}
    @include('admin.email.builder.js._builder_form')
    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        var editor;

        var templates = {!! json_encode($templates) !!};

        $(document).ready(function() {
            editor = new Editor({
                strict: true,
                showHelp: false,
                showInlineToolbar: false,
                emailMode: true,
                lang: 'en',
                url: '{{ route('admin.email.templates.builder.edit.content', $template->uid) }}',
                backCallback: function() {
                    if (parent.$('.full-iframe-popup').length) {
                        parent.$('.full-iframe-popup').hide();
                        parent.$('body').removeClass('overflow-hidden');
                    }

                    if (parent.$('.listing-form').length) {
                        parent.TemplatesIndex.getList().load();
                    } else {
                        window.location = '{{ route('admin.email.templates.index') }}';
                    }
                },
                uploadAssetUrl: '{{ route('admin.email.templates.builder.edit.asset', $template->uid) }}',
                uploadAssetMethod: 'POST',
                saveUrl: '{{ route('admin.email.templates.update', $template->uid) }}',
                saveMethod: 'POST',
                tags: {!! json_encode(App\Models\Template::builderTags(isset($list) ? $list : null)) !!},
                root: '{{ asset('builder') }}/',
                templates: templates,
                logo: '{{ asset('asset/images/logo-25.png') }}',
                backgrounds: [
                    '{{ asset('builder/backgrounds/images1.jpg') }}',
                    '{{ asset('builder/backgrounds/images2.jpg') }}',
                    '{{ asset('builder/backgrounds/images3.jpg') }}',
                    '{{ asset('builder/backgrounds/images4.png') }}',
                    '{{ asset('builder/backgrounds/images5.jpg') }}',
                    '{{ asset('builder/backgrounds/images6.jpg') }}',
                    '{{ asset('builder/backgrounds/images9.jpg') }}',
                    '{{ asset('builder/backgrounds/images11.jpg') }}',
                    '{{ asset('builder/backgrounds/images12.jpg') }}',
                    '{{ asset('builder/backgrounds/images13.jpg') }}',
                    '{{ asset('builder/backgrounds/images14.jpg') }}',
                    '{{ asset('builder/backgrounds/images15.jpg') }}',
                    '{{ asset('builder/backgrounds/images16.jpg') }}',
                    '{{ asset('builder/backgrounds/images17.png') }}'
                ],
                customInlineEdit: function(container) {
                    thisEditor = this;

                    var tinyconfig = {
                        skin: 'oxide-dark',
                        inline: true,
                        menubar: false,
                        valid_elements: '*[*],meta[*]',
                        valid_children: '+h1[div],+h2[div],+h3[div],+h4[div],+h5[div],+h6[div],+a[div]',
                        force_br_newlines: false,
                        force_p_newlines: false,
                        forced_root_block: '',
                        inline_boundaries: false,
                        relative_urls: false,
                        convert_urls: false,
                        remove_script_host: false,
                        plugins: 'image link lists autolink',
                        font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; MS Mincho=ms mincho; MS PMincho=ms pmincho; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                        //toolbar: 'undo redo | bold italic underline | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent',
                        toolbar: [
                            // 'undo redo | bold italic underline | fontselect fontsizeselect | link | menuDateButton',
                            // 'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
                        ],
                        external_filemanager_path: '{{ url('/') }}'.replace('/index.php', '') + "/filemanager2/",
                        filemanager_title: "Responsive Filemanager",
                        external_plugins: {
                            "filemanager": '{{ url('/') }}'.replace('/index.php', '') + "/filemanager2/plugin.min.js"
                        },
                        setup: function(editor) {

                            /* Menu button that has a simple "insert date" menu item, and a submenu containing other formats. */
                            /* Clicking the first menu item or one of the submenu items inserts the date in the selected format. */
                            editor.ui.registry.addMenuButton('menuDateButton', {
                                text: getI18n('editor.insert_tag'),
                                fetch: function(callback) {
                                    var items = [];

                                    thisEditor.tags.forEach(function(tag) {
                                        if (tag.type == 'label') {
                                            items.push({
                                                type: 'menuitem',
                                                text: tag.tag.replace("{", "").replace("}", ""),
                                                onAction: function(_) {
                                                    if (tag.text) {
                                                        editor.insertContent(tag.text);
                                                    } else {
                                                        editor.insertContent(tag.tag);
                                                    }
                                                }
                                            });
                                        }
                                    });

                                    callback(items);
                                }
                            });
                        }
                    };

                    var unsupported_types = 'td, table, img, body';
                    if (!container.is(unsupported_types) && (container.is('[builder-inline-edit]') || !editor.strict)) {
                        container.addClass('builder-class-tinymce');
                        tinyconfig.selector = '.builder-class-tinymce';
                        editor.tinymce = $("#builder_iframe")[0].contentWindow.tinymce.init(tinyconfig);

                        container.removeClass('builder-class-tinymce');
                    }

                    // fixing td tinymce
                    if (container.is('td')) {
                        if (!container.find('.tinymce-td-fix').length) {
                            var span = $('<div class="tinymce-td-fix builder-class-tinymce">');
                            span.html(container.html());

                            container.html('');
                            container.append(span);

                            span.click();
                        }
                    }
                },
                loaded: function() {
                    var thisEditor = this;

                    // add custom css
                    this.addCustomCss('{{ asset('builder/edit.css') }}');
                }
            });

            // Rss widget
            editor.addWidget(new RssWidget(), {
                index: 3
            });

            editor.init();


            $(document).on('click', '.filemanager-ok', function(e) {
                alert('Please click on the thumbnail to select the corresponding image');
            })
            $(document).on('click', '.filemanager-cancel', function(e) {
                $('.PopUpCloseButton').click();
            })

            //
            var urlFill = new UrlAutoFill({!! json_encode($template->urlTagsDropdown()) !!});
        });
    </script>
</body>

</html>
