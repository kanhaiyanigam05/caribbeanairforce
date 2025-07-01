<!-- Post Event Modal Menu Starts Here -->
<form method="post" action="{{ route('admin.membership.store') }}" enctype="multipart/form-data" id="membership-form">
    @csrf
    <input type="hidden" name="id" />s
    <div id="create-event-modal" class="modal-wrapper">
        <div class="base-event-modal-wrapper">
            <div class="bg-white" id="create-event-container">
                <div class="base-event-dp-modal">
                    <button type="button" class="hidden modal-event-back-btn" onclick="handleBackEventCreateModal(); resetMembershipData()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#000" class="bi bi-arrow-left"
                            viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8">
                            </path>
                        </svg>
                    </button>
                    <!-- 14-11-2024 -->
                    <button type="button" class="modal-event-close-btn default-close-btn"
                        onclick="handleHideEventCreateModal(); resetMembershipData()">
                        <svg width="28" height="29" viewBox="0 0 28 29" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="close-btn-icon">
                            <path
                                d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
                <!-- 14-11-2024 -->
                <div id="create-event-modal-inner">
                    <!-- Organizer's Info -->
                    <div id="organizer-name-wrapper" class="modal-inner-content-wrapper border-box">
                        <h3 class="modal-heading border-box">Create Membership Plan</h3>
                        <div class="base-form-event-wrapper border-box">
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box organizer-item">
                                <label for="title" class="transition border-box">Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full transition event-input border-box" placeholder="Your Name" />
                                <p class="error-text border-box" id="title-error"></p>
                            </div>
                            <div class="flex items-start justify-start mb-1 transition flex-column gap-05 border-box organizer-item">
                                <label for="description" class="transition border-box">Description</label>
                                <textarea name="description" rows="5" id="description" class="w-full event-input"
                                    placeholder="Enter a brief description of your event"></textarea>
                                <p class="error-text border-box" id="description-error"></p>
                            </div>
                            <div class="flex items-start justify-start transition flex-column gap-05 border-box">
                                <!-- 14-11-2024 -->
                                <button type="submit"
                                    class="w-full text-white transition base-form-event-wrapper-btn border-box create-event-default-btn">Submit</button>
                                <!-- 14-11-2024 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Post Event Modal Menu Ends Here -->

@push('js')
    <script>
        $(document).ready(function() {
            $('#membership-form').on('submit', function(e) {
                e.preventDefault();
                ajaxLoader($(this).find('.create-event-default-btn'), 'Submit');
                // Reset error messages
                $('.error-text').text('');
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success'
                        }).then((result) => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while creating membership plan.',
                            icon: 'error'
                        });
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + '-error').text(value[0]);
                            });
                        }
                    }
                })
            });
        });
    </script>
@endpush
