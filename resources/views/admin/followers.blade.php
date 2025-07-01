@extends('layout.profile')
@section('profile')
<section class="events-section-inner suggestions-wrapper pb-50px">
    <div class="suggestions-inner-wrapper">

        <div class="suggestions-heading-wrapper">
            <h2 class="suggestions-heading">People who follow you</h2>
        </div>


        <div class="suggestions-main">

            @foreach ($followers as $follower)
            <div class="suggestions-user-card-wrapper" id="connection-card-{{ $follower->id }}">
                <a href="{{ route('admin.profile', $follower->username) }}"
                    class="suggestions-user-card-image-wrapper-2">
                    <img class="suggestions-user-card-image-2" src="{{ $follower->profile }}" alt="connection"
                        draggable="false">
                </a>
                <div class="w-full suggestions-user-card-info-wrapper">
                    <p class="basic-connection-name">{{ $follower->full_name }}</p>
                    @if (!Auth::user()->following->contains($follower->id) && Auth::user()->id !== $follower->id)
                    <button type="button" class="suggestions-connect-a-tag connection-request-{{ $follower->id }}"
                        onclick="handleFollow(event, {{ $follower->id }})">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Follow
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        {{ $followers->links('vendor.pagination.custom') }}
    </div>
</section>
@endsection
@push('js')
<script>
    function handleFollow(e, id) {
            e.preventDefault();
            ajaxLoader('.connection-request-'+id, '<i class="fa-solid fa-arrow-right-from-bracket"></i> Follow');

            $.ajax({
                type: "POST",
                url: `{{ route('admin.follow', ':id') }}`.replace(':id', id),
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        });

                        // Remove the suggestion card from the DOM
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
                error: function(xhr, status, error) {
                    console.log(xhr);
                }
            });
        }
</script>
@endpush
