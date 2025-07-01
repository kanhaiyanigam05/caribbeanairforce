@extends('layout.app')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .error {
            color: #ff0000;
            font-weight: bold;
        }
    </style>
@endpush
@section('admin')
    <div class="container py-5">
        <div class="row">
            <form action="{{ route('admin.email.templates.store') }}" method="post" class="col-12 template-form">
                @csrf
                <input type="hidden" name="template" value="">
                <div class="mb-3">
                    <label for="template_name" class="form-label">Enter your template's name here</label>
                    <input type="text" name="name" class="form-control required" id="template_name" placeholder="name required" value="Untitled template">
                </div>
            </form>
            <div class="col-12">
                <div class="d-flex justify-content-between">
                    <h1>Templates List</h1>
                    <button type="submit" class="btn btn-primary start-design">Start Design</button>
                </div>
                <div class="row">
                    @foreach ($templates as $template)
                        <div class="col-lg-3 select-template-layout" data-template="{{ $template->uid }}" data-template-name="{{ $template->name }}">
                            <input type="checkbox" name="template" id="blank" value="blank" class="hidden">
                            <label for="blank" class="card" style="width: 18rem;">
                                <img src="http://acellemail.test/assets/YXBwL3RlbXBsYXRlcy82MDM3YTBhODU4M2E3/thumb.svg?1739785353?v=8" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $template->name }}</h5>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admins/js/jquery.validate.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.select-template-layout', function() {
                var template = $(this).attr('data-template');

                // unselect all layouts
                $('.select-template-layout').removeClass('selected');

                // select this
                $(this).addClass('selected');

                // unselect all
                $('[name=template]').val('');

                // update template value
                if (typeof(template) !== 'undefined') {
                    $('[name=template]').val(template);
                }
            });

            // $('.select-template-layout').eq(0).click();

            $(document).on('click', '.start-design', function() {
                var form = $('.template-form');

                if ($('.select-template-layout.selected').length == 0) {
                    // Success alert
                    // new Dialog('alert', {
                    //     title: "{{ trans('messages.notify.error') }}",
                    //     message: "{{ trans('messages.template.need_select_template') }}",
                    // });
                    alert('PLease select a template first');
                    return;
                }

                if (form.valid()) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
