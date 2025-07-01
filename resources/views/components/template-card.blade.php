@props(['template' => (object) []])
<div class="base-template-item shadow-[0px_1px_4px_0px_rgba(0,0,0,0.25)] rounded overflow-hidden group" data-template="{{ $template->uid }}">
    <div class="flex justify-center items-center relative aspect-[217/326]">
        <div class="bg-white absolute z-10 w-full h-full flex justify-center items-center">
            <img class="thumbnail w-full h-full object-cover group-hover:blur-[2px] transition-all duration-300" src="{{ asset("uploads/thumbnails/{$template->thumbnail}") }}" alt=""
                draggable="false">
            <div class="flex justify-center items-center flex-col absolute h-full w-full bg-[#d3d3d3] bg-opacity-10 transition-all duration-600 opacity-0 group-hover:opacity-100">
                <div class="text-sm font-medium flex justify-center items-center flex-col gap-[2px] text-center transition-all duration-300 -translate-y-[40%]">
                    <a href="{{ route('admin.email.compose', $template->uid) }}"
                        class="bg-primary text-white px-5 py-[6px] inline-block min-w-[136px] transition-all duration-200 hover:bg-[#dbdbdb] hover:text-black">Compose</a>
                    <a href="{{ route('admin.email.templates.edit', $template->uid) }}"
                        class="bg-white text-[#111] px-5 py-[6px] inline-block min-w-[136px] transition-all duration-200 hover:bg-[#dbdbdb] hover:text-black">Edit</a>
                    <a href="javascript:void(0);" onclick="popupwindow('{{ route('admin.email.templates.show', $template->uid) }}', `{{ $template->name }}`, 800)"
                        class="bg-white text-[#111] px-5 py-[6px] inline-block min-w-[136px] transition-all duration-200 hover:bg-[#dbdbdb] hover:text-black">Preview</a>
                </div>
                <div
                    class="flex justify-center items-center gap-0 group-hover:gap-4 bg-white bg-opacity-40 py-[6px] w-full transition-all duration-500 absolute -bottom-1 group-hover:bottom-11">
                    <a href="###" class="export-template">
                        <div class="bg-primary h-[34px] w-[34px] flex justify-center items-center rounded-full transition-all duration-200 hover:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="19" viewBox="0 0 18 19" fill="none">
                                <path
                                    d="M0.838379 9.5C0.838379 11.6217 1.68123 13.6566 3.18152 15.1569C4.68182 16.6571 6.71665 17.5 8.83838 17.5C10.9601 17.5 12.9949 16.6571 14.4952 15.1569C15.9955 13.6566 16.8384 11.6217 16.8384 9.5"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M8.83838 11.5V1.5M8.83838 1.5L11.8384 4.5M8.83838 1.5L5.83838 4.5" stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                    <button type="button" class="thumbnail-update show-modal-btn border-0">
                        <div class="bg-primary h-[34px] w-[34px] flex justify-center items-center rounded-full transition-all duration-200 hover:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                <path
                                    d="M4.43857 2.90039C3.80205 2.90039 3.19161 3.15325 2.74152 3.60333C2.29143 4.05342 2.03857 4.66387 2.03857 5.30039V19.7004C2.03857 20.3369 2.29143 20.9474 2.74152 21.3974C3.19161 21.8475 3.80205 22.1004 4.43857 22.1004H21.2386C21.8751 22.1004 22.4855 21.8475 22.9356 21.3974C23.3857 20.9474 23.6386 20.3369 23.6386 19.7004V5.30039C23.6386 4.66387 23.3857 4.05342 22.9356 3.60333C22.4855 3.15325 21.8751 2.90039 21.2386 2.90039H4.43857ZM4.43857 20.9004C4.12031 20.9004 3.81509 20.774 3.59005 20.5489C3.365 20.3239 3.23857 20.0187 3.23857 19.7004V5.30039C3.23857 4.98213 3.365 4.67691 3.59005 4.45186C3.81509 4.22682 4.12031 4.10039 4.43857 4.10039H21.2386C21.5568 4.10039 21.8621 4.22682 22.0871 4.45186C22.3121 4.67691 22.4386 4.98213 22.4386 5.30039V19.7004C22.4386 20.0187 22.3121 20.3239 22.0871 20.5489C21.8621 20.774 21.5568 20.9004 21.2386 20.9004H4.43857Z"
                                    fill="white" />
                                <path
                                    d="M21.2385 5.2998H4.43848V17.2998H21.2385V5.2998ZM6.83848 14.8998L9.83848 11.2998L12.2385 13.6998L15.2385 10.0998L18.8385 14.8998H6.83848ZM5.63848 18.4998H20.0385V19.6998H5.63848V18.4998Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </button>
                    <button type="button" class="border-0" onclick="handleTemplateDelete(event, '{{ $template->uid }}')">
                        <div class="bg-primary h-[34px] w-[34px] flex justify-center items-center rounded-full transition-all duration-200 hover:bg-black">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                <path
                                    d="M8.45438 20.5005C8.00638 20.5005 7.62505 20.3431 7.31038 20.0285C6.99571 19.7138 6.83838 19.3328 6.83838 18.8855V6.50047H5.83838V5.50047H9.83838V4.73047H15.8384V5.50047H19.8384V6.50047H18.8384V18.8855C18.8384 19.3455 18.6844 19.7298 18.3764 20.0385C18.0684 20.3471 17.6837 20.5011 17.2224 20.5005H8.45438ZM17.8384 6.50047H7.83838V18.8855C7.83838 19.0648 7.89605 19.2121 8.01138 19.3275C8.12671 19.4428 8.27438 19.5005 8.45438 19.5005H17.2234C17.3767 19.5005 17.5177 19.4365 17.6464 19.3085C17.775 19.1805 17.839 19.0391 17.8384 18.8845V6.50047ZM10.6464 17.5005H11.6464V8.50047H10.6464V17.5005ZM14.0304 17.5005H15.0304V8.50047H14.0304V17.5005Z"
                                    fill="white" />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
        <div class="w-full text-center bg-black text-white p-3 absolute bottom-0 z-10 rounded-b template-name">
            <p class="text-sm font-medium">{{ $template->name }}</p>
        </div>
    </div>
