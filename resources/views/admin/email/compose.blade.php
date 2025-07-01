@extends('layout.email')
@push('css')
    <link rel="stylesheet" href="{{ asset('email-module/libraries/tinymce@v7.3.0/skins/ui/oxide-dark/skin.min.css') }}">
@endpush
@section('email')
    <section class="px-3 max-w-[1500px] mx-auto my-10">
        <form class="flex gap-11 flex-col" action="{{ route('admin.email.compose.send') }}" method="POST" enctype="multipart/form-data" id="compose-mail">
            @csrf
            <div class="flex justify-center items-center flex-col gap-11 w-full">
                <div class="w-full search-wrapper">
                    <div class="flex items-center">
                        <label class="text-lg font-medium block me-10" for="recipient">To</label>
                        <button type="button" class="dropdown-toggle px-5 bg-primary text-white font-semibold rounded-sm text-center" data-target="#mail-list-modal">
                            Choose Mail list
                        </button>
                    </div>
                    <div
                        class="search-dropdown hidden absolute w-full shadow-xl max-h-60 overflow-auto bg-[#f5f7fa] rounded-b before:h-[1px] before:w-[95%] before:bg-[#4444446b] before:block before:mx-auto before:top-0 before:sticky">
                        <div class="search-no-results hidden p-[0.625rem]">
                            <p>No Events Found</p>
                        </div>
                        <div class="overflow-auto w-full relative z-10 bg-[#f5f7fa]">
                            <div class="search-results hidden p-[0.625rem]">
                                <!-- Search result buttons -->
                                @foreach ($lists as $list)
                                    <button class="hidden w-full text-left p-1 rounded transition-all duration-600 hover:bg-[#72727217]"
                                        type="button" value="{{ $list->subscribers->pluck('email')->join(',') }}">
                                        {{ $list->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-[6px] w-full">
                        <select id="multiple" name="to[]" multiple class="flex items-center rounded focus:border-none bg-[#f5f7fa] mt-[6px] border-none outline-none p-[0.625rem] w-full recipients">
                            @foreach ($users as $user)
                                <option value="{{ $user->email }}">{{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="text-primary text-sm errors error_to"></span>
                </div>
                <div class="w-full">
                    <label class="text-lg font-medium block" for="subject">Subject</label>
                    <input name="subject" class="rounded bg-[#f5f7fa] block mt-[6px] border-none outline-none p-[0.625rem] w-full" id="subject" placeholder="Enter Subject for this email" type="text">
                    <span class="text-primary text-sm errors error_subject"></span>
                </div>
            </div>
            <div>
                <div class="flex items-center">
                    <label class="text-lg font-medium block me-10" for="recipient">Body</label>
                    <button type="button" class="show-modal-btn px-5 bg-primary text-white font-semibold rounded-sm text-center" data-target="#template-modal">
                        Choose Template
                    </button>
                </div>
                <span class="text-primary text-sm errors error_body"></span>
                <div class="rounded mt-[6px] flex justify-center items-center w-full">
                    <div class=" grid grid-cols-1 screen1700:grid-cols-[75%_25%] gap-4 w-full rounded">
                        <textarea name="body" id="template-editor" class="h-full w-10/12">{{ $content ?? '' }}</textarea>
                        <div class="w-full screen1700:h-full screen1700:overflow-y-auto screen1700:pr-6 screen1700:flex screen1700:flex-col screen1700:justify-between">
                            <div class="after:-content-[' '] after:block after:h-[1px] after:w-full after:bg-[#00000038] after:my-10 after:rounded-full">
                                <div class="flex flex-col gap-5">
                                    <div class="">
                                        <h5 class="text-lg font-medium">Available Tags:</h5>

                                        <div class="mt-2 grid grid-cols-1 gap-2 screen470:grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 screen1700:grid-cols-2">
                                            @foreach (tags() as $tag => $value)
                                                <button
                                                    class="bg-primary uppercase text-white py-[5px] text-center text-[14px] font-normal transition-all duration-200 hover:bg-black active:scale-95 rounded-sm"
                                                    type="button" data-value="{{ "[$tag]" }}">{{ $tag }}</button>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="attachments-wrapper">
                                <div class="attachment-preview flex flex-col gap-[10px]">
                                    <!-- Show Attachments Here -->
                                </div>

                                <div class="flex justify-between items-center text-[#444] italic my-[10px]">
                                    <input class="input-file hidden" type="file" name="attachments[]" id="attachments" multiple>
                                    <label for="attachments" class="input-label text-sm font-medium flex justify-start items-center gap-[6px]">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 20 20" fill="none">
                                            <path class="fill-primary"
                                                d="M3.4744 8.58602C3.14938 8.261 2.89155 7.87514 2.71565 7.45048C2.53975 7.02582 2.44922 6.57067 2.44922 6.11102C2.44922 5.65137 2.53975 5.19622 2.71565 4.77156C2.89155 4.3469 3.14938 3.96104 3.4744 3.63602C3.79942 3.311 4.18528 3.05318 4.60994 2.87727C5.0346 2.70137 5.48975 2.61084 5.9494 2.61084C6.40905 2.61084 6.8642 2.70137 7.28886 2.87727C7.71352 3.05318 8.09938 3.311 8.4244 3.63602L16.2024 11.414C16.8588 12.0704 17.2276 12.9607 17.2276 13.889C17.2276 14.8173 16.8588 15.7076 16.2024 16.364C15.8774 16.689 15.4915 16.9469 15.0669 17.1228C14.6422 17.2987 14.187 17.3892 13.7274 17.3892C12.7991 17.3892 11.9088 17.0204 11.2524 16.364L7.1864 12.298C7.07031 12.1819 6.97822 12.0441 6.9154 11.8924C6.85257 11.7408 6.82023 11.5782 6.82023 11.414C6.82023 11.2498 6.85257 11.0873 6.9154 10.9356C6.97822 10.7839 7.07031 10.6461 7.1864 10.53C7.30249 10.4139 7.4403 10.3218 7.59198 10.259C7.74366 10.1962 7.90622 10.1639 8.0704 10.1639C8.23457 10.1639 8.39714 10.1962 8.54881 10.259C8.70049 10.3218 8.83831 10.4139 8.9544 10.53L12.6664 14.243C12.854 14.4307 13.1085 14.5361 13.3739 14.5361C13.6393 14.5361 13.8938 14.4307 14.0814 14.243C14.269 14.0554 14.3745 13.8009 14.3745 13.5355C14.3745 13.2702 14.269 13.0157 14.0814 12.828L10.3684 9.11602C9.75702 8.51578 8.93335 8.18123 8.07658 8.18517C7.21981 8.18911 6.39925 8.53121 5.79342 9.13704C5.18758 9.74288 4.84549 10.5634 4.84155 11.4202C4.83761 12.277 5.17216 13.1006 5.7724 13.712L9.8384 17.778C10.3479 18.2944 10.9544 18.7048 11.6232 18.9858C12.2919 19.2667 13.0097 19.4126 13.735 19.415C14.4604 19.4175 15.1791 19.2764 15.8497 18.9999C16.5203 18.7235 17.1296 18.3171 17.6425 17.8042C18.1555 17.2913 18.5618 16.6819 18.8383 16.0113C19.1148 15.3407 19.2559 14.622 19.2534 13.8967C19.251 13.1713 19.1051 12.4536 18.8242 11.7848C18.5432 11.1161 18.1327 10.5095 17.6164 10L9.8384 2.22202C9.32893 1.70568 8.72236 1.29522 8.05361 1.01426C7.38485 0.733313 6.66713 0.587422 5.94177 0.584992C5.2164 0.582562 4.49771 0.72364 3.8271 1.00011C3.15648 1.27657 2.54717 1.68296 2.03425 2.19587C1.52134 2.70879 1.11495 3.3181 0.838484 3.98872C0.562019 4.65934 0.420941 5.37802 0.423371 6.10339C0.425801 6.82875 0.571691 7.54648 0.852643 8.21523C1.13359 8.88398 1.54406 9.49055 2.0604 10L2.4134 10.353C2.50558 10.4486 2.61587 10.5248 2.73783 10.5773C2.8598 10.6298 2.991 10.6575 3.12378 10.6588C3.25655 10.66 3.38825 10.6348 3.51118 10.5846C3.63411 10.5344 3.74581 10.4602 3.83977 10.3664C3.93373 10.2726 4.00806 10.161 4.05843 10.0381C4.1088 9.91527 4.13419 9.78361 4.13313 9.65083C4.13208 9.51805 4.10458 9.38681 4.05226 9.26477C3.99994 9.14273 3.92384 9.03233 3.8284 8.94002L3.4744 8.58602Z" />
                                        </svg>
                                        <div class="relative">
                                            <p
                                                class="transition-all duration-200 hover:shadow-md hover:after:-content-[' '] hover:after:bottom-0 hover:after:block hover:after:h-[1px] hover:after:w-full hover:after:bg-[#00000038] after:absolute after:w-full after:bg-[#00000038]">
                                                Attach a File</p>
                                        </div>
                                    </label>


                                    <label class="text-xs font-normal">
                                        (Allowed types: jpg, png, jpeg, webp, svg, mp4, doc, pdf, docx, xlsx)
                                    </label>
                                </div>
                                <span class="text-primary text-sm errors error_attachments"></span>

                                <div class="w-full">
                                    <!-- <button class="bg-primary w-full text-white px-5 py-[0.5rem] rounded-sm transition-all duration-200 hover:bg-black hover:text-white" type="submit">Submit</button> -->
                                    <button class="bg-primary block w-full text-center text-white px-5 py-[0.5rem] rounded-sm transition-all duration-200 hover:bg-black hover:text-white"
                                        type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    @push('modals')
        <!-- Modal Section Starts Here -->
        <section id="template-modal" class="modal hide hidden fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
            <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[1200px] overflow-hidden">
                <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>
                <div>
                    <div class="rounded mt-[6px] bg-[#f5f7fa] flex justify-center items-center w-full py-4">
                        <div class="h-[50vh] overflow-y-auto w-full rounded">
                            <!-- <a href="###" class="bg-primary text-white font-semibold px-5 py-[10px] rounded-sm select-none">Choose Template</a> -->
                            <!-- Template Overlay -->
                            <div class="m-4 overflow-hidden">

                                <label class="text-lg font-medium block" for="recipient">Select Template</label>
                                <span class="text-primary fw-bold" id="text_template"></span>
                                <div
                                    class="template-slider mt-7 grid grid-cols-1 gap-6 screen400:grid-cols-2 sm:grid-cols-3 screen768:grid-cols-4 lg:grid-cols-5 screen1200:grid-cols-6 screen1367:grid-cols-7 items-center">
                                    @foreach ($templates as $template)
                                        <label for="{{ "template-{$loop->iteration}" }}" class="cursor-pointer template-card-item select-none">
                                            <div class="relative group hover:scale-95 transition-all duration-500">
                                                <div class="w-full overflow-hidden rounded">
                                                    <img class="card-item-img object-cover h-56 w-full select-none" src="{{ asset("uploads/thumbnails/$template->thumbnail") }}" alt="Template 1"
                                                        draggable="false">
                                                    <div class="bg-black text-center text-white text-sm font-medium p-[6px]">
                                                        <p>{{ $template->name }}</p>
                                                    </div>
                                                </div>
                                                <button
                                                    class="checkbox-btn h-1 w-1 p-3 rounded-full flex justify-center items-center fa-solid fa-circle-notch text-xl text-white shadow-2xl group-hover:rotate-[360deg] transition-all duration-500 cursor-pointer absolute top-2 right-2"
                                                    type="button">
                                                    <input type="checkbox" name="template" value="{{ $template->uid }}" id="{{ 'template-' . $loop->iteration }}" class="hidden checkbox-input">
                                                </button>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>

                            </div>
                            <!-- Template Overlay -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal Section Ends Here -->
        <button class="hidden show-modal-btn progress-btn" data-target="#progress-modal">show</button>
        <!-- Modal Section Starts Here -->
        <section id="progress-modal" class="modal hide hidden fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
            <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[1200px] overflow-hidden">
                <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>
                <div>
                    <div class="flex justify-center items-center">
                        <div class="w-[80%]">
                            <div class="flex justify-center items-center gap-4">
                                <div class="h-[16px] w-full bg-[#bebebe] rounded-full">
                                    <div style="width: 0%;" class="progress-bar h-full bg-info rounded-full progress-bar-striped progress-bar-animated"></div>
                                </div>
                                <p class="progress-emails text-xl font-bold">0%</p>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex justify-center items-center gap-4 font-semibold text-lg">
                                    <div>Total: <span class="total-emails text-info font-bold">0</span></div> |
                                    <div>Sent: <span class="sent-emails text-success font-bold">0</span></div> |
                                    <div>Failed: <span class="failed-emails text-primary font-bold">0</span></div>
                                </div>
                                <a href="javascript:void(0)" class="read-more text-primary font-bold hover:underline">Read more</a>
                            </div>
                        </div>
                    </div>
                    <div class="detailed-emails rounded mt-[6px] flex justify-center items-center w-full py-4 hidden">
                        <div class="h-[50vh] overflow-y-auto w-full rounded">
                            <table class="min-w-full bg-[#f4f4f4] border-collapse">
                                <thead>
                                    <tr>
                                        <th class="p-[10px] text-left font-semibold">Email</th>
                                        <th class="p-[10px] text-center font-semibold"></th>
                                        <th class="p-[10px] text-end font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="email-status"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal Section Ends Here -->
    @endpush
@endsection
@push('js')
    {{-- <script type="text/javascript" src="{{ asset('core/tinymce/tinymce.min.js') }}"></script> --}}
    <script src="{{ asset('email-module/libraries/tinymce@v7.3.0/tinymce.min.js') }}"></script>
    <script src="{{ asset('email-module/libraries/slim-select@2.10.0/js/slimselect.min.js') }}"></script>
    <script src="{{ asset('email-module/js/template-editor.js') }}"></script>
    <script src="{{ asset('email-module/js/attachment-uploader.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @vite(['resources/js/compose.js'])
    <script>
        $(document).ready(function() {

            $("input[name='template']").on("change", function() {
                const uid = $(this).val();
                $.ajax({
                    type: "GET",
                    url: `{{ route('admin.email.templates.show', ':id') }}`.replace(
                        ":id",
                        uid
                    ),
                    success: function(response) {
                        $('textarea[name="template_body"]').html(response);
                        tinymce.get("template-editor").setContent(response);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error);
                    },
                });
                $(this).closest(".modal").find(".close-btn").trigger("click");
            });

            $('.read-more').on('click', function() {
                const $detailedEmails = $('.detailed-emails');
                if ($detailedEmails.is(':hidden')) {
                    $detailedEmails.stop(true, true).slideDown();
                    $(this).text('Read less');
                } else {
                    $detailedEmails.stop(true, true).slideUp();
                    $(this).text('Read more');
                }
            });


        });
        
        
    
let totalEmails = 0,
    sentEmails = 0,
    failedEmails = 0,
    progress = 0;

$(document).ready(function () {
    const select = new SlimSelect({
        select: "#multiple",
        settings: {
            placeholderText: "Select Email Recipients",
        },
    });

    $(".search-results button").on("click", function (e) {
        var selectedEmails = $(this).attr("value").split(",");

        select.setData(
            $("#multiple option")
                .map(function () {
                    return {
                        text: $(this).text(),
                        value: $(this).val(),
                    };
                })
                .get()
        );

        select.setSelected(selectedEmails);

        $("#multiple").trigger("change");
    });
    $(".dropdown-toggle").on("click", function () {
        select.close();
    });

    $("#compose-mail").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);

        totalEmails = select.getSelected().length;

        const selectedEmails = select.getSelected();
        $("#multiple").val(selectedEmails);

        const formData = new FormData(form[0]);

        $(".errors").text("");
        $.ajax({
            url: form.attr("action"),
            method: form.attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                form[0].reset();
                select.setSelected([]);
                emailProgress(sentEmails, failedEmails, totalEmails);
                $(".progress-btn").trigger("click");
                /*Swal.fire({
                    title: "Success!",
                    text: "Email sent successfully.",
                    icon: "success",
                });*/
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr, status, error);
                Swal.fire({
                    title: "Failed!",
                    text: "Failed to send email. Please try again.",
                    icon: "error",
                });
                if (xhr.status == 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, error) {
                        if (field.includes("attachments.")) {
                            $(".error_attachments").append(error[0] + "<br />");
                        } else {
                            $(".error_" + field).text(error[0]);
                        }
                    });
                }
            },
        });
    });
});

