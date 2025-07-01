@props(['user' => []])

<div id="connection-card-{{ $user->id }}" class="suggestions-user-card-wrapper">
    <div class="suggestions-user-card-image-wrapper">
        <div class="absolute feed-card-menu" onclick="handleCardsDropdown(this)">
            <button class="feed-card-menu-drop-downmenu-btn" id="event-btn-{{ $user->id }}"
                    aria-label="Menu">
                <span class="material-symbols-outlined"> more_vert </span>
            </button>
            <div class="absolute card-dropdown-wrapper">
                <div class="dropdown card-dropdown-inner-wrapper">
                    <a href="javascript:void(0);"
                       onclick="handleUserRoleChange(event, {{ $user->id }}, '{{ \App\Enums\Role::SUPERADMIN }}')"
                       @if($user->role == \App\Enums\Role::SUPERADMIN) class="active"@endif>
                        <span class="fa fa-user"></span>
                        <p>Super Admin</p>
                    </a>
                    <a href="javascript:void(0);"
                       onclick="handleUserRoleChange(event, {{ $user->id }}, '{{ \App\Enums\Role::ORGANIZER }}')"
                       @if($user->role == \App\Enums\Role::ORGANIZER) class="active" @endif>
                        <span class="fa fa-user"></span>
                        <p>Event Organizer</p>
                    </a>
                    <a href="javascript:void(0);"
                       onclick="handleUserRoleChange(event, {{ $user->id }}, '{{ \App\Enums\Role::USER }}')"
                       @if($user->role == \App\Enums\Role::USER) class="active" @endif>
                        <span class="fa fa-user"></span>
                        <p>User</p>
                    </a>
                    <a href="javascript:void(0);" onclick="handleUserBlock(event, {{ $user->id }})"
                       @if($user->block == true) class="active" style="padding-bottom: 0.5rem
                                        !important" @endif>
                        <span class="material-symbols-outlined"> block </span>
                        <p>{{ $user->block == true ? 'Unblock' : 'Block' }}</p>
                    </a>
                    @if($user->role !== \App\Enums\Role::SUPERADMIN)
                        <a href="javascript:void(0);" onclick="handleUserDelete(event, {{ $user->id }})">
                            <span class="material-symbols-outlined"> delete </span>
                            <p>Delete</p>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <img class="suggestions-user-card-image" src="{{ $user->profile }}" alt="connection"
             draggable="false">
    </div>
    <div class="w-full suggestions-user-card-info-wrapper">
        <p class="basic-connection-name" style="text-wrap: wrap !important;">{{ $user->full_name }}&emsp;|&emsp;{{ $user->username }}</p>
        <p class="basic-connection-name">
            @if ($user->role === \App\Enums\Role::SUPERADMIN)
                Super Admin
            @elseif ($user->role === \App\Enums\Role::ORGANIZER)
                Event Organizer
            @else
                User
            @endif
        </p>
        <a href="{{ route('admin.profile', $user->username) }}"
           class="suggestions-connect-a-tag connection-request">
            <i class="fa-solid fa-arrow-right-from-bracket"></i>
            View Profile
        </a>
    </div>
</div>
@push('css')

@endpush
@push('js')
    <script>
        function handleUserRoleChange(e, id, role) {
            e.preventDefault();
            const btn = $(e.currentTarget).closest('.suggestions-user-card-wrapper').find('.feed-card-menu-drop-downmenu-btn').html();
            ajaxLoader('#event-btn-' + id, btn);
            $.ajax({
                url: `{{ route('admin.users.role', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'PUT',
                    _token: "{{ csrf_token() }}",
                    role: role
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User Role Changed',
                            text: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        // location.reload();
                    }
                }
            });
        }
        function handleUserBlock(e, id) {
            e.preventDefault();
            const btn = $(e.currentTarget).closest('.suggestions-user-card-wrapper').find('.feed-card-menu-drop-downmenu-btn').html();
            ajaxLoader('#event-btn-' + id, btn);
            $.ajax({
                url: `{{ route('admin.users.block', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'PUT',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                        // location.reload();
                    }
                }
            });
        }
        function handleUserDelete(e, id) {
            e.preventDefault();
            const btn = $(e.currentTarget).closest('.suggestions-user-card-wrapper').find('.feed-card-menu-drop-downmenu-btn').html();
            ajaxLoader('#event-btn-' + id, btn);
            $.ajax({
                url: `{{ route('admin.users.destroy', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then((result) => {
                                $('#connection-card-' + id).remove();
                        });
                        // location.reload();
                    }
                }
            });
        }
    </script>
@endpush