</div>
@once
    @push('modals')
        <!-- Modal Section Starts Here -->
        <button class="show-modal-btn open-thumbnail hidden" data-target="#upload-thumb-modal">thumbnail</button>
        <section id="upload-thumb-modal" class="modal hide hidden fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
            <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[700px] overflow-hidden">
                <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>

                <form class="p-4 my-8 set-thumbnail" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex justify-center items-center gap-1 flex-col mb-5">
                        <p class="text-[#303030] text-sm font-medium">Upload image you want to set as thumbnail.</p>
                        <h4 class="template-name text-lg font-light text-center text-[#111]">WoW Sale</h4>
                        <p class="text-primary font-semibold thumb-error"></p>
                    </div>

                    <div class="w-52 mx-auto">
                        <div class="relative flex justify-center items-center mt-6 aspect-[217/326] w-full  mx-auto group">
                            <img class="thumbnail aspect-[217/326] w-52 h-auto rounded-sm shadow-sm select-none" src="" alt="" draggable="false">

                            <div class="absolute opacity-0 group-hover:opacity-100 bg-black bg-opacity-15 h-full w-full transition-all duration-300 flex justify-center items-center">
                                <input type="file" name="thumbnail" id="thumb-upload" accept="image/*" class="hidden" />
                                <label for="thumb-upload" class="bg-primary text-white py-[10px] px-[20px] min-w-36 text-center text-sm font-bold transition-all duration-200 hover:bg-black rounded-sm">
                                    Browse
                                </label>
                            </div>
                        </div>

                        <div class="w-full mt-1">
                            <button class="w-full rounded-sm py-[10px] px-5 text-white bg-primary hover:bg-black hover:text-white transition-all duration-200" type="submit">Update</button>
                        </div>
                    </div>

                </form>
            </div>
        </section>
        <!-- Modal Section Ends Here -->
    @endpush
    @push('js')
        <script>
            function popupwindow(url, title, w, h) {
                var left = (screen.width / 2) - (w / 2);
                var top = 0;
                var height = screen.height;

                if (typeof(h) !== 'undefined') {
                    height = h;
                    top = (screen.height / 2) - (height / 2);
                }

                return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + height + ', top=' +
                    top + ', left=' + left);
            }

            function handleTemplateDelete(event, uid) {
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route('admin.email.templates.destroy', ':id') }}`.replace(':id', uid),
                            type: 'POST',
                            data: {
                                _method: 'DELETE',
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                });
                                location.reload();
                            }
                        })
                    }
                })
            }

            $(document).ready(function() {
                $('.thumbnail-update').on('click', function(e) {
                    e.preventDefault();
                    const $wrapper = $(this).closest('.base-template-item');
                    const uid = $wrapper.data('template');
                    const thumbnail = $wrapper.find('.thumbnail').attr('src');
                    const templateName = $wrapper.find('.template-name p').text();
                    console.log(templateName);

                    const $modalWrapper = $('#upload-thumb-modal');
                    $modalWrapper.find('.thumb-error').text('');
                    $modalWrapper.find('.thumbnail').attr('src', thumbnail);
                    $modalWrapper.find('.template-name').text(templateName);
                    $modalWrapper.find('form').attr('action', `{{ route('admin.email.templates.thumbnail', ':id') }}`.replace(':id', uid));
                    $('.open-thumbnail').trigger('click');
                });
                $('#thumb-upload').on('change', function(e) {
                    const $form = $(this).closest('form');
                    const file = e.target.files[0];

                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const tempSrc = event.target.result;
                            $form.find('.thumbnail').attr('src', tempSrc);
                        }
                        reader.readAsDataURL(file);
                        $form.find('.thumb-error').text('');
                    } else {
                        $form.find('.thumb-error').text('Invalid file uploaded! Kindly upload valid image...');
                    }
                });

                $('.set-thumbnail').on('submit', function(e) {
                    const form = $(this);
                    e.preventDefault();
                    $.ajax({
                        url: $(form).attr('action'),
                        method: $(form).attr('method'),
                        data: new FormData(form[0]),
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log(response);
                            form[0].reset();
                            $(form).closest('.modal').find('.close-btn').trigger('click');
                            Swal.fire({
                                title: "Success!",
                                text: "Thumbnail updated successfully",
                                icon: "success",
                            });
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", xhr, status, error);
                            Swal.fire({
                                title: "Failed!",
                                text: "Failed to update thumbnail. Please try again.",
                                icon: "error",
                            });
                            if (xhr.status == 422) {
                                let error = xhr.responseJSON.errors.thumbnail;
                                $(form).find('.thumb-error').text(error[0]);
                            } else {
                                let error = xhr.responseJSON.message;
                                console.log(error);

                                $(form).find('.thumb-error').text(error);
                            }
                        }
                    })
                });


                $('.export-template').on('click', function(e) {
                    e.preventDefault();

                    const $wrapper = $(this).closest('.base-template-item');
                    const uid = $wrapper.data('template');
                    const emailTemplateUrl = `{{ route('admin.email.templates.show', ':id') }}`.replace(':id', uid);

                    $.ajax({
                        url: emailTemplateUrl,
                        method: 'GET',
                        success: function(response) {
                            const blob = new Blob([response], {
                                type: 'text/html'
                            });

                            const a = document.createElement('a');
                            a.href = URL.createObjectURL(blob);
                            a.download = 'email-template.html';
                            a.click();
                            URL.revokeObjectURL(a.href);
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                });
            });
        </script>
    @endpush
@endonce