function emailProgress(sentEmails, failedEmails, totalEmails) {
    progress = (((sentEmails + failedEmails) / totalEmails) * 100).toFixed(0);
    $(".total-emails").text(totalEmails);
    $(".sent-emails").text(sentEmails);
    $(".failed-emails").text(failedEmails);
    $(".progress-emails").text(progress + "%");
    $(".progress-bar").css("width", progress + "%");
    console.log(
        `Total: ${totalEmails}, Sent: ${sentEmails}, Failed: ${failedEmails}, Progress: ${progress}`
    );
    return progress;
}
        Pusher.logToConsole = true;

        var pusher = new Pusher("39539b20dded4713af2a", {
            cluster: "ap2",
        });
        var channel = pusher.subscribe("emailing");
        channel.bind("MailEvent", (data) => {
            console.log(data);
            const tbody = document.getElementById("email-status");
            let row = null;
            if (data.status === "failed") {
                ++failedEmails;
                progress = emailProgress(sentEmails, failedEmails, totalEmails);
                row = `
                    <tr class="text-black text-sm font-medium">
                        <td class="p-[10px] w-[10%]">${data.to}</td>
                        <td class="p-[10px] w-[80%]">
                            <div class="h-1 w-full bg-[#bebebe] rounded-full">
                                <div class="h-full w-full bg-primary rounded-full"></div>
                            </div>
                        </td>
                        <td class="p-[10px] text-end w-[10%]">
                            <button class="text-primary flex justify-end items-center w-full group">
                                <svg class="transition-all duration-300 group-active:rotate-[360deg]" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                                    <path class="fill-primary group-active:fill-black" d="M12.4253 18.5684C12.4253 18.7673 12.3463 18.958 12.2056 19.0987C12.065 19.2393 11.8742 19.3184 11.6753 19.3184C7.8833 19.3184 4.7793 16.3134 4.7793 12.5684C4.7793 8.82336 7.8833 5.81836 11.6753 5.81836C14.7803 5.81836 17.4243 7.83336 18.2803 10.6194L18.8833 9.59936C18.9845 9.42803 19.1496 9.30391 19.3423 9.25431C19.535 9.2047 19.7395 9.23368 19.9108 9.33486C20.0821 9.43604 20.2062 9.60114 20.2558 9.79383C20.3055 9.98652 20.2765 10.191 20.1753 10.3624L18.5453 13.1174C18.4455 13.2864 18.2834 13.4095 18.0938 13.4604C17.9042 13.5112 17.7023 13.4857 17.5313 13.3894L14.7093 11.7984C14.6235 11.75 14.548 11.6851 14.4873 11.6076C14.4265 11.53 14.3816 11.4413 14.3551 11.3464C14.3287 11.2515 14.3212 11.1523 14.333 11.0545C14.3449 10.9567 14.3759 10.8622 14.4243 10.7764C14.4727 10.6905 14.5375 10.6151 14.6151 10.5543C14.6926 10.4936 14.7814 10.4487 14.8763 10.4222C14.9712 10.3957 15.0704 10.3882 15.1682 10.4001C15.266 10.412 15.3605 10.443 15.4463 10.4914L16.9183 11.3214C16.3443 9.03336 14.2273 7.31836 11.6763 7.31836C8.6783 7.31836 6.2793 9.68536 6.2793 12.5684C6.2793 15.4514 8.6783 17.8184 11.6753 17.8184C11.8742 17.8184 12.065 17.8974 12.2056 18.038C12.3463 18.1787 12.4253 18.3694 12.4253 18.5684Z" />
                                </svg>
                                ${
                                    data.status.charAt(0).toUpperCase() +
                                    data.status.slice(1).toLowerCase()
                                }
                            </button>
                        </td>
                    </tr>
                `;
            } else {
                ++sentEmails;
                progress = emailProgress(sentEmails, failedEmails, totalEmails);
                row = `
                    <tr class="text-black text-sm font-medium">
                        <td class="p-[10px] w-[10%]">${data.to}</td>
                        <td class="p-[10px] w-[80%]">
                            <div class="h-1 w-full bg-[#bebebe] rounded-full">
                                <div class="h-full w-full bg-success rounded-full"></div>
                            </div>
                        </td>
                        <td class="p-[10px] text-end w-[10%]">${
                            data.status.charAt(0).toUpperCase() +
                            data.status.slice(1).toLowerCase()
                        }</td>
                    </tr>
                `;
            }
            tbody.insertAdjacentHTML("beforeend", row);
            console.log(data);
        });

    </script>
@endpush
