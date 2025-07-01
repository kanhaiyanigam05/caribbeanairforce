@extends('layout.front')
@push('title')
<title>{{ $meta->meta_title }}</title>
<meta name="keywords" content="{{ $meta->meta_keywords }}" />
<meta name="description" content="{{ $meta->meta_description }}" />
@endpush
@section('main')

    <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 disclaimer-policy">
        <h1 class="text-2xl font-semibold mb-4">Disclaimer for Ticket Sales and Advertising</h1>

        <div class="flex justify-start items-start gap-10 flex-col">
            <ol class="faq-wrapper w-full">
                <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                    <div class="border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Ticket Sales Disclaimer</h3>
                            <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">By purchasing tickets through our website, you agree to the following terms and conditions:</p>

                            <ol class="faq-wrapper w-full px-8">
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">No Refunds or Exchanges:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">All ticket sales are final. No refunds, exchanges, or cancellations are allowed unless otherwise specified by the event organizer. If an event is postponed, rescheduled, or canceled, ticket holders should contact the event organizer directly for rescheduling and refund policies.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Third-Party Events</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">Caribbean Air-Force website acts as a ticket distribution platform and is not responsible for the event's content, organization, or management. Any claims related to the event, including issues with entry, event changes, or quality, should be directed to the event organizer.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Ticketing Fees and Charges:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">Prices listed may include service fees, processing fees, or other charges. By purchasing, you agree to all associated costs. Please check the final amount carefully before confirming your purchase.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Identification and Admission:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">Ticket holders may be required to present identification at the venue for entry. Tickets are only valid if purchased directly from our site or authorized resellers. Counterfeit or unauthorized tickets may be invalid, and we assume no responsibility for tickets purchased through unauthorized third-party vendors.</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </li>


                <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                    <div class="border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Advertising Disclaimer</h3>
                            <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">Caribbean Air-Force website offers advertising opportunities to third-party businesses and organizations. By advertising with us, you agree to the following terms:</p>

                            <ol class="faq-wrapper w-full px-8">
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Advertiser Responsibility:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">We are not responsible for the accuracy, legality, or quality of advertised products or services. Advertisers are solely responsible for ensuring all claims made in their advertisements are accurate and comply with applicable laws and regulations in your state or country.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">No Endorsement:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">Placement of an advertisement on our site does not constitute an endorsement or recommendation by our company. We do not guarantee the quality, performance, or reliability of advertised products or services.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Third-Party Links and Content:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal">Our site may contain links to third-party websites or content in advertisements. We do not control or endorse these third-party sites and are not responsible for any losses or damages resulting from your use of such sites or reliance on their content.</p>
                                    </div>
                                </li>
                                <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                        <h3 class="font-semibold text-lg tracking-[0.05rem]">Limitation of Liability:</h3>
                                        <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                    </div>
                                    <div class="faq-answer-wrapper hide-faq-answer">
                                        <p class="py-4 pr-4 text-gray-700 text-base font-normal"> We are not liable for any direct, indirect, incidental, or consequential damages resulting from ticket purchases, attendance at events, or engagement with advertised content. Use of our platform for these purposes is entirely at your own risk.</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </li>
            </ol>

        </div>
        <div class="py-4">
            <p class="leading-[19px]">By continuing to purchase tickets or engage with advertisements on our site, you agree to these terms and acknowledge that our company bears no liability for third-party events, ticketing issues, or the actions of advertisers.</p>
        </div>
        <div class="flex justify-start items-start gap-4 flex-col">
            <p class="font-semibold text-lg tracking-[0.05rem]">Contact Us</p>
            <p class="leading-[19px]">If you have any questions about these terms, please contact us at <a class="text-primary font-semibold" href="mailto:info@caribbeanairforce.com">info@caribbeanairforce.com</a> or call us at <a class="text-primary font-semibold" href="tel:4045791211">404-579-1211</a>.</p>
        </div>
    </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            handleFaq();
        });
    </script>
@endpush