@extends('layout.profile')
@section('profile')
<section class="events-section-inner suggestions-wrapper pb-50px">
    <div class="suggestions-inner-wrapper">

        <div class="suggestions-heading-wrapper">
            <h2 class="suggestions-heading">People you follow</h2>
        </div>


        <div class="suggestions-main">

            @foreach ($followings as $follower)
            <div class="suggestions-user-card-wrapper" id="connection-card-{{ $follower->id }}">
                <a href="{{ route('admin.profile', $follower->username) }}"
                    class="suggestions-user-card-image-wrapper-2">
                    <img class="suggestions-user-card-image-2" src="{{ $follower->profile }}" alt="connection"
                        draggable="false">
                </a>
                <div class="w-full suggestions-user-card-info-wrapper">
                    <p class="basic-connection-name">{{ $follower->full_name }}</p>
                    <button type="button" class="suggestions-connect-a-tag connection-request-{{ $follower->id }}"
                        onclick="handleUnfollow(event, {{ $follower->id }})">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Unfollow
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        {{ $followings->links('vendor.pagination.custom') }}
    </div>
</section>
@endsection
@push('js')
<script>
    function handleUnfollow(e, id) {
        e.preventDefault();
        ajaxLoader('.connection-request-' + id, '<i class="fa-solid fa-arrow-right-from-bracket"></i> Unfollow');

        $.ajax({
            type: "POST",
            url: `{{ route('admin.unfollow', ':id') }}`.replace(':id', id),
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message
                    });

                    // Remove the request card from the DOM
                    $('#connection-card-' + id).remove();
                }
                else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr);
            }
        });
    }
</script>
@endpush
