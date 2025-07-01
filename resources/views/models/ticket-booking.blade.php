@push('style')
    <style>
        .event-details-m {
            padding-left: 0;
        }

        @media only screen and (max-width: 1023px) {
            .event-details-m {
                padding-left: 2rem !important;
            }
        }

        .pl-8 {
            padding-left: 2rem;
        }

        .disabled {
            cursor: not-allowed;
            opacity: 0.5;
            pointer-events: none;
        }
    </style>
@endpush

<!-- Modal Starts Here -->
<form action="{{ route('paypal.form') }}" method="post" id="checkout-form">
    @csrf
    <div>
        <div id="checkout-modal" class="modal-wrapper">
            <div
                    class="transition-all duration-300 lg:w-fit h-full lg:h-auto flex justify-center items-center bg-white w-full events-section-inner">
                <div class="pb-8 lg:h-fit lg:overflow-visible w-full">
                    <div class="max-h-[90vh] overflow-y-auto flex justify-start items-start gap-5 flex-col lg:flex-row">
                        <div class="p-8 w-full" id="form-wrapper">
                            <div class="flex justify-between items-center pb-4"
                                 style="box-shadow: rgba(33, 35, 38, 0.1) 0px 6px 11px -10px">
                                <button onclick="closeModal()" class="cursor-pointer" type="button">
                                    <svg width="28" height="29" viewBox="0 0 28 29" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                                stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                                    </svg>
                                </button>
                                <div>
                                    <h5 class="font-medium text-gray text-lg leading-6 tracking-[0.25px] uppercase">
                                        Checkout</h5>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <div>
                                    <h5 class="text-2xl font-bold my-5 text-black capitalize">Billing information</h5>
                                    <div>
                                        <div
                                                class="flex justify-start gap-5 mb-5 flex-col screen768:flex-row input-wrap">
                                            <div class="relative w-full max-w-xl">
                                                <input name="fname" id="fname" type="text" placeholder="" value=""
                                                       class="peer transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none"/>
                                                <p class="text-primary" id="fname-error"></p>
                                                <label
                                                        class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0">First
                                                    Name</label>
                                            </div>
                                            <div class="relative w-full max-w-xl">
                                                <input name="lname" id="lname" type="text" placeholder=" "
                                                       value=""
                                                       class="peer transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none"/>
                                                <p class="text-primary" id="lname-error"></p>
                                                <label
                                                        class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0">Last
                                                    Name</label>
                                            </div>
                                        </div>
                                        <div
                                                class="flex justify-start gap-5 mb-5 flex-col screen768:flex-row input-wrap">
                                            <div class="relative w-full max-w-xl">
                                                <input name="email" id="email" type="email" placeholder=" "
                                                       value=""
                                                       class="peer transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none"/>
                                                <p class="text-primary" id="email-error"></p>
                                                <label
                                                        class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0">Email</label>
                                            </div>
                                            <div class="relative w-full max-w-xl">
                                                <input name="phone" id="phone" type="tel" placeholder=" "
                                                       value=""
                                                       class="peer transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none"/>
                                                <p class="text-primary" id="phone-error"></p>
                                                <label
                                                        class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0">Phone</label>
                                            </div>
                                        </div>


                                        {{--<div class="select-package-wrapper">
                                            <div class="flex justify-start gap-5 mb-5 flex-col screen768:flex-row">
                                                <div class="relative w-full">
                                                    <div class="relative flex gap-5">
                                                        <select name="ticket-package" id="ticket-package" class="ticket-package-select-box w-1/2 transition-all p-2 text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none">
                                                            <option selected value="" selected>Select Package</option>
                                                            <option value="silver">Silver</option>
                                                            <option value="gold">Gold</option>
                                                            <option value="diamond">Diamond</option>
                                                        </select>
                                                        <div class="flex w-1/2 relative justify-center items-center ticket-count-wrapper opacity-50 select-none">
                                                            <input type="text" disabled class="select-none ticket-count-input text-center transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 px-14 outline-none focus:outline-none" value="0">
                                                            <label class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0 z-50">Ticket Quantity</label>
                                                            <button type="button" class="ticket-count-decrement ticket-count-btn absolute left-0 transition-all px-4 h-full bg-transparent hover:bg-gray hover:text-white text-2xl text-gray rounded-sm border-r disabled:text-gray disabled:bg-transparent disabled:cursor-not-allowed">-</button>
                                                            <button type="button" class="ticket-count-increment ticket-count-btn absolute right-0 transition-all px-4 h-full bg-transparent hover:bg-gray hover:text-white text-2xl text-gray rounded-sm border-l disabled:text-gray disabled:bg-transparent disabled:cursor-not-allowed">+</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Table Starts Here -->
                                            <div class="mx-auto">
                                                <div class="bg-white shadow-lg rounded-sm border overflow-y-auto max-h-60 relative">
                                                    <table class="table-auto w-full">
                                                        <thead class="text-gray border-b border-gray-500 sticky top-0 bg-white">
                                                        <tr class="border-gray-500">
                                                            <th class="py-3 px-4 text-center">Package Name</th>
                                                            <th class="py-3 px-4 text-center">Quantity</th>
                                                            <th class="py-3 px-4 text-center">Price</th>
                                                            <th class="py-3 px-4 text-center">Total</th>
                                                            <th class="py-3 px-4 text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <!-- Row 1 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 1</td>
                                                            <td class="py-3 px-4 text-center">2</td>
                                                            <td class="py-3 px-4 text-center">$50</td>
                                                            <td class="py-3 px-4 text-center">$100</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 2 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 2</td>
                                                            <td class="py-3 px-4 text-center">3</td>
                                                            <td class="py-3 px-4 text-center">$30</td>
                                                            <td class="py-3 px-4 text-center">$90</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 3 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 1</td>
                                                            <td class="py-3 px-4 text-center">2</td>
                                                            <td class="py-3 px-4 text-center">$50</td>
                                                            <td class="py-3 px-4 text-center">$100</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 4 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 2</td>
                                                            <td class="py-3 px-4 text-center">3</td>
                                                            <td class="py-3 px-4 text-center">$30</td>
                                                            <td class="py-3 px-4 text-center">$90</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 5 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 1</td>
                                                            <td class="py-3 px-4 text-center">2</td>
                                                            <td class="py-3 px-4 text-center">$50</td>
                                                            <td class="py-3 px-4 text-center">$100</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 6 -->
                                                        <tr class="hover:bg-gray-100 border-gray-500">
                                                            <td class="py-3 px-4 text-center">Package 2</td>
                                                            <td class="py-3 px-4 text-center">3</td>
                                                            <td class="py-3 px-4 text-center">$30</td>
                                                            <td class="py-3 px-4 text-center">$90</td>
                                                            <td class="py-3 px-4 text-center">
                                                                <button type="button" class="bg-red-500 text-white rounded-full w-6 hover:underline hover:bg-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- Footer with Subtotal -->
                                                    <div class="text-gray px-4 py-3 flex justify-between items-center sticky bottom-0 bg-white">
                                                        <span class="font-semibold px-4 text-center">Sub Total</span>
                                                        <span class="px-4 text-center">$190</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Table Ends Here -->
                                        </div>--}}

                                        <div class="select-package-wrapper">
                                            <div class="flex justify-start gap-5 mb-5 flex-col screen768:flex-row">
                                                <div class="relative w-full">
                                                    <div class="relative flex gap-5">
                                                        <select name="package" id="package"
                                                                class="ticket-package-select-box w-1/2 transition-all p-2 text-base text-gray rounded-sm border border-gray-500 outline-none focus:outline-none">
                                                            <option value="" selected>Select Package</option>
                                                        </select>
                                                        <div class="flex w-1/2 relative justify-center items-center ticket-count-wrapper">
                                                            <input type="text" name="tickets" id="tickets" disabled
                                                                   value="0"
                                                                   oninput="allowOnlyNumbers(this)"
                                                                   onpaste="allowOnlyNumbers(this)"
                                                                   class="select-none ticket-count-input text-center transition-all p-2 w-full text-base text-gray rounded-sm border border-gray-500 px-14 outline-none focus:outline-none">
                                                            <label for="tickets"
                                                                   class="text-gray-500 pointer-events-none absolute left-2 inset-y-0 h-fit flex items-center transition-all text-sm peer-focus:text-sm peer-placeholder-shown:text-base px-2 peer-focus:px-2 peer-placeholder-shown:px-2 bg-white peer-focus:bg-white peer-placeholder-shown:bg-transparent m-0 peer-focus:m-0 peer-placeholder-shown:m-auto -translate-y-1/2 peer-focus:-translate-y-1/2 peer-placeholder-shown:translate-y-0 z-50">Ticket
                                                                Quantity</label>
                                                            <button type="button"
                                                                    class="ticket-count-decrement ticket-count-btn absolute left-0 transition-all px-4 h-full bg-transparent hover:bg-gray hover:text-white text-2xl text-gray rounded-sm border-r disabled:text-gray disabled:bg-transparent disabled:cursor-not-allowed">
                                                                -
                                                            </button>
                                                            <button type="button"
                                                                    class="ticket-count-increment ticket-count-btn absolute right-0 transition-all px-4 h-full bg-transparent hover:bg-gray hover:text-white text-2xl text-gray rounded-sm border-l disabled:text-gray disabled:bg-transparent disabled:cursor-not-allowed">
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Table Starts Here -->
                                            <div class="mx-auto" id="package-table">
                                                <div class="bg-white shadow-lg rounded-sm border overflow-y-auto max-h-60 relative">
                                                    <table class="table-auto w-full">
                                                        <thead class="text-gray border-b border-gray-500 sticky top-0 bg-white">
                                                        <tr>
                                                            <th class="py-2 px-4 text-left">Package</th>
                                                            <th class="py-2 pr-8 text-right">Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="cart-items">
                                                        {{--<!-- Row 1 -->
                                                        <tr class="hover:bg-gray-100">
                                                            <td  class="py-2 px-4 text-left">
                                                                <div class="flex justify-start items-center gap-2">
                                                                    <p class="text-gray-700">Package 1</p>
                                                                    <p class="text-gray-600 text-sm">x2</p>
                                                                </div>
                                                            </td>


                                                            <td class="py-2 px-4 flex justify-end items-center gap-2">
                                                                <p class="text-gray-700">$10</p>
                                                                <button type="button" class="text-red-500 rounded-full hover:underline hover:text-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 2 -->
                                                        <tr class="hover:bg-gray-100">
                                                            <td  class="py-2 px-4 text-left">
                                                                <div class="flex justify-start items-center gap-2">
                                                                    <p class="text-gray-700">Package 1</p>
                                                                    <p class="text-gray-600 text-sm">x2</p>
                                                                </div>
                                                            </td>


                                                            <td class="py-2 px-4 flex justify-end items-center gap-2">
                                                                <p class="text-gray-700">$10</p>
                                                                <button type="button" class="text-red-500 rounded-full hover:underline hover:text-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 3 -->
                                                        <tr class="hover:bg-gray-100">
                                                            <td  class="py-2 px-4 text-left">
                                                                <div class="flex justify-start items-center gap-2">
                                                                    <p class="text-gray-700">Package 1</p>
                                                                    <p class="text-gray-600 text-sm">x2</p>
                                                                </div>
                                                            </td>


                                                            <td class="py-2 px-4 flex justify-end items-center gap-2">
                                                                <p class="text-gray-700">$10</p>
                                                                <button type="button" class="text-red-500 rounded-full hover:underline hover:text-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 4 -->
                                                        <tr class="hover:bg-gray-100">
                                                            <td  class="py-2 px-4 text-left">
                                                                <div class="flex justify-start items-center gap-2">
                                                                    <p class="text-gray-700">Package 1</p>
                                                                    <p class="text-gray-600 text-sm">x2</p>
                                                                </div>
                                                            </td>


                                                            <td class="py-2 px-4 flex justify-end items-center gap-2">
                                                                <p class="text-gray-700">$10</p>
                                                                <button type="button" class="text-red-500 rounded-full hover:underline hover:text-gray">
                                                                    <i class="fa-solid fa-xmark text-sm"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <!-- Row 5 -->
                                                        <tr class="hover:bg-gray-100">
                                                        <td  class="py-2 px-4 text-left">
                                                            <div class="flex justify-start items-center gap-2">
                                                                <p class="text-gray-700">Package 1</p>
                                                                <p class="text-gray-600 text-sm">x2</p>
                                                            </div>
                                                        </td>


                                                        <td class="py-2 px-4 flex justify-end items-center gap-2">
                                                            <p class="text-gray-700">$10</p>
                                                            <button type="button" class="text-red-500 rounded-full hover:underline hover:text-gray">
                                                                <i class="fa-solid fa-xmark text-sm"></i>
                                                            </button>
                                                        </td>
                                                    </tr>--}}
                                                        </tbody>
                                                        <tfoot class="w-full">
                                                        <!-- Footer with Subtotal -->
                                                        <tr class="bg-slate-50 w-full">
                                                            <td class="py-2 px-4 text-left w-full">
                                                                <div class="flex justify-start items-center gap-2">
                                                                    <p class="text-gray-700 font-semibold">Sub Total</p>
                                                                </div>
                                                            </td>

                                                            <td class="py-2 pr-8 flex justify-end items-center gap-2 w-full">
                                                                <p class="text-gray-700 font-semibold"
                                                                   id="cart-subtotal">$1000</p>
                                                            </td>
                                                        </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- Table Ends Here -->
                                        </div>

                                        <div class="my-5 flex flex-col gap-2">
                                            <div class="select-none">
                                                <input type="checkbox" name="event-updates" id="event-updates" checked
                                                       class="custom-input"/>
                                                <label for="event-updates" class="ml-2 cursor-pointer text-sm">Keep me
                                                    updated on more events and news from this event organizer.</label>
                                            </div>
                                            <div class="select-none">
                                                <input type="checkbox" name="best-events" id="best-events" checked
                                                       class="custom-input"/>
                                                <label for="best-events" class="ml-2 cursor-pointer text-sm">Send me
                                                    emails about the best events happening nearby or online.</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="flex flex-col gap-3">
                                    <p>
                                        By selecting Place Order, I agree to all
                                        <a href="https://caribbeanairforce.com/terms-and-conditions/" class="text-primary font-medium">Terms and Conditions </a>  & <a  class="text-primary font-medium" href="{{ route('privacy.policy') }}">Privacy Policy</a>
                                    </p>
                                    <button type="submit" id="place-order-btn"
                                            class="bg-gray w-fit text-white leading-8 text-base rounded-[4px] px-6 py-2 transition-all duration-500 border border-transparent hover:text-primary hover:bg-white hover:border hover:border-primary disabled:cursor-not-allowed">
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                        <aside class="relative w-full aside-buy-ticket-modal">
                            <button id="offline-close" onclick="closeModal()"
                                    class="cursor-pointer absolute top-8 right-16 lg:right-6 bg-white rounded-full p-1"
                                    type="button">
                                <svg width="26" height="26" viewBox="0 0 28 29" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M20.5998 20.6233L14.0001 14.0237M14.0001 14.0237L7.40044 7.42402M14.0001 14.0237L20.5998 7.42402M14.0001 14.0237L7.40044 20.6233"
                                            stroke="#bd191f" stroke-width="1.5" stroke-linecap="round"></path>
                                </svg>
                            </button>

                            <div>
                                <div class="w-full">
                                    <img class="mx-auto select-none max-h-[25rem] w-full lg:max-h-[34rem] object-cover"
                                         id="event-banner-display"
                                         src="https://events.caribbeanairforce.com/uploads/events/https-cdnevbuccom-images-688687759-4594291485-1-original20240202-180422-670846ecdaebe.jpeg"
                                         alt="event banner" draggable="false">
                                </div>
                                <div id="event-details-wrapper" class="w-full h-full pr-8 event-details-m">
                                    <div class="w-full h-full">

                                        <h6 class="text-base font-bold my-5 text-black capitalize">Order summary</h6>
                                        <input type="hidden" name="event_id" id="event_id" value="0">

                                        <div class="flex justify-between items-center pb-4">
                                            <p class="text-gray text-base font-light" id="ticket-package">Ticket
                                                Registration</p>
                                            <p class="text-gray text-base font-light" id="ticket-price">
                                                <span>$ 0</span>
                                                <input type="hidden" name="ticket_price" value="$ 0">
                                            </p>
                                        </div>
                                        <div class="flex justify-between items-center pb-4">
                                            <p class="text-gray text-base font-light">
                                                Available tickets
                                            </p>
                                            <p class="text-gray text-base font-light" id="available-qty">
                                                <span>{{ old('ticket_qty','0') }}</span>
                                                <i class="text-gray text-base font-light hidden"></i>
                                            </p>
                                        </div>
                                        <div class="flex justify-between items-center pb-4 border-b border-b-gray-100"
                                             id="ticket_id">
                                            <span class="text-gray text-base font-bold">{{ old('ticket_id', 'Ticket Id') }}</span>
                                            <input type="hidden" name="ticket_id" value="{{ old('ticket_id', '') }}">
                                        </div>

                                        <div class="flex flex-col gap-2 py-4 border-b border-b-gray-100">
                                            <div class="flex justify-between items-center" id="event_name">
                                                <p class="text-gray text-base font-light">Event Name</p>
                                                <span class="text-gray text-base font-light">{{ old('event_name', 'Event Name') }}</span>
                                                {{-- <input type="hidden" name="event_name"
                                                    value="{{ old('event_name', '') }}">
                                                --}}
                                            </div>
                                            <div class="flex justify-between items-center" id="event_address">
                                                <p class="text-gray text-base font-light">Event Address</p>
                                                <span class="text-gray text-base font-light">{{ old('event_address',
                                                    'Event
                                                    Address') }}</span>
                                                {{-- <input type="hidden" name="event_address"
                                                    value="{{ old('event_address', '') }}"> --}}
                                            </div>
                                            <div>
                                                <div class="flex justify-between items-center" id="event_type">
                                                    <p class="text-gray text-base font-light">Ticket Mode</p>
                                                    <span class="text-gray text-base font-light capitalize">
                                                        {{ old('event_type', 'Event Type')}}</span>
                                                    {{-- <input type="hidden" name="event_type"
                                                        value="{{ old('event_type', '') }}"> --}}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex justify-between items-center hidden"
                                                     id="ticket_location">
                                                    <p class="text-gray text-base font-light">Ticket Location</p>
                                                    <span class="text-gray text-base font-light capitalize">
                                                        {{ old('ticket_location', 'Ticket Location')}}</span>
                                                    {{-- <input type="hidden" name="event_type"
                                                        value="{{ old('event_type', '') }}"> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" flex justify-between items-center py-4" id="total_price">
                                        <h5 class="font-medium text-gray text-lg leading-6 tracking-[0.25px] uppercase hidden">
                                            Total
                                        </h5>
                                        <h5 class="font-medium text-gray text-lg leading-6 tracking-[0.25px] uppercase hidden">
                                            <span>{{ old('total_price', '$ 0.00') }}</span>

                                            <input type="hidden" name="total_price" value="{{ old('total_price', '') }}">
                                        </h5>
                                    </div>

                                </div>
                            </div>

                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- Modal Ends Here -->
@once
    @push('script')
        <script>
            $(document).ready(function () {
                handleCustomNumberInput();
                handlePackageWrapper();
                let packages = [], currentPackage = [], cart = [], total = 0;
                // validate form submission button state
                updateButtonState(cart);
                $('#fname, #lname, #email, #phone').on('input', () => updateButtonState(cart));

                // hide table when cart is empty
                if (cart?.length === 0) {
                    toggleTableVisibility(false);
                }

                $('.ticket_booking').on('click', function () {
                    ajaxLoader($(this), 'Buy Ticket');
                    const event_slug = $(this).data('slug');
                    $.ajax({
                        type: "GET",
                        url: `{{ route('events.index', ':slug') }}`.replace(':slug', event_slug),
                        success: function (event) {
                            if (event) {
                                console.log(event);
                                if (!arraysAreEqual(packages, event.paid_slots)) {
                                    cart = [];
                                    updateButtonState(cart);
                                    toggleTableVisibility();
                                    $('#tickets').val(0);
                                    handleTicketQuantity(0);
                                }
                                packages = event.paid_slots;
                                const packageName = $('#package').val();
                                populatePackages(packages);
                                if(packageName !== '' && packages.length > 0) {
                                    $('#package').val(currentPackage.name);
                                }
                                else {
                                    $('#package').val('');
                                }
                                handleEventDetails(event);
                                showCheckoutModel();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong! Please buy ticket again.',
                                })
                            }
                        }
                    });
                });

                // Select current package
                $('#package').on('change', function () {
                    const selectedPackage = $(this).val();
                    if (selectedPackage !== '') {
                        const packageExists = cart.some(item => item.name === selectedPackage);
                        currentPackage = packages.find(slot => slot.name === selectedPackage);
                        if (packageExists) {
                            const cartItem = cart.find(item => item.name === selectedPackage);
                            $('#tickets').val(cartItem.qty);
                            handleTicketQuantity(currentPackage.qty);
                        } else {
                            $('#tickets').val(0);
                            handleTicketQuantity(currentPackage.qty);
                        }
                        $('#ticket-package').text(currentPackage.name);
                        $('#ticket-price span').text(`$ ${currentPackage.price}`);
                        $('#ticket-price input').val(currentPackage.price);
                        $('#available-qty span').text(currentPackage.qty);
                    } else {
                        $('#ticket-package').text('Package');
                        $('#ticket-price span').text(`$ 0`);
                        $('#ticket-price input').val('$ 0');
                        $('#available-qty span').text(0);
                        handleTicketQuantity(0);
                    }
                });

                // Validate ticket quantity
                $(document).on('click', '.ticket-count-increment, .ticket-count-decrement', function () {
                    $('#tickets').trigger('change');
                });
                $('#tickets').on('change', function () {
                    let tickets = parseInt($(this).val());
                    if (isNaN(tickets)) {
                        tickets = 0;
                        $(this).val(0);
                        cart = cart.filter(item => item.name !== currentPackage.name);
                        total = populateCartItems(cart, total);
                        cart?.length === 0 && toggleTableVisibility();
                    }
                    if (tickets >= currentPackage.qty) {
                        $(this).val(currentPackage.qty);
                        tickets = currentPackage.qty;
                    }
                    handleTicketQuantity(currentPackage.qty);


                    const packageExistsInCart = cart.some(item => item.name === currentPackage.name);
                    if (packageExistsInCart) {
                        if (tickets === 0) {
                            cart = cart.filter(item => item.name !== currentPackage.name);
                            total = populateCartItems(cart, total);
                            cart?.length === 0 && toggleTableVisibility();
                        } else {
                            cart.find(item => item.name === currentPackage.name).qty = tickets;
                            total = populateCartItems(cart, total);
                        }
                    } else if(tickets > 0) {
                        cart = [...cart, {
                            name: currentPackage.name,
                            qty: tickets,
                            price: currentPackage.price
                        }];
                        toggleTableVisibility(true);
                        total = populateCartItems(cart, total);
                    }
                    updateButtonState(cart);
                });
                $('#cart-items').on('click', '.remove-cart-item', function () {
                    const cartItemName = $(this).data('name');
                    const packageExistsInCart = cart.some(item => item.name === cartItemName);
                    if (packageExistsInCart) {
                        cart = cart.filter(item => item.name !== cartItemName);
                        total = populateCartItems(cart, total);
                        cart?.length === 0 && toggleTableVisibility();
                        $('#tickets').val(0);
                        updateButtonState(cart);
                        handleTicketQuantity(currentPackage.qty);
                    }
                });
                $('#checkout-form').on('submit', function (e) {
                    e.preventDefault();
                    $('#place-order-btn').prop('disabled', true).addClass('opacity-50 select-none').text('Processing...');
                    const url = $(this).attr('action');
                    const tickets = cart.reduce((ticket, item) => ticket + item.qty, 0);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            _token: `{{ csrf_token() }}`,
                            fname: $('#fname').val(),
                            lname: $('#lname').val(),
                            email: $('#email').val(),
                            phone: $('#phone').val(),
                            cart: cart,
                            total: total,
                            tickets: tickets,
                            event_id: $('#event_id').val(),
                            ticket_id: $('#ticket_id input').val(),
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                window.location.href = response.redirect_url;
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                            $('#place-order-btn').prop('disabled', false).removeClass('opacity-50 select-none').text('Place Order');
                        },
                        error: function (response) {
                            if (response.status === 500) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.responseJSON.message,
                                });
                            }
                            if (response.status === 422) {
                                const errors = response.responseJSON.errors;
                                for (const field in errors) {
                                    const errorElement = $(`#${field}-error`);
                                    errorElement.text(errors[field]);
                                }
                            }
                            $('#place-order-btn').prop('disabled', false).removeClass('opacity-50 select-none').text('Place Order');
                        }
                    });
                });
            });
            const toggleTableVisibility = (visibility = false) => {
                const table = $('#package-table');
                visibility ? table.show() : table.hide();
            }, populatePackages = slots => {
                $('#package').html(`<option value="" selected>Select Package</option>`);
                if (slots?.length > 0) {
                    slots.forEach((slot) => {
                        $('#package').append(`<option value="${slot.name}">${slot.name}</option>`);
                    });
                }
            }, validateTicketForm = cart => {
                const fname = $('#fname');
                const lname = $('#lname');
                const email = $('#email');
                const phone = $('#phone');

                return fname && lname && email && phone && cart.length > 0;
            }, updateButtonState = cart => {
                const isValid = validateTicketForm(cart);
                $('#place-order-btn').prop('disabled', !isValid).toggleClass('opacity-50', !isValid).toggleClass('select-none', !isValid);
            }, validateTicketQuantity = (currentPackage, tickets) => {
                const availableTickets = currentPackage.qty;
                return tickets >= availableTickets;
            }, handleTicketQuantity = (qty) => {
                const tickets = parseInt($('#tickets').val());
                const disableDecrement = tickets <= 0;
                const disableIncrement = tickets >= qty;

                $('.ticket-count-decrement')
                    .prop('disabled', disableDecrement)
                    .toggleClass('opacity-50 select-none', disableDecrement);

                $('.ticket-count-increment')
                    .prop('disabled', disableIncrement)
                    .toggleClass('opacity-50 select-none', disableIncrement);

                $('#tickets')
                    .prop('disabled', disableIncrement)
                    .toggleClass('opacity-50 select-none', disableIncrement);
            }, populateCartItems = (cart, total) => {
                $('#cart-items').html('');
                cart.forEach(function (cartItem) {
                    cartItem.total = cartItem.price * cartItem.qty;
                    $('#cart-items').append(`
                    <tr class="hover:bg-gray-100">
                        <td  class="py-2 px-4 text-left">
                            <div class="flex justify-start items-center gap-2">
                                <p class="text-gray-700">${cartItem.name}</p>
                                <p class="text-gray-600 text-sm">x${cartItem.qty}</p>
                            </div>
                        </td>
                        <td class="py-2 px-4 flex justify-end items-center gap-2">
                            <p class="text-gray-700">$${cartItem.total}</p>
                            <button data-name="${cartItem.name}" type="button" class="remove-cart-item text-red-500 rounded-full hover:underline hover:text-gray">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </td>
                    </tr>
                `);
                });
                total = cart.reduce((cartTotal, item) => cartTotal + (parseInt(item.price) * item.qty), 0);
                $('#cart-subtotal').text(`$ ${total}`);
                return total;
            }, handleEventDetails = event => {
                $('#event_id').val(event.id);
                $('#ticket_id span').text(event.ticket_id);
                $('#ticket_id input').val(event.ticket_id);
                $('#event-banner-display').attr('src', event.image);
                $('#event_name span').text(event.name);
                $('#event_address span').text(event.address);
                $('#event_type span').text(event.ticket_mode);
                if (event.ticket_mode === 'offline') {
                    $('#form-wrapper').addClass('hidden');
                    $('#event-details-wrapper').addClass('pl-8');
                    $('#offline-close').removeClass('hidden');
                    $('#ticket_location').removeClass('hidden');
                    $('#ticket_location span').text(event.ticket_location);
                } else {
                    $('#form-wrapper').removeClass('hidden');
                    $('#total_price').removeClass('hidden');
                    $('#offline-close').addClass('hidden');
                    $('#ticket_location').addClass('hidden');
                    $('#ticket_location span').text('Ticket Location');
                }
            }, arraysAreEqual = (arr1, arr2) => {
                if (arr1?.length !== arr2?.length) return false;

                return arr1.every((obj1, index) => {
                    const obj2 = arr2[index];
                    return JSON.stringify(obj1) === JSON.stringify(obj2);
                });
            };
        </script>
    @endpush
@endonce