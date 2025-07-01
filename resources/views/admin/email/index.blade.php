@extends('layout.email')
@push('css')
    {{--  --}}
@endpush
@section('email')
    <section class="px-3 max-w-[1500px] mx-auto my-10">
        <div class="shadow-[inset_0px_0px_8px_0px_rgba(0,0,0,0.14)] bg-white py-10 text-center">
            <h4 class="text-base font-semibold mb-[20px]">Send Email:</h4>
            <a class="show-modal-btn bg-primary text-white py-[10px] px-[100px] w-fit text-base font-bold transition-all duration-200 hover:bg-black rounded-sm" href="{{ route('admin.email.compose') }}">
                Compose
            </a>
        </div>
    </section>

    <section class="px-3 max-w-[1500px] mx-auto my-10">
        <div class="text-center mb-10">
            <h4 class="text-black text-xl font-semibold">E-mail Templates :</h4>
        </div>

        <div class="grid grid-cols-1 gap-10 screen400:grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 screen1150:grid-cols-5 screen1367:grid-cols-6">
            <a href="javascript:void(0);" class="show-modal-btn block" data-target="#template-modal">
                <div class="shadow-[0px_1px_4px_0px_rgba(0,0,0,0.25)] rounded group">
                    <div class="flex justify-center items-center relative aspect-[217/326]">
                        <div class="bg-white p-3 flex justify-center items-center absolute z-10 -translate-y-[21%]">
                            <svg width="81" height="81" viewBox="0 0 81 81" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="40.1953" cy="40.124" r="40" class="fill-[#dbdbdb] group-hover:fill-black transition-all duration-600" />
                                <rect width="3.16" height="34.76" transform="translate(38.6155 22.7438)" class="fill-[#979595] group-hover:fill-white transition-all duration-600" />
                                <rect width="3.16" height="34.76" transform="matrix(0 1 -1 0 57.5754 38.5438)" class="fill-[#979595] group-hover:fill-white transition-all duration-600" />
                            </svg>
                        </div>
                        <div class="w-full text-center bg-black text-white p-3 absolute bottom-0 z-10 rounded-b">
                            <p class="text-sm font-medium">Create Template</p>
                        </div>
                    </div>
                </div>
            </a>

            @foreach ($templates->skip(1) as $template)
                <x-template-card :template="$template" />
            @endforeach
        </div>
    </section>

    @push('modals')
        <!-- Modal Section Starts Here -->
        <section id="template-modal" class="modal hide hidden fixed z-50 inset-0 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
            <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[1200px] overflow-hidden">
                <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>
                <form action="{{ route('admin.email.templates.store') }}">
                    @csrf
                    <div class="rounded mt-[6px] bg-[#f5f7fa] flex justify-center items-center w-full py-4">
                        <div class="h-[50vh] overflow-y-auto w-full rounded">
                            <!-- <a href="###" class="bg-primary text-white font-semibold px-5 py-[10px] rounded-sm select-none">Choose Template</a> -->
                            <!-- Template Overlay -->
                            <div class="m-4 overflow-hidden">
                                <!-- <h4 class="text-xl font-medium">Select Template</h4> -->
                                <section class="w-full mx-auto pb-4">
                                    <div class="after:-content-[' '] after:block after:h-[1px] after:w-full after:bg-[#00000038] after:rounded-full">
                                        <label class="w-full text-lg font-medium block" for="subject">Template Name</label>
                                        <div class="w-full mb-2 grid grid-cols-[75%_25%] gap-4 items-center">
                                            <div>
                                                <input name="name" class="rounded block mt-[6px] border outline-none p-[0.625rem] w-full" id="subject" placeholder="Enter template name" type="text">
                                                <span class="text-primary fw-bold" id="text_name"></span>
                                            </div>
                                            <button class="bg-primary text-white px-5 py-[0.5rem] rounded-sm transition-all duration-200 hover:bg-black hover:text-white" type="submit">Save</button>
                                        </div>
                                    </div>
                                </section>

                                <label class="text-lg font-medium block" for="recipient">Select Template</label>
                                <span class="text-primary fw-bold" id="text_template"></span>
                                <div
                                    class="template-slider mt-7 grid grid-cols-1 gap-6 screen400:grid-cols-2 sm:grid-cols-3 screen768:grid-cols-4 lg:grid-cols-5 screen1200:grid-cols-6 screen1367:grid-cols-7 items-center">
                                    @foreach ($templates as $template)
                                        <label for="{{ "template-{$loop->iteration}" }}" class="cursor-pointer template-card-item select-none">
                                            <div class="relative group hover:scale-95 transition-all duration-500">
                                                <div class="w-full overflow-hidden rounded">
                                                    <img class="card-item-img object-cover h-56 w-full select-none" src="{{ asset("uploads/thumbnails/{$template->thumbnail}") }}" alt="Template 1"
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
                </form>
            </div>
        </section>
        <!-- Modal Section Ends Here -->
    @endpush
@endsection
@push('js')
    {{--  --}}
@endpush
