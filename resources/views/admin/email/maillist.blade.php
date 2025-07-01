@extends('layout.email')
@push('css')
    <style>
        #select-all.indeterminate {
            background-color: #ffcc00;
            border-color: #ffcc00;
            fill: #ffcc00;
        }

        #select-all:checked {
            background-color: #4caf50;
            border-color: #4caf50;
        }

        #select-all:not(:checked) {
            background-color: #e8e8e8;
            border-color: #e8e8e8;
        }
    </style>
@endpush
@section('email')
    @if (Route::currentRouteName() === 'admin.email.lists.index' || Route::currentRouteName() === 'admin.email.lists.show')
        <section class="px-3 max-w-[1500px] mx-auto my-10">
            <div class="shadow-[inset_0px_0px_8px_0px_rgba(0,0,0,0.14)] bg-white py-10 text-center">
                <a href="{{ route('admin.email.lists.create') }}"
                    class="bg-primary text-white py-[10px] px-[100px] w-fit text-base font-bold transition-all duration-200 hover:bg-black rounded-sm block mx-auto mb-[20px]">Create New List</a>
                <div class="flex justify-around items-center  screen500:justify-center screen500:gap-20 text-sm font-medium">
                    {{-- <a class="flex justify-between items-center gap-3" href="###">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M7.5288 10.1475L7.1748 10.5015L7.5288 10.8545L7.8828 10.5015L7.5288 10.1475ZM8.0288 1.14746C8.0288 1.01485 7.97613 0.887676 7.88236 0.793908C7.78859 0.700139 7.66141 0.647461 7.5288 0.647461C7.3962 0.647461 7.26902 0.700139 7.17525 0.793908C7.08148 0.887676 7.0288 1.01485 7.0288 1.14746H8.0288ZM2.1748 5.50146L7.1748 10.5015L7.8828 9.79346L2.8828 4.79346L2.1748 5.50146ZM7.8828 10.5015L12.8828 5.50146L12.1748 4.79346L7.1748 9.79346L7.8828 10.5015ZM8.0288 10.1475V1.14746H7.0288V10.1475H8.0288Z"
                                fill="#444444" />
                            <path
                                d="M0.528809 12.1475V13.1475C0.528809 13.6779 0.739522 14.1866 1.11459 14.5617C1.48967 14.9367 1.99838 15.1475 2.52881 15.1475H12.5288C13.0592 15.1475 13.5679 14.9367 13.943 14.5617C14.3181 14.1866 14.5288 13.6779 14.5288 13.1475V12.1475"
                                stroke="#444444" />
                        </svg>
                        Import Users
                    </a>
                    <button class="flex justify-between items-center gap-3 show-modal-btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path
                                d="M7.5288 1.14743L7.1748 0.793429L7.5288 0.44043L7.8828 0.793429L7.5288 1.14743ZM8.0288 10.1474C8.0288 10.28 7.97613 10.4072 7.88236 10.501C7.78859 10.5948 7.66141 10.6474 7.5288 10.6474C7.3962 10.6474 7.26902 10.5948 7.17525 10.501C7.08148 10.4072 7.0288 10.28 7.0288 10.1474H8.0288ZM2.1748 5.79343L7.1748 0.793429L7.8828 1.50143L2.8828 6.50143L2.1748 5.79343ZM7.8828 0.793429L12.8828 5.79343L12.1748 6.50143L7.1748 1.50143L7.8828 0.793429ZM8.0288 1.14743V10.1474H7.0288V1.14743H8.0288Z"
                                fill="#444444" />
                            <path
                                d="M0.528809 12.1475V13.1475C0.528809 13.6779 0.739522 14.1866 1.11459 14.5617C1.48967 14.9367 1.99838 15.1475 2.52881 15.1475H12.5288C13.0592 15.1475 13.5679 14.9367 13.943 14.5617C14.3181 14.1866 14.5288 13.6779 14.5288 13.1475V12.1475"
                                stroke="#444444" />
                        </svg>
                        Export Users
                    </button> --}}

                    <!-- Modal Section Starts Here -->
                    <section class="modal hide hidden fixed z-50 inset-1 justify-center items-center bg-slate-900 bg-opacity-70 transition-all duration-200">
                        <div class="relative bg-white p-6 rounded mx-4 lg:mx-0 shadow w-[500px] overflow-hidden">
                            <button class="close-btn absolute p-4 top-0 right-0 text-2xl text-slate-700 hover:text-gray-900 fa-solid fa-xmark"></button>

                            <div class="p-4 my-8">
                                <div class="mb-5">
                                    <h4 class="text-lg font-medium text-center mb-[10px]">Export User List</h4>
                                    <p class="text-[#444] font-normal">Select list from below</p>
                                </div>

                                <div class="flex justify-center items-center flex-col gap-[10px] w-full my-4">
                                    <div class="flex justify-between items-center gap-5 w-full">
                                        <p>All Users</p>
                                        <label class="flex justify-center items-center h-[19px] w-[19px] border border-black cursor-pointer" for="all-users">
                                            <input class="hidden peer" type="checkbox" name="all-users" id="all-users">
                                            <svg class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9">
                                                <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                            </svg>
                                        </label>
                                    </div>
                                    <div class="flex justify-between items-center gap-5 w-full">
                                        <p>Category - 1</p>
                                        <label class="flex justify-center items-center h-[19px] w-[19px] border border-black cursor-pointer" for="category-1">
                                            <input class="hidden peer" type="checkbox" name="category-1" id="category-1">
                                            <svg class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9">
                                                <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                            </svg>
                                        </label>
                                    </div>
                                    <div class="flex justify-between items-center gap-5 w-full">
                                        <p>Category - 2</p>
                                        <label class="flex justify-center items-center h-[19px] w-[19px] border border-black cursor-pointer" for="category-2">
                                            <input class="hidden peer" type="checkbox" name="category-2" id="category-2">
                                            <svg class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9">
                                                <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                            </svg>
                                        </label>
                                    </div>
                                </div>

                                <a class="rounded-sm py-[10px] px-5 text-white bg-primary hover:bg-black hover:text-white transition-all duration-200" href="###">Export</a>
                            </div>
                        </div>
                    </section>
                    <!-- Modal Section Ends Here -->

                </div>


            </div>
        </section>

        <section class="flex flex-col screen1150:flex-row screen1150:justify-between gap-[30px] my-[30px] max-w-[1500px] mx-auto px-3">
            <div class="text-sm shadow-[0px_1px_4px_0px_rgba(0,_0,_0,_0.25)] py-5 screen1150:max-w-80 min-w-[270px] w-full screen1150:w-[20%]">
                <div>
                    <div class="py-[10px] px-2 text-[#979595] text-sm font-medium">
                        <p>All Other Lists:</p>
                    </div>
                    <div class="bg-black text-white hover:text-white hover:bg-black transition-all duration-200 py-[10px] px-5">
                        <a href="{{ route('admin.email.lists.index') }}" class="font-medium">All Users</a>
                    </div>
                    {{-- <div class="bg-white text-black hover:text-white hover:bg-black transition-all duration-200 py-[10px] px-5">
                        <a href="###" class="font-medium">Subscribers</a>
                    </div>
                    <div class="bg-white text-black hover:text-white hover:bg-black transition-all duration-200 py-[10px] px-5">
                        <a href="###" class="font-medium">Past Event Participants</a>
                    </div> --}}
                </div>

                <div>
                    <div class="py-[10px] px-2 text-[#979595] text-sm font-medium">
                        <p>List Created by Me:</p>
                    </div>
                    @foreach ($lists as $item)
                        <div class="bg-white text-black hover:text-white hover:bg-black transition-all duration-200 py-[10px] px-5">
                            <a href="{{ route('admin.email.lists.show', $item->id) }}" class="font-medium">{{ $item->name }}</a>
                        </div>
                    @endforeach
                    <div class="bg-white text-[#979595] text-sm transition-all duration-200 py-[10px] px-5">
                        <a href="{{ route('admin.email.lists.create') }}" class="font-medium flex items-center gap-[10px]">
                            <span>+</span>
                            Add new list
                        </a>
                    </div>
                </div>
            </div>

            @if (Route::currentRouteName() === 'admin.email.lists.index')
                <div class="shadow-[0px_1px_4px_0px_rgba(0,_0,_0,_0.25)] w-full screen1150:w-[80%]">
                    <div class="flex w-full p-4 flex-col gap-[20px] xl:flex-row xl:justify-between xl:items-center">
                        <div class="flex justify-center items-center gap-[10px] w-full xl:justify-start xl:w-1/2">
                            <p class="font-semibold">List Name:</p>
                            <p class="font-medium">All User</p>
                        </div>
                        <div class="relative flex justify-end items-center w-full xl:w-1/2">
                            <input class="outline-none bg-[#efefef] pl-4 pr-10 py-2 w-full xl:w-2/3 rounded-full placeholder:text-sm placeholder:text-slate-400 text-sm" type="text"
                                placeholder="Search">
                            <button class="absolute right-4 border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                    <path
                                        d="M14.5288 14.6475L11.8621 11.9808M13.1955 7.98079C13.1955 9.39528 12.6336 10.7518 11.6334 11.752C10.6332 12.7522 9.27663 13.3141 7.86214 13.3141C6.44765 13.3141 5.0911 12.7522 4.09091 11.752C3.09071 10.7518 2.52881 9.39528 2.52881 7.98079C2.52881 6.56631 3.09071 5.20975 4.09091 4.20956C5.0911 3.20936 6.44765 2.64746 7.86214 2.64746C9.27663 2.64746 10.6332 3.20936 11.6334 4.20956C12.6336 5.20975 13.1955 6.56631 13.1955 7.98079Z"
                                        stroke="#444444" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="table-responsive">
                            <thead>
                                <tr class="bg-e8e8e8">
                                    <th class="text-black font-semibold text-center">S.No.</th>
                                    <th class="text-black font-semibold text-center">Name</th>
                                    <th class="text-black font-semibold text-center">Email</th>
                                    {{-- <th class="text-black font-semibold text-center">Status</th> --}}
                                    {{-- <th class="text-black font-semibold text-center">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="bg-e8e8e8">
                                        <td class="text-[#444] font-medium text-center" data-label="S.No.">{{ $loop->iteration }}</td>
                                        <td class="text-[#444] font-medium text-center" data-label="Name">{{ $user->full_name }}</td>
                                        <td class="text-[#444] font-medium text-center" data-label="Email">{{ $user->email }}</td>
                                        {{-- <td class="text-[#444] font-medium text-center" data-label="Status">Subscribed</td> --}}
                                        {{-- <td class="text-[#444] font-medium text-center" data-label="Action">
                            <button class="transition-all duration-300 group">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path class="fill-primary group-hover:fill-black"
                                        d="M6.5583 15.9807C6.20364 15.9807 5.90175 15.8561 5.65264 15.607C5.40353 15.3579 5.27897 15.0563 5.27897 14.7021V4.89734H4.4873V4.10568H7.65397V3.49609H12.404V4.10568H15.5706V4.89734H14.779V14.7021C14.779 15.0663 14.6571 15.3706 14.4132 15.6149C14.1694 15.8593 13.8649 15.9812 13.4996 15.9807H6.5583ZM13.9873 4.89734H6.07064V14.7021C6.07064 14.8441 6.11629 14.9607 6.2076 15.0521C6.2989 15.1434 6.4158 15.189 6.5583 15.189H13.5004C13.6218 15.189 13.7334 15.1383 13.8353 15.037C13.9372 14.9357 13.9878 14.8238 13.9873 14.7013V4.89734ZM8.29364 13.6057H9.0853V6.48068H8.29364V13.6057ZM10.9726 13.6057H11.7643V6.48068H10.9726V13.6057Z" />
                                </svg>
                            </button>
                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if (Route::currentRouteName() === 'admin.email.lists.show')
                <div class="shadow-[0px_1px_4px_0px_rgba(0,_0,_0,_0.25)] w-full screen1150:w-[80%]">
                    <div class="flex w-full p-4 flex-col gap-[20px] xl:flex-row xl:justify-between xl:items-center">
                        <div class="flex justify-center items-center gap-[10px] w-full xl:justify-start xl:w-1/2">
                            <p class="font-semibold">List Name:</p>
                            <p class="font-medium">{{ $list->name }}</p>
                        </div>
                        <div class="relative flex justify-end items-center w-full xl:w-1/2">
                            <input class="outline-none bg-[#efefef] pl-4 pr-10 py-2 w-full xl:w-2/3 rounded-full placeholder:text-sm placeholder:text-slate-400 text-sm" type="text"
                                placeholder="Search">
                            <button class="absolute right-4 border-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17" fill="none">
                                    <path
                                        d="M14.5288 14.6475L11.8621 11.9808M13.1955 7.98079C13.1955 9.39528 12.6336 10.7518 11.6334 11.752C10.6332 12.7522 9.27663 13.3141 7.86214 13.3141C6.44765 13.3141 5.0911 12.7522 4.09091 11.752C3.09071 10.7518 2.52881 9.39528 2.52881 7.98079C2.52881 6.56631 3.09071 5.20975 4.09091 4.20956C5.0911 3.20936 6.44765 2.64746 7.86214 2.64746C9.27663 2.64746 10.6332 3.20936 11.6334 4.20956C12.6336 5.20975 13.1955 6.56631 13.1955 7.98079Z"
                                        stroke="#444444" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="table-responsive">
                            <thead>
                                <tr class="bg-e8e8e8">
                                    <th class="text-black font-semibold text-center">S.No.</th>
                                    <th class="text-black font-semibold text-center">Name</th>
                                    <th class="text-black font-semibold text-center">Email</th>
                                    {{-- <th class="text-black font-semibold text-center">Status</th> --}}
                                    <th class="text-black font-semibold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list->subscribers as $user)
                                    <tr class="bg-e8e8e8">
                                        <td class="text-[#444] font-medium text-center" data-label="S.No.">{{ $loop->iteration }}</td>
                                        <td class="text-[#444] font-medium text-center" data-label="Name">{{ $user->full_name }}</td>
                                        <td class="text-[#444] font-medium text-center" data-label="Email">{{ $user->email }}</td>
                                        {{-- <td class="text-[#444] font-medium text-center" data-label="Status">Subscribed</td> --}}
                                        <td class="text-[#444] font-medium text-center" data-label="Action">
                                            <form action="{{ route('admin.email.lists.update', $list->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT') <!-- Use PUT method -->
                                                <input type="hidden" name="remove_user" value="{{ $user->id }}">
                                                <button type="submit" class="transition-all duration-300 group">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                        <path class="fill-primary group-hover:fill-black"
                                                            d="M6.5583 15.9807C6.20364 15.9807 5.90175 15.8561 5.65264 15.607C5.40353 15.3579 5.27897 15.0563 5.27897 14.7021V4.89734H4.4873V4.10568H7.65397V3.49609H12.404V4.10568H15.5706V4.89734H14.779V14.7021C14.779 15.0663 14.6571 15.3706 14.4132 15.6149C14.1694 15.8593 13.8649 15.9812 13.4996 15.9807H6.5583ZM13.9873 4.89734H6.07064V14.7021C6.07064 14.8441 6.11629 14.9607 6.2076 15.0521C6.2989 15.1434 6.4158 15.189 6.5583 15.189H13.5004C13.6218 15.189 13.7334 15.1383 13.8353 15.037C13.9372 14.9357 13.9878 14.8238 13.9873 14.7013V4.89734ZM8.29364 13.6057H9.0853V6.48068H8.29364V13.6057ZM10.9726 13.6057H11.7643V6.48068H10.9726V13.6057Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </section>
    @endif
    @if (Route::currentRouteName() === 'admin.email.lists.create')
        <section class="my-[30px] max-w-[1500px] mx-auto px-3">
            <form class="shadow-[0px_1px_4px_0px_rgba(0,_0,_0,_0.25)] w-full" action="{{ route('admin.email.lists.store') }}" method="POST">
                @csrf
                <div class="w-full p-4 grid grid-cols-1 gap-[20px] items-center xl:grid-cols-4">
                    <!-- Select All Section -->
                    <div class="flex justify-start items-center gap-[10px] w-full">
                        <!-- Select All Checkbox -->
                        <label class="select-none flex justify-center items-center gap-3" for="select-all">
                            <div class="flex justify-center items-center h-[16px] w-[16px] border border-[#00000066] cursor-pointer">
                                <input class="hidden peer" type="checkbox" name="select-all" id="select-all">
                                <svg id="select-all-svg" class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewBox="0 0 12 9">
                                    <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                </svg>
                            </div>
                            Select All
                        </label>

                    </div>

                    <!-- Search and Dropdown Section -->
                    <div class="w-full justify-center items-center xl:col-span-2">
                        <div class="flex justify-start items-center gap-3 w-full xl:justify-center">
                            <!-- Search Box -->
                            <div class="relative flex justify-end items-center w-full">
                                <div class="w-full">
                                    <input name="name" value="{{ old('name') }}" placeholder="Mail list name"
                                        class="outline-none bg-[#efefef] pl-4 pr-10 py-2 w-full xl:max-w-[70%] rounded-lg placeholder:text-sm placeholder:text-slate-400 text-sm" type="text">
                                    @error('name')
                                        <span class="text-primary fw-bold">{{ $message }}</span>
                                    @enderror
                                    @error('users[]')
                                        <span class="text-primary fw-bold">{{ $message ?? '' }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Next Button Section -->
                    <div class="flex justify-start xl:justify-end">
                        <button class="w-fit px-5 py-[6px] bg-primary text-white font-semibold rounded-sm text-center" type="submit">
                            Create
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="table-responsive">
                        <thead>
                            <tr class="bg-e8e8e8">
                                <th class="text-black font-semibold text-center">S.No.</th>
                                <th class="text-black font-semibold text-center">Name</th>
                                <th class="text-black font-semibold text-center">Email</th>
                                {{-- <th class="text-black font-semibold text-center">Status</th> --}}
                                {{-- <th class="text-black font-semibold text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Subscribers List -->
                            @foreach ($subscribers as $subscriber)
                                <tr class="bg-e8e8e8">
                                    <td class="text-[#444] font-medium text-center" data-label="S.No.">
                                        <label class="select-none flex justify-center items-center gap-3" for="subscriber-{{ $loop->iteration }}">
                                            <div class="flex justify-center items-center h-[16px] w-[16px] border border-[#00000066] cursor-pointer">
                                                <input class="hidden peer" type="checkbox" name="users[]" value="{{ $subscriber->id }}" id="subscriber-{{ $loop->iteration }}">
                                                <svg class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewBox="0 0 12 9">
                                                    <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                                </svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="text-[#444] font-medium text-center" data-label="Name">{{ $subscriber->full_name }}</td>
                                    <td class="text-[#444] font-medium text-center" data-label="Email">{{ $subscriber->email }}</td>
                                    {{-- <td class="text-[#444] font-medium text-center" data-label="Status">Subscribed</td> --}}
                                    {{-- <td class="text-[#444] font-medium text-center" data-label="Action">
                                        <button class="transition-all duration-300 group">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                <path class="fill-primary group-hover:fill-black"
                                                    d="M6.5583 15.9807C6.20364 15.9807 5.90175 15.8561 5.65264 15.607C5.40353 15.3579 5.27897 15.0563 5.27897 14.7021V4.89734H4.4873V4.10568H7.65397V3.49609H12.404V4.10568H15.5706V4.89734H14.779V14.7021C14.779 15.0663 14.6571 15.3706 14.4132 15.6149C14.1694 15.8593 13.8649 15.9812 13.4996 15.9807H6.5583ZM13.9873 4.89734H6.07064V14.7021C6.07064 14.8441 6.11629 14.9607 6.2076 15.0521C6.2989 15.1434 6.4158 15.189 6.5583 15.189H13.5004C13.6218 15.189 13.7334 15.1383 13.8353 15.037C13.9372 14.9357 13.9878 14.8238 13.9873 14.7013V4.89734ZM8.29364 13.6057H9.0853V6.48068H8.29364V13.6057ZM10.9726 13.6057H11.7643V6.48068H10.9726V13.6057Z" />
                                            </svg>
                                        </button>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </section>
    @endif
    @if (Route::currentRouteName() === 'admin.email.lists.edit')
        <section class="my-[30px] max-w-[1500px] mx-auto px-3">
            <form class="shadow-[0px_1px_4px_0px_rgba(0,_0,_0,_0.25)] w-full" action="{{ route('admin.email.lists.update', $list->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="w-full p-4 grid grid-cols-1 gap-[20px] items-center xl:grid-cols-4">
                    <!-- Select All Section -->
                    <div class="flex justify-start items-center gap-[10px] w-full">
                        <!-- Select All Checkbox -->
                        <label class="select-none flex justify-center items-center gap-3" for="select-all">
                            <div class="flex justify-center items-center h-[16px] w-[16px] border border-[#00000066] cursor-pointer">
                                <input class="hidden peer" type="checkbox" name="select-all" id="select-all">
                                <svg id="select-all-svg" class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewBox="0 0 12 9">
                                    <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                </svg>
                            </div>
                            Select All
                        </label>

                    </div>

                    <!-- Search and Dropdown Section -->
                    <div class="w-full justify-center items-center xl:col-span-2">
                        <div class="flex justify-start items-center gap-3 w-full xl:justify-center">
                            <!-- Search Box -->
                            <div class="relative flex justify-end items-center w-full">
                                <div class="w-full">
                                    <input name="name" value="{{ old('name') }}" placeholder="Mail list name"
                                        class="outline-none bg-[#efefef] pl-4 pr-10 py-2 w-full xl:max-w-[70%] rounded-lg placeholder:text-sm placeholder:text-slate-400 text-sm" type="text">
                                    @error('name')
                                        <span class="text-primary fw-bold">{{ $message }}</span>
                                    @enderror
                                    @error('users[]')
                                        <span class="text-primary fw-bold">{{ $message ?? '' }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Next Button Section -->
                    <div class="flex justify-start xl:justify-end">
                        <button class="w-fit px-5 py-[6px] bg-primary text-white font-semibold rounded-sm text-center" type="submit">
                            Create
                        </button>
                    </div>
                </div>

                <div class="table-container">
                    <table class="table-responsive">
                        <thead>
                            <tr class="bg-e8e8e8">
                                <th class="text-black font-semibold text-center">S.No.</th>
                                <th class="text-black font-semibold text-center">Name</th>
                                <th class="text-black font-semibold text-center">Email</th>
                                {{-- <th class="text-black font-semibold text-center">Status</th> --}}
                                {{-- <th class="text-black font-semibold text-center">Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Subscribers List -->
                            @foreach ($subscribers as $subscriber)
                                <tr class="bg-e8e8e8">
                                    <td class="text-[#444] font-medium text-center" data-label="S.No.">
                                        <label class="select-none flex justify-center items-center gap-3" for="subscriber-{{ $loop->iteration }}">
                                            <div class="flex justify-center items-center h-[16px] w-[16px] border border-[#00000066] cursor-pointer">
                                                <input class="hidden peer" type="checkbox" name="users[]" value="{{ $subscriber->id }}" id="subscriber-{{ $loop->iteration }}">
                                                <svg class="hidden peer-checked:block fill-none" xmlns="http://www.w3.org/2000/svg" width="11" height="10" viewBox="0 0 12 9">
                                                    <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
                                                </svg>
                                            </div>
                                        </label>
                                    </td>
                                    <td class="text-[#444] font-medium text-center" data-label="Name">{{ $subscriber->full_name }}</td>
                                    <td class="text-[#444] font-medium text-center" data-label="Email">{{ $subscriber->email }}</td>
                                    {{-- <td class="text-[#444] font-medium text-center" data-label="Status">Subscribed</td> --}}
                                    {{-- <td class="text-[#444] font-medium text-center" data-label="Action">
                                    <button class="transition-all duration-300 group">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                            <path class="fill-primary group-hover:fill-black"
                                                d="M6.5583 15.9807C6.20364 15.9807 5.90175 15.8561 5.65264 15.607C5.40353 15.3579 5.27897 15.0563 5.27897 14.7021V4.89734H4.4873V4.10568H7.65397V3.49609H12.404V4.10568H15.5706V4.89734H14.779V14.7021C14.779 15.0663 14.6571 15.3706 14.4132 15.6149C14.1694 15.8593 13.8649 15.9812 13.4996 15.9807H6.5583ZM13.9873 4.89734H6.07064V14.7021C6.07064 14.8441 6.11629 14.9607 6.2076 15.0521C6.2989 15.1434 6.4158 15.189 6.5583 15.189H13.5004C13.6218 15.189 13.7334 15.1383 13.8353 15.037C13.9372 14.9357 13.9878 14.8238 13.9873 14.7013V4.89734ZM8.29364 13.6057H9.0853V6.48068H8.29364V13.6057ZM10.9726 13.6057H11.7643V6.48068H10.9726V13.6057Z" />
                                        </svg>
                                    </button>
                                </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </section>
    @endif
@endsection
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const selectAllCheckbox = document.getElementById("select-all");
            const selectAllSvg = document.getElementById("select-all-svg");
            const checkboxes = document.querySelectorAll("input[name='users[]']");

            function updateSelectAllState() {
                const checkedCount = document.querySelectorAll("input[name='users[]']:checked").length;

                if (checkedCount === checkboxes.length) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                    selectAllSvg.innerHTML = `
                <path class="fill-primary" d="M3.6251 7.10664L1.01885 4.50039L0.131348 5.38164L3.6251 8.87539L11.1251 1.37539L10.2438 0.494141L3.6251 7.10664Z" />
            `;
                    selectAllSvg.classList.add("peer-checked:block");
                    selectAllSvg.style.backgroundColor = "transparent";
                } else if (checkedCount > 0) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                    selectAllSvg.innerHTML = `
                <rect x="1.5" width="8" fill="#bd191f" height="8" y="0.5"></rect>
            `;
                    selectAllSvg.classList.add("peer-checked:block");
                    selectAllSvg.style.display = "block";
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                    selectAllSvg.innerHTML = "";
                    selectAllSvg.classList.remove("peer-checked:block");
                    selectAllSvg.style.backgroundColor = "transparent";
                }
            }

            selectAllCheckbox.addEventListener("change", function() {
                checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
                updateSelectAllState();
            });

            checkboxes.forEach(cb => cb.addEventListener("change", updateSelectAllState));
        });
    </script>
@endpush
