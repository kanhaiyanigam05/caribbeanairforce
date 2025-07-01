@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}" />
    <meta name="description" content="{{ $meta->meta_description }}" />
@endpush
@section('main')
    <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 disclaimer-policy">
        <!-- Faq Starts Here -->
        <div class="my-10">
            <h2 class="text-2xl font-bold screen768:text-3xl my-5 text-black capitalize">Common Frequently Asked Questions</h2>

            <div class="faq-wrapper">
                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How do I purchase tickets for the event?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Tickets can be purchased directly on <a href="https://events.caribbeanairforce.com" class="text-primary font-semibold">https://events.caribbeanairforce.com</a> our website. Simply choose your event, select the number of tickets, and follow the prompts to complete your purchase. You’ll receive an email confirmation with your ticket details.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Can I get a refund if I can’t attend?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">All sales are generally final, and refunds are not available unless the event is canceled or rescheduled. In certain cases, we may offer exchanges or credits—please review our refund policy for details or contact customer support for assistance.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">What if the event is canceled or postponed?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">If an event is canceled, you’ll receive a full refund automatically. If the event is rescheduled, your ticket will be valid for the new date, or you may request a refund if you can’t attend on the rescheduled date.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">When will I receive my tickets?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">After completing your purchase, you’ll receive an email confirmation with your digital ticket attached within minutes. For physical tickets, please allow 3-7 business days for delivery. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How can I change my seating or upgrade my ticket?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Upgrades or seating changes may be available depending on the event. Contact your promoter, organizer or customer support with your request, and we’ll do our best to accommodate, subject to availability. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Do I need to print my ticket, or can I show it on my phone? </h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">You can present your ticket on your phone at the entrance, or you may print it if you prefer. Please make sure the QR code or barcode is clearly visible. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Can I transfer my ticket to someone else?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Yes, tickets are typically transferable unless stated otherwise. Please check our terms for specific restrictions or contact support if you need help with the transfer process. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Are there any age restrictions for this event? </h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Age restrictions vary by event. Please check the event page for age-related guidelines, as certain events may be 18+ or 21+ only.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Is parking included with my ticket? </h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Parking policies differ per venue. Some events offer complimentary or discounted parking, while others require a separate parking fee. Check the event page or contact us for venue-specific parking information. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How early should I arrive at the event?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">We recommend arriving at least 30–60 minutes before the event start time to allow for parking, security checks, and seating. Doors typically open one hour before the event. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How do I contact support if I have a problem with my ticket?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">You can reach our customer support team via email at <a href="mailto:info@caribbeanairforce.com" class="text-primary font-semibold">info@caribbeanairforce.com</a> or call us at <a href="tel:404-579-1211" class="text-primary font-semibold">404- 579-1211</a>. Our team is available to assist with any ticketing issues or questions. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">What COVID-19 precautions are in place?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">We follow all local and venue guidelines for health and safety. Face masks, vaccination cards, or negative test results may be required depending on the event. Please review the event page for specific COVID-19 protocols. </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Faq Ends Here -->
    </section>

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            handleFaq();
        });
    </script>
@endpush