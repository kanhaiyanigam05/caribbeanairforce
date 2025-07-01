@extends('layout.email')
@push('css')
    {{--  --}}
@endpush
@section('email')
    @if (Route::currentRouteName() === 'admin.email.lists.index')
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h1 class="text-center">All Mail Lists</h1>
                        <a href="{{ route('admin.email.lists.create') }}"><button class="btn btn-primary">Add New Mail list</button></a>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Total Subscribers</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <th scope="row">{{ $list->name }}</th>
                                    <td>{{ $list->created_at?->format('F j, Y') }}</td>
                                    <td>{{ $list->subscribers?->count() }}</td>
                                    <th class="d-flex gx-3 justify-content-between">
                                        <a href="{{ route('admin.email.lists.edit', $list->id) }}"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('admin.email.lists.destroy', $list->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this Mail list?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
    @if (Route::currentRouteName() === 'admin.email.lists.create')
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1>Create Mail List</h1>
                    <form action="{{ route('admin.email.lists.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" class="form-control" id="name" placeholder="name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="subscribers" class="form-label">Subscribers</label>
                            <select name="subscribers[]" class="form-control" id="subscribers" placeholder="subscribers" multiple>
                                @foreach ($subscribers as $subscriber)
                                    <option value="{{ $subscriber->id }}">{{ $subscriber->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary">Create Mail list</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
    @if (Route::currentRouteName() === 'admin.email.lists.edit')
        <div class="container py-5">
            <div class="row">
                <div class="col-12">
                    <h1>Update Mail list</h1>
                    <form action="{{ route('admin.email.lists.update', $list) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input name="name" class="form-control" id="name" placeholder="name" value="{{ $list->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="description">{{ $list->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="subscribers" class="form-label">Subscribers</label>
                            <select name="subscribers[]" class="form-control" id="subscribers" placeholder="subscribers" multiple>
                                @foreach ($subscribers as $subscriber)
                                    <option value="{{ $subscriber->id }}"
                                        @if ($list->subscribers->pluck('id')->contains($subscriber->id)) selected @endif>
                                        {{ $subscriber->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary">Update Mail list</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('js')
    {{--  --}}
@endpush
