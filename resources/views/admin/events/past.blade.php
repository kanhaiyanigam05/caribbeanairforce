@extends('layout.profile')
@section('profile')
    @if($events->isNotEmpty())
        <section class="events-section-inner px-15px profile-body-content-wrapper item-row pb-50px">
            @foreach ($events as $event)
                {{--            <x-event-card :event="$event" editable />--}}
                <x-card :event="$event" admin editable/>
            @endforeach
        </section>
    @else
        <section>
            <div class="flex justify-center items-center">
                <img src="{{ asset('asset/images/no-event-found.png') }}" alt="">
            </div>
        </section>
    @endif
    {{ $events->links('vendor.pagination.custom') }}
@endsection
