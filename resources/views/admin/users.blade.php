@extends('layout.app')
@push('css')
    <style>
        .suggestions-wrapper {
            max-width: 1200px;
            margin: auto;
            padding: 1rem;
        }

        .all-user-wrapper {
            display: flex;
            flex-direction: column;
            gap: 5px;
            overflow-y: auto;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .user-table th,
        .user-table td {
            padding: 15px;
            text-align: left;
            border: 1px solid rgba(0, 0, 0, 0.1);
            vertical-align: middle;
        }

        .user-table th {
            background-color: #f4f4f4;
        }

        .user-table td img {
            border-radius: 50%;
            width: 45px;
            height: 45px;
            margin: auto;
            display: flex;
        }

        @media (max-width: 768px) {
            .user-table thead {
                display: none;
            }

            .user-table,
            .user-table tbody,
            .user-table tr,
            .user-table td {
                display: block;
                width: 100%;
            }

            .user-table td {
                display: flex;
                justify-content: space-between;
                padding: 10px;
            }

            .user-table td:not(:last-child) {
                border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            }

            .user-table td:before {
                content: attr(data-label);
                font-weight: bold;
                margin-right: 10px;
            }

            .user-table td img {
                width: 35px;
                height: 35px;
            }
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .pb-2 {
            padding-bottom: 0.5rem;
        }

        .switch-input {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .cards-ticket-read-more {
            text-transform: uppercase;
            background-color: #bd191f;
            color: white;
            cursor: pointer;
            text-decoration: none;
            text-wrap: nowrap;
            user-select: none;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            padding: 11px 21px;
            display: flex;
            font-size: 14px;
            font-weight: 600;
            border-radius: 4px;
            /* width: 100%; */
            line-height: normal;
        }

        .cards-ticket-read-more:hover {
            background-color: black;
            color: white;
        }

        .cards-ticket-read-more:hover .text {
            color: white;
        }

        .cards-ticket-read-more:hover .edit-icon-box {
            fill: white;
        }

        .padding-bottom {
            padding-bottom: 20px;
        }

        .suggestions-connect-a-tag.warning {
            background-color: #ffc107;
            color: var(--secondary-color);
        }
    </style>
@endpush
@section('admin')
    <section class="events-section-inner px-15px profile-body-content-wrapper">
        <div class="all-events-heading-wrapper padding-bottom">
            <h1 class="all-events-heading">Membership Plans</h1>
            <button onclick="handleCreateEventModalShow()" class="cards-ticket-read-more" type="button">Create Membership Plan</button>
            @push('modals')
                @include('models.membership')
            @endpush
        </div>
    </section>

    <!-- Suggestion Section Ends Here -->
    <section class="suggestions-wrapper">
        <div class="all-user-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($membershipPlans as $plan)
                        <tr>
                            <td>
                                <p class="basic-connection-name pb-2">{{ $plan->title }}</p>
                            </td>
                            <td>
                                <p class="basic-connection-name pb-2">{{ $plan->description }}</p>
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    <button type="button" class="suggestions-connect-a-tag warning me-2 text-primary" onclick="handleCreateEventModalShow(); setMembershipData({{ $plan->id }})">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.membership.destroy', $plan->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="suggestions-connect-a-tag text-primary me-2 destroy"
                                            style="width: fit-content;"><i class="fa fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="events-section-inner px-15px profile-body-content-wrapper">
        <div class="all-events-heading-wrapper">
            <h1 class="all-events-heading">All Users</h1>
            <form action="{{ route('admin.user.search') }}" method="post" class="search-wrapoper-form">
                @csrf
                <div class="search-wrapoper">
                    <div class="relative">
                        <input class="search-input" type="text" name="search" placeholder="Search User?"
                            oninput="handleSearchDropdown(this)">
                        <button class="search-icon-button" type="submit">
                            <img class="search-icon" src="{{ asset('admins/images/search.svg') }}" alt="search">
                        </button>
                        <div class="search-dropdown-main-wrapper">
                            <div class="search-items-inner-wrapper">
                                <div class="search-no-results hidden">
                                    <p>No Users Found</p>
                                </div>
                                <div class="search-results hidden">
                                    <div class="search-dropdown-wrapper">

                                        @foreach ($searchUsers as $user)
                                            <a href="javascript:void(0);">{{ $user->username }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Suggestion Section Ends Here -->
    <section class="suggestions-wrapper">
        <div class="all-user-wrapper">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name & Role</th>
                        <th>Change Role</th>
                        <th>Membership</th>
                        <th>Block</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->profile }}" alt="Avatar">
                            </td>
                            <td>
                                <p class="basic-connection-name pb-2">{{ $user->full_name }}</p>
                                <p class="basic-connection-name">
                                    {{ $user->role == \App\Enums\Role::SUPERADMIN ? 'Super Admin' : ($user->role == \App\Enums\Role::ORGANIZER ? 'Event Organizer' : 'User') }}
                                </p>
                            </td>
                            <td>
                                <div class="switch-user">
                                    <select name="" id="" class="switch-input" onchange="handleUserRoleChange(event, {{ $user->id }})">
                                        <option value="">Select Role</option>
                                        <option value="{{ \App\Enums\Role::SUPERADMIN }}" @if ($user->role == \App\Enums\Role::SUPERADMIN) selected @endif>Super Admin</option>
                                        <option value="{{ \App\Enums\Role::ORGANIZER }}" @if ($user->role == \App\Enums\Role::ORGANIZER) selected @endif>Event Organizer</option>
                                        <option value="{{ \App\Enums\Role::USER }}" @if ($user->role == \App\Enums\Role::USER) selected @endif>User</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="switch-user">
                                    <select name="" id="" class="switch-input" onchange="handleMembership(event, {{ $user->id }})">
                                        <option value="">Select Membership</option>
                                        @foreach ($membershipPlans as $plan)
                                            <option value="{{ $plan->id }}" @if ($plan->id === $user->membership?->plan_id) selected @endif>{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <a href="javascript:void(0);" onclick="handleUserBlock(event, {{ $user->id }})" class="text-primary block">{{ $user->block == true ? 'Unblock' : 'Block' }}</a>
                            </td>
                            <td>
                                <div class="flex justify-center items-center">
                                    @if ($user->role !== \App\Enums\Role::SUPERADMIN)
                                        <a href="javascript:void(0);" onclick="handleUserDelete(event, {{ $user->id }})" class="suggestions-connect-a-tag text-primary me-2 destroy"
                                            style="width: fit-content;"><i class="fa fa-trash-alt"></i></a>
                                    @endif
                                    <a href="{{ route('admin.profile', $user->username) }}" class="text-primary"><i class="fa-solid fa-external-link"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('js')
    <script>
        function handleUserRoleChange(e, id) {
            e.preventDefault();
            const btn = $(e.currentTarget).closest('td').find('.switch-user').html();
            ajaxLoader($(e.currentTarget).closest('td').find('.switch-user'), btn);
            $.ajax({
                url: `{{ route('admin.users.role', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'PUT',
                    _token: "{{ csrf_token() }}",
                    role: $(e.currentTarget).val()
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
            const btn = $(e.currentTarget).closest('td').find('.block').html();
            ajaxLoader($(e.currentTarget).closest('td').find('.block'), btn);
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
            const btn = $(e.currentTarget).closest('td').find('.destroy').html();
            ajaxLoader($(e.currentTarget).closest('td').find('.destroy'), btn);
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
                            location.reload();
                        });
                        location.reload();
                    }
                }
            });
        }

        function setMembershipData(id) {
            const $form = $('#membership-form');
            $.ajax({
                url: `{{ route('admin.membership.edit', ':id') }}`.replace(':id', id),
                type: 'GET',
                success: function(response) {
                    $form.find('.modal-heading').text('Edit Membership Plan');
                    $form.find('input[name="id"]').val(response.id);
                    $form.find('#title').val(response.title);
                    $form.find('#description').val(response.description);
                }
            })
        }

        function resetMembershipData() {
            const $form = $('#membership-form');
            $form.find('.modal-heading').text('Create Membership Plan');
            $form.find('.error-text').text('');
            $form.find('input[name="id"]').val('');
            $form.find('#title').val('');
            $form.find('#description').val('');
        }

        function handleMembership(e, id) {
            e.preventDefault();
            const btn = $(e.currentTarget).closest('td').find('.switch-user').html();
            ajaxLoader($(e.currentTarget).closest('td').find('.switch-user'), btn);
            $.ajax({
                url: `{{ route('admin.users.membership', ':id') }}`.replace(':id', id),
                type: 'POST',
                data: {
                    _method: 'PUT',
                    _token: "{{ csrf_token() }}",
                    plan_id: $(e.currentTarget).val()
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'User Membership Changed',
                            text: response.message
                        }).then((result) => {
                            location.reload();
                        });
                        // location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            })
        }
    </script>
@endpush
