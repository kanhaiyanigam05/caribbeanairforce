@extends('layout.app')
@section('admin')
<main class="full-width bg-black flex justify-center items-center py-3 transition">
    <div class="relative flex justify-center items-center transition ">
        <div class="absolute left-side-shape transition">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#BD191F"
                    d="M40.7,-54.3C55.1,-45.5,70.9,-36.8,77.2,-23.6C83.6,-10.4,80.6,7.4,73,21.5C65.3,35.6,53.2,46,40.2,56.5C27.3,67,13.7,77.6,-1.9,80.2C-17.4,82.8,-34.8,77.3,-46,66.3C-57.3,55.2,-62.3,38.5,-67.8,21.9C-73.3,5.3,-79.2,-11.2,-77.3,-27.6C-75.4,-44.1,-65.6,-60.4,-51.4,-69.2C-37.2,-78.1,-18.6,-79.4,-2.7,-75.6C13.1,-71.8,26.3,-63,40.7,-54.3Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
        <section id="login-wrapper" class="flex flex-column items-center transition">
            <a href="{{ route('admin.dashboard') }}" class="login-head text-center w-full transition">
                <img class="select-none w-full max-w-100px mx-auto"
                    src="https://caribbeanairforce.com/wp-content/uploads/2024/01/logo-25.png" alt="site-logo"
                    draggable="false" />
                <h1 class="text-white text-center text-3xl font-bold transition">Reset Password</h1>
            </a>
            <form action="{{ route('admin.update.password') }}" method="post" class="w-full transition"
                id="reset-password-form">
                @csrf
                <input type="hidden" name="token" id="token" value="{{ $token }}">
                <x-input label="Email" type="email" name="email" id="email" placeholder="Email"
                    value="{{ old('email') }}" />
                <div class="mb-08rem w-full transition">
                    <label for="password" class="mb-2px block transition">Password</label>
                    <div class="relative login-password-input-visibility-wrapper">
                        <input class="form-login-input text-white transition" type="password" name="password"
                            id="password" placeholder="**********" />
                        <button type="button" class="absolute" onclick="handlePasswordVisibility()">
                            <span class="material-symbols-outlined" id="password-toggle"> visibility_off </span>
                        </button>
                    </div>
                    <span class="text-primary" id="error_password"></span>
                </div>
                <x-input label="Confirm Password" type="password" name="password_confirmation"
                    id="password_confirmation" placeholder="Confirm Password"
                    :iserror="$errors->has('password_confirmation')"
                    :message="$errors->first('password_confirmation')" />
                <div class="mb-08rem w-full transition">
                    <button id="reset-password-btn" class="form-login-btn text-black transition" type="submit">Reset
                        Password</button>
                </div>
                <div class="w-full transition text-center mx-auto">
                    <p>Already have an account? <a href="{{ route('admin.login') }}"
                            class="forget-password-link">Login?</a></p>
                </div>
            </form>
        </section>
        <div class="absolute right-side-shape transition">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#F1C21B"
                    d="M40.1,-48.7C53.6,-45.4,67.3,-35.9,67,-24.7C66.6,-13.4,52.3,-0.5,46.8,14.8C41.3,30.2,44.7,48.2,38.3,53.6C32,59.1,16,52.1,0.4,51.5C-15.1,50.9,-30.3,56.7,-44.3,53.7C-58.4,50.8,-71.4,39.1,-75.9,24.7C-80.5,10.4,-76.8,-6.7,-71.5,-23.4C-66.3,-40.1,-59.6,-56.4,-47.4,-60.2C-35.3,-63.9,-17.6,-55,-2.2,-52C13.3,-49,26.6,-52,40.1,-48.7Z"
                    transform="translate(100 100)" />
            </svg>
        </div>
    </div>
</main>
@endsection

@section('js')
<script>
    $(document).ready(function() {
            $('#reset-password-form').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader('#reset-password-btn', 'Reset Password');
                const form = this;
                $('.text-primary').text('');
                const formData = $(this).serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.update.password') }}",
                    data: formData,
                    success: function(data) {
                        console.log(data);
                        if (data.success) {
                            Swal.fire({
                                title: "Success!",
                                text: data.message,
                                icon: "success"
                            });
                            $(form).trigger('reset');
                            window.location.href = "{{ route('admin.login') }}";
                        }
                        else {
                            $('#error_email').text(data.email);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status == 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, error) {
                                let $field = $('#' + field);
                                $('#error_' + field).text(error[0]);
                                // $field.next('.text-primary').text(error[0]);
                                // $('#text_' + field).text(error[0]);
                            });
                        }
                        else{
                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON.message,
                                icon: "error"
                            });
                        }

                    }
                });
            });
        })
</script>
@endsection
