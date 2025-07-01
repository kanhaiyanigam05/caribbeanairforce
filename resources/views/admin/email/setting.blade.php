@extends('layout.email')
@push('css')
    {{--  --}}
@endpush
@section('email')

    <section class="px-3 max-w-[1500px] mx-auto my-10">
        <form action="{{ route('admin.email.setting.store') }}" method="POST">
            @csrf
            <div class="border-[1px] border-[#a7a7a73f] rounded-sm screen500:w-[450px] mx-auto my-9 px-4 py-11 flex flex-col gap-4">
                <div class="flex flex-col gap-2 mb-11">
                    <h1 class="text-center text-2xl font-semibold">Delivery settings</h1>
                    <p class="text-slate-600 text-sm text-center mt-2">To run the campaign and send emails, please make sure
                        <br>
                        to fill out the form below:
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="name" class="text-[15px] text-black">Select provider *</label>
                    <div class="custom-dropdown">
                        <button value="{{ old('providor', $setting->providor ?? '') }}" name="providor" class="dropdown-input" type="button">
                            <span class="text">Provider</span>
                            <i class="fa-solid fa-caret-up rotate-180 icon"></i>
                        </button>

                        <div class="dropdown-body hidden">
                            <ul class="w-full max-h-52 overflow-y-auto">
                                {{-- <li class="body-item disabled">
                                    <span class="text">Amazon SES</span>
                                    <i class="fa-solid fa-check hidden"></i>
                                </li>
                                <li class="body-item disabled">
                                    <span class="text">Mailgun</span>
                                    <i class="fa-solid fa-check hidden"></i>
                                </li> --}}
                                <li class="body-item available">
                                    <span class="text">SMTP</span>
                                    <i class="fa-solid fa-check hidden"></i>
                                </li>
                            </ul>
                        </div>
                        @error('providor')
                            <span class="text-primary text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="host" class="text-[15px] text-black">Host</label>
                    <input type="text" id="host" name="host" value="{{ old('host', $setting->host ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm"
                        placeholder="smtp.example.com">
                    @error('host')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="port" class="text-[15px] text-black">Port</label>
                    <input type="text" id="port" name="port" value="{{ old('port', $setting->port ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm" placeholder="587">
                    @error('port')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="encryption">Encryption</label>

                    <div class="custom-dropdown">
                        <button value="{{ old('encryption', $setting->encryption ?? '') }}" name="encryption" class="dropdown-input" type="button">
                            <span class="text">Select Encryption</span>
                            <i class="fa-solid fa-caret-up rotate-180 icon"></i>
                        </button>

                        <div class="dropdown-body hidden">
                            <ul class="w-full max-h-52 overflow-y-auto">
                                <li class="body-item available">
                                    <span class="text">SSL</span>
                                    <i class="fa-solid fa-check hidden"></i>
                                </li>
                                <li class="body-item available">
                                    <span class="text">TLS</span>
                                    <i class="fa-solid fa-check hidden"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @error('encryption')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="username" class="text-[15px] text-black">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $setting->username ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm" placeholder="john.doe">
                    @error('username')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-[15px] text-black">Password</label>
                    <input type="password" id="password" name="password" value="{{ old('password', $setting->password ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm"
                        placeholder="****************">
                    @error('password')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="email" class="text-[15px] text-black">From Email</label>
                    <input type="email" id="email" name="from_email" value="{{ old('from_email', $setting->from_email ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm"
                        placeholder="john.doe@nowhere.com">
                    @error('from_email')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="name" class="text-[15px] text-black">From Name</label>
                    <input type="text" id="name" name="from_name" value="{{ old('from_name', $setting->from_name ?? '') }}"
                        class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm"
                        placeholder="john.doe@nowhere.com">
                    @error('from_name')
                        <span class="text-primary text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-2 flex-col screen500:flex-row">
                    <button class="bg-primary text-white w-full py-[10px] px-[20px] min-w-36 text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm"
                        type="submit">Submit</button>
                    <button class="bg-slate-700 text-white w-full py-[10px] px-[20px] min-w-36 text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm"
                        type="reset">Reset</button>
                    @if (!empty($setting))
                        <button class="show-modal-btn bg-primary text-white w-full py-[10px] px-[20px] text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm"
                            type="button" data-target="#testing-modal">Test</button>
                    @endif
                </div>
            </div>
        </form>
    </section>
    @push('modals')
        @if (!empty($setting))
            <!-- Modal Section Starts Here -->
            <section id="testing-modal" class="modal hide hidden fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
                <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[700px] overflow-hidden">
                    <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>

                    <form class="p-4 my-8 testing-mail" action="{{ route('admin.email.test.email') }}" method="POST">
                        @csrf
                        <div class="flex justify-center items-start flex-col gap-6">
                            <h4 class="text-xl font-semibold text-center">Test your mail setup</h4>
                            <div class="w-full">
                                <input type="text" id="email" name="email"
                                    class="text-left text-black w-full rounded-sm px-3 py-2 border border-slate-400 focus:outline-none text-sm"
                                    placeholder="Enter your email for testing">
                                <span class="text-primary font-semibold error_email"></span>
                            </div>
                            <button type="submit"
                                class="bg-primary text-white py-[10px] px-[20px] min-w-36 text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm">Send Mail</button>
                        </div>
                    </form>
                </div>
            </section>
            <!-- Modal Section Ends Here -->
            {{-- <button class="show-modal-btn" data-target="#testing-modal">click</button> --}}
        @endif
    @endpush
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('.testing-mail').on('submit', function(e) {
                const $form = $(this);
                $form.find('.error_email').text('');
                e.preventDefault();
                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: $form.serialize(),
                    success: function(response) {
                        console.log(response);
                        $form.closest('.modal').find('.close-btn').trigger('click');
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr, status, error);
                        Swal.fire({
                            title: "Failed!",
                            text: xhr.responseJSON.message ?? "Failed to send email. Please try again.",
                            icon: "error",
                        });
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;

                            $.each(errors, function(field, error) {
                                $(".error_" + field).text(error[0]);
                            });
                        }
                    },
                })
            })
        });
    </script>
@endpush
