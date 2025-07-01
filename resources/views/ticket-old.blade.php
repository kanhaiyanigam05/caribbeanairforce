@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}" />
    <meta name="description" content="{{ $meta->meta_description }}" />
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('admins/css/cards.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/custom-check-out-calendar/custom-check-out-calendar1.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/tailwind/tw.css') }}">
    {{--
<link rel="stylesheet" href="{{ asset('asset/css/ticket.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('asset/css/ticket1.css') }}">

    <style>
        .checkbox-wrapper-16 {
            width: fit-content;
        }

        .checkbox-wrapper-16 *,
        .checkbox-wrapper-16 *:after,
        .checkbox-wrapper-16 *:before {
            box-sizing: border-box;
        }

        .checkbox-wrapper-16 .checkbox-input {
            clip: rect(0 0 0 0);
            -webkit-clip-path: inset(100%);
            clip-path: inset(100%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile {
            border-color: #bd191f;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
            background-color: #bd191f;
            border-color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile .checkbox-icon,
        .checkbox-wrapper-16 .checkbox-input:checked+.checkbox-tile .checkbox-label {
            color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-input:focus+.checkbox-tile {
            border-color: #bd191f;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #bd191f63
        }

        .checkbox-wrapper-16 .checkbox-input:focus+.checkbox-tile:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-wrapper-16 .checkbox-tile {
            display: flex;
            /* flex-direction: column; */
            align-items: center;
            justify-content: center;
            width: fit-content;
            /* min-height: 7rem; */
            border-radius: 0.5rem;
            border: 2px solid #bd191f63;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            transition: 0.15s ease;
            cursor: pointer;
            position: relative;
            gap: 1rem;
            padding: 10px 10px;
        }

        .checkbox-wrapper-16 .checkbox-tile:before {
            content: "";
            position: absolute;
            display: block;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #bd191f63;
            background-color: #fff;
            border-radius: 50%;
            top: 0.25rem;
            left: 0.25rem;
            opacity: 0;
            transform: scale(0);
            transition: 0.25s ease;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='192' height='192' fill='%23FFFFFF' viewBox='0 0 256 256'%3E%3Crect width='256' height='256' fill='none'%3E%3C/rect%3E%3Cpolyline points='216 72.005 104 184 48 128.005' fill='none' stroke='%23FFFFFF' stroke-linecap='round' stroke-linejoin='round' stroke-width='32'%3E%3C/polyline%3E%3C/svg%3E");
            background-size: 12px;
            background-repeat: no-repeat;
            background-position: 50% 50%;
        }

        .checkbox-wrapper-16 .checkbox-tile:hover {
            border-color: #bd191f;
        }

        .checkbox-wrapper-16 .checkbox-tile:hover:before {
            transform: scale(1);
            opacity: 1;
        }

        .checkbox-wrapper-16 .checkbox-icon {
            transition: 0.375s ease;
            color: #494949;
        }

        .checkbox-wrapper-16 .checkbox-icon svg {
            width: 3rem;
            height: 3rem;
        }

        .checkbox-wrapper-16 .checkbox-label {
            color: #707070;
            transition: 0.375s ease;
            text-align: center;
        }
    </style>

    <style>
        .hide-accordion {
            overflow: hidden;
            height: 0;
        }

        .check-out-box {
            flex-direction: column;
        }

        .text-gray-600 {
            color: rgb(102, 102, 102);
        }

        .bg-white_10 {
            background-color: rgba(255, 255, 255, 0.10);
        }

        .check-out-box {
            border-radius: 4px;
        }

        .check-out-box-2 {
            max-width: 800px;
            width: 100%;
            overflow-x: auto;
            background-color: #f7f7f7;
            border-radius: 4px;
        }

        .check-out-main-section-bg-img {
            min-height: 700px;
        }

        .check-out-main-section-bg-img-2 {
            min-height: 1150px;
        }

        .check-out-main-section-bg-img-3 {
            min-height: 1050px;
        }

        .check-out-main-section-content-3 {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5rem;
            flex-direction: column;
        }

        .select-pkg-base-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .all-pkgs-wrapper {
            padding: 20px 0;
            padding-bottom: 5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            gap: 7px;
        }

        .all-pkgs-wrapper-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px;
            user-select: none;
            width: 100%;
        }


        .package-amount-wrapper .all-pkgs-wrapper-item {
            margin: 3px 0;
        }

        .packages-name-wrapper .all-pkgs-wrapper-item {
            transition: 0.1s ease-in-out all;
        }

        .packages-name-wrapper .all-pkgs-wrapper-item:hover {
            background-color: #ececec;
            border-radius: 4px;
        }

        .packages-name-wrapper .all-pkgs-wrapper-item:active {
            background-color: #dbdbdb;
            scale: 0.95;
        }



        .all-pkgs-wrapper-item span {
            color: #6D6969;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 150px;
            text-align: left;
        }

        .all-pkgs-wrapper-item i {
            color: #bd191f;
        }

        .all-pkgs-wrapper-item .add-pkg-icon {
            color: #bd191f;
            font-size: 14px;
        }

        .all-pkgs-wrapper-item .remove-pkg-icon {
            color: #bd191f;
            font-size: 12px;
        }

        .all-pkgs-wrapper-item.number-control {
            display: flex;
            align-items: center;
        }

        .all-pkgs-wrapper-item.number-control .number-left::before,
        .all-pkgs-wrapper-item.number-control .number-right::after {
            content: attr(data-content);
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgb(179, 179, 179);
            width: 40px;
            color: #bd191f;
            transition: background-color 0.3s;
            cursor: pointer;
            font-size: 19px;
        }

        .all-pkgs-wrapper-item.number-control .number-left::before {
            content: "-";
            border-radius: 4px 0 0 4px;
        }

        .all-pkgs-wrapper-item.number-control .number-right::after {
            content: "+";
            border-radius: 0 4px 4px 0;
        }

        .all-pkgs-wrapper-item.number-control .number-quantity {
            padding: 2px;
            border: 0;
            width: 70px;
            -moz-appearance: textfield;
            border-top: 1px solid rgb(179, 179, 179);
            border-bottom: 1px solid rgb(179, 179, 179);
            outline: none;
            text-align: center;
        }

        .all-pkgs-wrapper-item.number-control .number-quantity:disabled {
            background-color: #ffffff;
        }

        .all-pkgs-wrapper-item.number-control .number-left:hover::before,
        .all-pkgs-wrapper-item.number-control .number-right:hover::after {
            background-color: #666666;
            color: #ffffff;
        }

        .all-pkgs-wrapper-item>.amount {
            background-color: #ececec;
            border-radius: 4px;
            width: 100%;
            text-align: center;
        }

        .select-pkg-base-wrapper.sub-total-wrapper {
            padding: 0 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .select-pkg-base-wrapper.sub-total-wrapper .sub-total-label {
            font-weight: 600;
        }

        .select-pkg-base-wrapper.sub-total-wrapper .sub-total-amount {
            font-weight: 600;
        }

        .check-out-box-inner-wrapper {
            width: 100%;
        }

        .check-out-home-2-base-wrapper {
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            flex-direction: column;
            gap: 3.25rem;
        }

        .select-pkg-base-wrapper:not(.sub-total-wrapper) {
            min-height: 406px;
            max-height: 406px;
            overflow-y: hidden;
            overflow-x: auto;
        }

        .checkout-package-body-aside {
            min-height: 406px;
            max-height: 406px;
            overflow-y: auto;
            overflow-x: auto;
        }

        .aside-checkout-personal-details-wrapper {
            width: 100%;
        }

        .custom-pass-tab {
            max-height: 480px;
        }

        @media only screen and (max-width: 992px) {
            .os-table {
                flex-wrap: wrap !important;
                gap: 1rem !important
            }

            .os-name-area {
                gap: 10px !important;
            }

            .check-out-box-3 {
                padding: 10px;
            }

        }



        @media only screen and (min-width: 350px) {
            .check-out-main-section-bg-img-3 {
                min-height: 1230px;
            }

            .check-out-box .check-out-box-inner-wrapper {
                display: none;
            }
        }


        @media only screen and (min-width: 450px) {
            .check-out-box {
                width: 420px;
            }
        }

        @media only screen and (min-width: 560px) {
            .check-out-box {
                width: 540px;
            }

            .check-out-main-section-bg-img {
                min-height: 950px;
            }
        }

        @media only screen and (min-width: 760px) {
            .check-out-box {
                width: 740px;
            }

            .check-out-main-section-bg-img {
                min-height: 1050px;
            }
        }

        @media only screen and (min-width: 900px) {
            .check-out-main-section-bg-img-2 {
                min-height: 750px;
                max-height: 750px;
            }

            .check-out-home-2-base-wrapper {
                flex-direction: row;

            }

            .check-out-box-inner-wrapper {
                width: fit-content;
            }

            .check-out-box {
                width: 90%;
                margin-left: auto;
                margin-right: auto;
            }

            .check-out-box {
                flex-direction: row;
            }

            .check-out-main-section-bg-img {
                min-height: 655px;
            }

            .event-aside-check-out-img,
            .event-aside-check-out-right {
                /*height: 500px;*/
                height: auto;
                width: 500px;
                justify-content: center;
            }

            .aside-checkout-personal-details-wrapper {
                max-width: 20rem;
            }

            .check-out-box .check-out-box-inner-wrapper {
                display: flex;
            }
        }


        @media only screen and (min-width: 1150px) {

            .event-aside-check-out-img,
            .event-aside-check-out-right {
                /*height: 70vh !important;*/
                height: auto !important;
                width: 70vh !important;
                justify-content: center;
            }
        }

        @media only screen and (min-width: 1200px) {
            .check-out-main-section-content-3 {
                flex-direction: row;
            }

            .check-out-main-section-bg-img-3 {
                min-height: 720px;
            }
        }


        .donated-amount-label {
            font-size: 14px;
            font-weight: 400;
        }
    </style>



    <style>
        .block {
            display: block !important;
        }
    </style>
@endpush
@section('main')
    <section class="bg-white">
        <div class="h-full w-full py-16">
            <div class="container mx-auto relative">
                <div class="w-11/12 lg:w-2/6 mx-auto">
                    <div class="bg-gray-200 h-1 flex items-center justify-between relative checkout-form-paginator">
                        <div class="w-0 h-full absolute bg-primary z-0 checkout-form-paginator-fill"></div>
                        <button type="button" type="button" class="cursor-pointer absolute z-10 checkout-form-paginator-item"><i class="fa-solid fa-circle text-primary"></i></button>
                        <button type="button" type="button" class="cursor-not-allowed absolute z-10 left-1/2 checkout-form-paginator-item"><i
                                class="fa-regular fa-circle bg-white text-gray-300"></i></button>
                        <button type="button" type="button" class="cursor-not-allowed absolute z-10 right-0 checkout-form-paginator-item"><i
                                class="fa-regular fa-circle bg-white text-gray-300"></i></button>
                    </div>
                    <div class="absolute h-full  bg-primary"></div>
                </div>
            </div>
        </div>
    </section>

    <form action="{{ route('paypal.form') }}" method="post" id="checkout-form">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        <section class="checkout-multi-step-wrapper">
            <div class="checkout-multi-step-item">
                <div class="relative flex items-center justify-center check-out-main-section">
                    <img class="object-cover w-full h-auto select-none check-out-main-section-bg-img" src="{{ asset('asset/images/ticket-bg.png') }}" alt="" draggable="false">
                    <div class="absolute w-[90%] mx-auto flex flex-col justify-center items-center">
                        <div class="flex items-center justify-center gap-5 check-out-box">
                            <div class="check-out-box-inner-wrapper">
                                <img class="object-cover w-full mx-auto rounded-sm select-none event-aside-check-out-img" style="max-width:500px" src="{{ $event->image }}" alt=""
                                    draggable="false">
                            </div>
                            {{-- @if ($event->type === 'ticket') --}}
                            <div class="type-area-ticket hidden">
                                <div class="p-[30px] rounded-sm flex flex-col justify-start items-start gap-[20px] bg-white_10 w-full h-full event-aside-check-out-right">

                                    <div class="w-full h-full flex flex-col pass ui custom-calendar-wrapper multi-date">
                                        <div class="flex justify-between w-full">
                                            <div class="w-full calender-input-button custom-tab-button-ticket py-3 custom-pass-read-more-btn text-white multi-date" data-calendar-type="multi-date">
                                                <p>Ticket</p>
                                            </div>
                                        </div>
                                        <div class="bg-white w-full h-full p-4 flex flex-col justify-between ticket">
                                            <div class="w-full h-full flex flex-col justify-between">
                                                <div class="w-full ">
                                                    <!--<p class="custom-pass-tab-heading pb-4">Select Date</p>-->
                                                    <!--<span>calender area</span>-->
                                                    <div class="custom-ticket-calender1"></div>
                                                </div>

                                                <div class="mt-aut">
                                                    <div class="flex justify-between selected-date-time">
                                                        <span class="pass-date-detail1">Date: 01 Mar</span>
                                                        <span class="pass-time-detail1"></span>
                                                    </div>
                                                    <p class="text-white transition type-area-ticket-validatation error-message"></p>
                                                    <button class="w-full cards-ticket-read-more save-calendar-btn event-date-time-check-out-next" type="button">Next</button>

                                                    <button class="w-full cards-ticket-read-more cancel-calendar-btn hidden" type="button">Cancel</button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            {{-- @else --}}
                            <div class="type-area-pass">
                                <div class="p-[30px] rounded-sm flex flex-col justify-start items-start gap-[20px] bg-white_10 w-full h-full event-aside-check-out-right">

                                    <div class="w-full h-full flex flex-col pass ui custom-calendar-wrapper single-date">
                                        <div class="flex justify-between w-full">
                                            <div onclick="handleChangeTab('pass')" class="w-full custom-tab-button-pass py-3 bg-white custom-pass-read-more-btn ">
                                                <p>Pass</p>
                                            </div>
                                            <div onclick="handleChangeTab('ticket')" class="w-full calender-input-button custom-tab-button-ticket1 py-3 custom-pass-read-more-btn text-white single-date"
                                                data-calendar-type="single-date">
                                                <p>Ticket</p>
                                            </div>
                                        </div>
                                        <div class="bg-white w-full h-full p-4 flex flex-col justify-between">
                                            <div class="w-full h-full flex flex-col justify-between custom-pass-tab">
                                                <div class="w-full pb-4" style="overflow-y: scroll;">
                                                    <p class="custom-pass-tab-heading pb-4">Custom Pass</p>
                                                    <div class="custom-pass-area flex flex-wrap gap-5"></div>
                                                    <p class="custom-pass-tab-heading mt-5 pb-4">Regular Pass</p>
                                                    <div class="statick-pass-area flex flex-wrap gap-5"></div>
                                                </div>
                                                <div class="mt-aut">
                                                    <div class="flex justify-between selected-date-time">
                                                        <span class="pass-date-detail"></span>
                                                        <span class="pass-time-detail"></span>
                                                    </div>
                                                    <button class="w-full cards-ticket-read-more event-date-time-check-out-next0" type="button">Next</button>
                                                </div>
                                            </div>
                                            <div style="display: none;" class="w-full h-full flex flex-col justify-between custom-ticket-tab">
                                                <div class="w-full ">
                                                    <div class="custom-ticket-calender"></div>
                                                </div>

                                                <div class="mt-aut">
                                                    <div class="flex justify-between selected-date-time">
                                                        <span class="pass-date-detail2">Date: 01 Mar</span>
                                                        <span class="pass-time-detail2"></span>
                                                    </div>
                                                    <button class="w-full cards-ticket-read-more save-calendar-btn event-date-time-check-out-next02" type="button">Next</button>

                                                    <button class="w-full cards-ticket-read-more cancel-calendar-btn hidden" type="button">Cancel</button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>


                                </div>
                                <div class="pass-modal">
                                    <div class="calendar-container pass-calendar-container">
                                        <div class="calendar-inner-container pass-modal-inner-container">
                                            <aside class="aside-time-slots-wrapper aside-pass-slots-wrapper hidden" style="width: 423px;padding:0px">
                                                <div class="time-base-wrapper time-pass-wrapper" style="margin:0px;padding:0px"></div>
                                            </aside>
                                        </div>
                                        <div class="block">
                                            <div class="bg-white transition text-red-500 text-center hidden pass-calender-pick-error" style="padding-bottom:1rem">Some thing went wrong</div>
                                            <div class="calendar-footer-btn-wrapper">
                                                <button type="button" class="save-calendar-btn transition" onclick="handlePassSaveButton()">Save</button>
                                                <button type="button" class="cancel-calendar-btn transition" onclick="handlePassCancelButton()">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>

                    </div>
                </div>
            </div>

            <div class="checkout-multi-step-item hidden">
                <div class="relative flex items-center justify-center check-out-main-section">
                    <img class="select-none w-full h-auto object-cover check-out-main-section-bg-img-2 max-w-[1900px] mx-auto" src="{{ asset('asset/images/ticket-bg.png') }}" alt=""
                        draggable="false">
                    <div class="absolute w-[90%] mx-auto flex flex-col justify-center items-center">
                        <div class="check-out-home-2-base-wrapper">
                            <div class="w-[70vw] overflow-x-auto bg-[#f7f7f7] rounded">
                                <div class="min-w-[1024px] check-out-box-2-inner-wrapper">
                                    <div class="flex w-full">
                                        <div class="w-1/3 border-r select-none">
                                            <div class="w-full p-2 text-center border-b shadow-md text-primary">
                                                <div class="p-2 font-semibold text-nowrap">Add Your Package</div>
                                            </div>

                                            <div class="w-full min-h-64 max-h-[400px] overflow-y-auto add-pkg-wrapper">


                                            </div>
                                        </div>

                                        <div class="w-full">
                                            <div class="grid grid-cols-4 p-2 text-center border-b rounded-tr shadow-md select-none text-primary">
                                                <div class="p-2 font-semibold">Select Packages</div>
                                                <div class="p-2 font-semibold">Quantity</div>
                                                <div class="p-2 font-semibold">Date</div>
                                                <div class="p-2 font-semibold">Amount</div>
                                            </div>

                                            <div class="min-h-64 max-h-[400px] overflow-y-auto pr-4 p-1 selected-pkgs-wrapper">
                                                <div class="grid items-center grid-cols-4 text-center border-b">

                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-1 px-6 select-none text-primary">
                                        <div class="grid grid-cols-5 font-semibold">
                                            <div class="text-center">Sub Total</div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div class="text-center sub-total">$0.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="flex flex-col gap-6 px-6 bg-black rounded py-9 aside-checkout-personal-details-wrapper">
                                <h6 class="text-2xl font-medium text-white uppercase">Personal Details</h6>

                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-col gap-1 detail-item">
                                        <label for="fname" class="text-white font-medium detail-item-label">First Name*</label>
                                        <input type="text" name="fname" @auth value="{{ Auth::user()->fname }}" @endauth id="fname"
                                            class="w-full detail-item-input bg-white text-black rounded px-2 py-1 outline-none" placeholder="Clara ">
                                        <p class="error-message transition text-primary"></p>
                                    </div>
                                    <div class="flex flex-col gap-1 detail-item">
                                        <label for="lname" class="text-white font-medium detail-item-label">Last Name*</label>
                                        <input type="text" name="lname" @auth value="{{ Auth::user()->lname }}" @endauth id="lname"
                                            class="w-full detail-item-input bg-white text-black rounded px-2 py-1 outline-none" placeholder="Mitchell">
                                        <p class="error-message transition text-primary"></p>
                                    </div>
                                    <div class="flex flex-col gap-1 detail-item">
                                        <label for="email" class="text-white font-medium detail-item-label">Email*</label>
                                        <input type="email" name="email" @auth value="{{ Auth::user()->email }}" @endauth id="email"
                                            class="w-full detail-item-input bg-white text-black rounded px-2 py-1 outline-none" placeholder="claramitchell32@oceanresearcher.com">
                                        <p class="error-message transition text-primary"></p>
                                    </div>
                                    <div class="flex flex-col gap-1 detail-item">
                                        <label for="pnumber" class="text-white font-medium detail-item-label">Phone Number*</label>
                                        <input type="text" name="phone" @auth value="{{ Auth::user()->phone }}" @endauth id="pnumber"
                                            class="w-full detail-item-input bg-white text-black rounded px-2 py-1 outline-none" placeholder="+1 404-579-1211">
                                        <p class="error-message transition text-primary"></p>
                                    </div>
                                </div>
                                <p class="error-message transition text-primary no-package-error"></p>
                                <div class="mx-auto">
                                    <button class="text-white bg-primary px-8 py-1 rounded aside-checkout-next" type="button">Next</button>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

            <div class="checkout-multi-step-item">
                <div class="relative flex items-center justify-center check-out-main-section">
                    <img class="object-cover w-full h-auto select-none check-out-main-section-bg-img-3" src="{{ asset('asset/images/ticket-bg.png') }}" style="min-height:1230px" alt=""
                        draggable="false">

                    <div class="absolute w-[90%] mx-auto flex check-out-main-section-content-3">
                        <div class="w-[90%] bg-white rounded-sm check-out-box-3 flex flex-col gap-10 p-[30px]">
                            <h4 class="text-2xl font-semibold" style="color: #bd191f;">Order Summary</h4>
                            <div class="flex flex-col gap-3">
                                <div class="flex justify-start gap-10 os-name-area items-center text-[#000] text-sm ">
                                    <div class="flex flex-col gap-2">
                                        <p class="font-bold">First Name :</p>
                                        <p class="font-bold">Last Name :</p>
                                        <p class="font-bold">Phone :</p>
                                        <p class="font-bold">Email :</p>
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <p><span class="sub-total-amount os-name">Amey</span></p>
                                        <p><span class="sub-total-amount os-lastname">Colin</span></p>
                                        <p><span class="sub-total-amount os-phone">938271456</span></p>
                                        <p><span class="sub-total-amount os-email">ameycolin@gmail.com</span></p>
                                    </div>
                                </div>

                                <div class="os-table   flex justify-between px-4 py-2">
                                    <div class="flex gap-2">
                                        <p class="text-[#000] text-sm font-bold text-start">Event Name:</p>
                                        <p class="text-[#000] text-sm text-start os-event-name">Carnival Fests</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <p class="text-[#000] text-sm font-bold text-start">Event Category:</p>
                                        <p class="text-[#000] text-sm text-start os-event-category">Music</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <p class="text-[#000] text-sm font-bold text-start">Venue:</p>
                                        <p class="text-[#000] text-sm text-start os-event-venue">23, GG Road, LA</p>
                                    </div>
                                </div>

                                <table class="os-table">
                                    <thead class="os-table-head">
                                        <tr>
                                            <th class="">
                                                <p class="text-[#000] text-sm font-bold text-start">Date</p>
                                            </th>
                                            <th class="">
                                                <p class="text-[#000] text-sm font-bold text-start">Package Name</p>
                                            </th>
                                            <th class="">
                                                <p class="text-[#000] text-sm font-bold">Quantity</p>
                                            </th>
                                            <th class="">
                                                <p class="text-[#000] text-sm font-bold text-end">Amount</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="os-table-body">

                                    </tbody>
                                </table>



                                <div class="flex justify-end px-3 gap-10">
                                    <div class="">
                                        <p class="text-[#000] text-sm font-bold text-start os-event-donation-label">Donation</p>
                                        <p class="text-[#000] text-sm font-bold text-start">Sub-Total </p>
                                        <p class="text-[#000] text-sm font-bold text-start"></p>
                                    </div>
                                    <div class="">
                                        <p class="text-[#000] text-sm text-start os-event-donation">$0</p>
                                        <p class="text-[#000] text-sm text-start os-event-subtotal">$700</p>
                                        <p class="text-[#000] text-sm text-start os-event-tax">(Inclusive of all taxes)</p>
                                    </div>
                                </div>
                                <div class="os-table py-2 flex justify-end px-3 gap-10">
                                    <p class="text-[#000] text-sm font-bold text-start">Total</p>
                                    <p class="text-[#000] text-sm text-start os-event-total">$700</p>
                                </div>


                            </div>
                            <div class="flex flex-col gap-7">
                                <div class="flex flex-col gap-[8px] text-sm">
                                    <label class="text-[#000] cursor-pointer w-fit-content">
                                        <input class="transition-all duration-500 ease-in-out border-black " type="checkbox">
                                        <span class="text-sm font-medium">Keep me updated on more events and news
                                            from this event organizer.</span>
                                    </label>

                                    <label class="text-[#000] cursor-pointer text-sm w-fit-content">
                                        <input class="transition-all duration-500 ease-in-out border-black" type="checkbox">
                                        <span class="text-sm font-medium">Send me emails about the events happening
                                            nearby or online.</span>
                                    </label>
                                </div>
                                <p class="text-[#000] text-[15px] font-medium">By selecting Place Order, I agree to
                                    all <a href="###" class="text-primary">Terms and Conditions</a></p>
                            </div>
                            <div class="place-order">
                                <button class="text-[#fff] bg-black px-[20px] py-[8px] rounded-[4px] text-base font-semibold" type="submit">Place Order</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </form>
@endsection
@push('js')
    @php
        $event->slots = $event->future_slots;
        $event->category_title = $event->category?->title;
    @endphp
    <script src="{{ asset('asset/js/custom-check-out-calendar/custom-check-out-calendar.js') }}"></script>
    <script src="{{ asset('asset/js/general.js') }}"></script>
    <script src="{{ asset('asset/js/check-out.js') }}"></script>
    <script>
        $(document).ready(function() {
            localStorage.setItem("ticketDetail", JSON.stringify([]));
            /*const wrapper = document.querySelector(".custom-check-out-calendar-wrapper");
            const calendarInputButton = wrapper.querySelector(".calender-input-button");
            const customCalendar = wrapper.querySelector(".calendar-modal");*/
            const event = @json($event);
            localStorage.setItem("ticketDetail", JSON.stringify(event));
            handleSeperateType(event.type, event)
            /*const calendar = new CustomCheckOutCalendar(customCalendar, calendarInputButton, event);
            if (customCalendar.classList.contains("single-date-selector")) {
                calendar.singleDaySelection();
            }
            if (customCalendar.classList.contains("range-selector")) {
                calendar.rangeSelection();
            }
            if (customCalendar.classList.contains("multi-date-selector")) {
                calendar.multipleSelection();
            }*/
        });
    </script>
@endpush
