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
            <h2 class="text-2xl font-bold screen768:text-3xl my-5 text-black capitalize">Here is a list of <strong>Frequently Asked Questions (FAQs)</strong> for our online radio station:</h2>

            <div class="faq-wrapper">
                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How can I listen to the radio station?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">You can listen to our station through our website, mobile app, or via streaming platforms or download APP on Apple "CAForce".</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Is there a mobile app for the radio station?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Yes, we offer a mobile app for both iOS and Android, where you can stream live broadcasts, catch up on past shows, and interact with the station.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Can I request a song to be played?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Absolutely! You can submit song requests via our website or social media pages. We strive to play as many requests as possible.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Do I need to create an account to listen?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">No, you do not need an account to listen to our live broadcasts. However, creating an account may be necessary to access on-demand content or participate in giveaways.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How can I advertise on the station?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">If you're interested in advertising with us, please visit our "Advertise" section on the website to learn more about our ad packages and contact information.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Can I listen to past shows or podcasts?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Yes, we provide an archive of past broadcasts and podcasts on our website. You can listen to these shows at any time.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How do I submit a press release or event for broadcasting?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Press releases and event submissions can be sent via email to <a href="mailto:info@caribbeanairforce.com" class="text-primary font-semibold">info@caribbeanairforce.com</a> or submitted through the online form available on our website.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Can I volunteer or intern at the radio station?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">We welcome volunteers and interns! Please check the <a href="https://caribbeanairforce.com/contact-us/" class="text-primary font-semibold">"Careers"</a> or <a href="https://caribbeanairforce.com/contact-us/" class="text-primary font-semibold">"Get Involved"</a> section on our website for more details on how to apply. </p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">Why are there occasional commercials during broadcasts?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Commercials help support the station, allowing us to provide free content. If you'd like to listen without ads, you can subscribe to our premium service.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">What do I do if I experience technical issues while listening?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">If you’re having trouble streaming, please check your internet connection, or you can reach out to our support team via the <a href="https://caribbeanairforce.com/contact-us/" class="text-primary font-semibold">“Contact Us”</a> page.</p>
                    </div>
                </div>

                <div class="border-b border-gray-100 faq-item">
                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                        <h3 class="text-lg font-semibold">How can I interact with the station on social media?</h3>
                        <span class="text-gray-500">
                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                        </span>
                    </div>
                    <div class="faq-answer-wrapper hide-faq-answer">
                        <p class="py-4 pr-4 text-gray-700">Follow us on Facebook, Twitter, and Instagram to stay up to date with the latest shows, contests, and announcements. You can also interact with us through comments and direct messages.</p>
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