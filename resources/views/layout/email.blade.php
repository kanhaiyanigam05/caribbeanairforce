@extends('layout.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('email-module/libraries/slim-select@2.10.0/css/slimselect.css') }}">
    <link href="{{ asset('email-module/css/talwind/style.css') }}" rel="stylesheet" />
@endpush
@section('admin')
    <section class="px-3 text-lg font-medium max-w-[1500px] mx-auto">
        <div class="text-black flex justify-start items-center gap-3 py-[30px]">
            <a href="{{ route('admin.email.index') }}" @if (Route::currentRouteName() === 'admin.email.index') class="text-primary" @endif>Home</a>
            <a href="{{ route('admin.email.templates.index') }}" @if (Route::currentRouteName() === 'admin.email.templates.index') class="text-primary" @endif>Templates</a>
            <a href="{{ route('admin.email.lists.index') }}" @if (Route::currentRouteName() === 'admin.email.lists.index') class="text-primary" @endif>Mail Lists</a>
            <a href="{{ route('admin.email.compose') }}" @if (Route::currentRouteName() === 'admin.email.compose') class="text-primary" @endif>Compose</a>
            <a href="{{ route('admin.email.setting') }}" @if (Route::currentRouteName() === 'admin.email.setting') class="text-primary" @endif>Setting</a>
        </div>
    </section>
    @yield('email')
@endsection
@push('modals')
    @if (!(Auth::user()->mail_setting != null || Route::currentRouteName() === 'admin.email.setting'))
        <!-- Modal Section Starts Here -->
        <section class="modal show flex fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
            <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[700px] overflow-hidden">
                {{-- <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button> --}}

                <div class="p-4 my-8">
                    <div class="flex justify-center items-center flex-col gap-6">
                        <h4 class="text-xl font-semibold text-center">No Delivery Settings Found</h4>
                        <p class="text-[15px] text-gray-400 text-center">No delivery settings have been configured for this account. Please create the delivery settings first. Make sure to provide
                            all necessary details for the email configuration before proceeding with the email marketing.</p>
                        <a href="{{ route('admin.email.setting') }}"
                            class="close-btn bg-primary text-white py-[10px] px-[20px] min-w-36 text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm">Create
                            Delivery Settings</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal Section Ends Here -->
    @endif
@endpush
@push('js')
    <script src="{{ asset('email-module/js/general.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showModal();
            closeModal();
            // showUploadThumbModal();
            // closeUploadThumbModal();
            // deleteTemplateShowModal();
            // closeDeleteTemplateModal();
            handleTemplateCardSelection();
            customDropdown();
        });
    </script>
@endpush
