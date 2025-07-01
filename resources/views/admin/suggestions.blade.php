@extends('layout.profile')
@section('profile')
{{-- <section class="events-section-inner px-15px">
    <div class="profile-body-content-wrapper">
        <h3 class="connections-heading">Connection Suggestions</h3>

        <div class="connections-list-wrapper">
            @foreach ($suggestions as $suggestion)
            <div class="connection-card" id="connection-card-{{ $suggestion->id }}">
                <div class="connection-list-card">
                    <img class="select-none object-cover connections-list-img" src="{{ $suggestion->profile }}" alt=""
                        draggable="false" />
                    <div class="connection-card-item">
                        <p class="card-name">{{ $suggestion->full_name }}</p>
                        <p class="card-designation">{{ $suggestion->role }}</p>
                        <a href="###" class="card-unfollow-btn">Unfollow</a>
                    </div>
                </div>
                <button type="button" onclick="handleFollow(event, {{ $suggestion->id }})"
                    class="card-unfollow-btn-lg connection-request">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Send Request
                </button>
            </div>
            @endforeach
        </div>
    </div>

    {{ $suggestions->links('vendor.pagination.custom') }}
    {{-- <div class="paginator-wrapper">
        <a href="###" class="paginator-btn">
            <i class="fa-solid fa-chevron-right"></i>
            <p>Previous</p>
        </a>
        <a href="###" class="paginator-btn">2</a>
        <a href="###" class="paginator-btn active-paginator-btn">3</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">10</a>
        <a href="###" class="paginator-btn">15</a>
        <a href="###" class="paginator-btn">
            <p>Next</p>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>


    <div class="paginator-wrapper">
        <a href="###" class="paginator-btn disabled-paginator-btn">
            <i class="fa-solid fa-chevron-right"></i>
            <p>Previous</p>
        </a>
        <a href="###" class="paginator-btn active-paginator-btn">1</a>
        <a href="###" class="paginator-btn">2</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">.</a>
        <a href="###" class="paginator-btn">10</a>
        <a href="###" class="paginator-btn">15</a>
        <a href="###" class="paginator-btn">
            <p>Next</p>
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div> --}
</section> --}}

<!-- Suggestion Section Starts Here -->
<section class="events-section-inner suggestions-wrapper pb-50px">
    <div class="suggestions-inner-wrapper">

        <div class="suggestions-heading-wrapper">
            <h2 class="suggestions-heading">People you may know</h2>
            <a href="{{ route('admin.suggestions') }}" class="see-all-suggestions">See all</a>
        </div>


        <div class="suggestions-main">

            @foreach ($suggestions as $suggestion)
            <div class="suggestions-user-card-wrapper" id="connection-card-{{ $suggestion->id }}">
                <a href="{{ route('admin.profile', $suggestion->username) }}"
                    class="suggestions-user-card-image-wrapper-2">
                    <img class="suggestions-user-card-image-2" src="{{ $suggestion->profile }}" alt="connection"
                        draggable="false">
                </a>
                <div class="w-full suggestions-user-card-info-wrapper">
                    <p class="basic-connection-name">{{ $suggestion->full_name }}</p>
                    <button type="button" class="suggestions-connect-a-tag connection-request-{{ $suggestion->id }}"
                        onclick="handleFollow(event, {{ $suggestion->id }})">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Follow
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        {{ $suggestions->links('vendor.pagination.custom') }}
    </div>
</section>
<!-- Suggestion Section Ends Here -->
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
