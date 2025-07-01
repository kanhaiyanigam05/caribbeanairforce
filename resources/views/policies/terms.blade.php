@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
@endpush
@section('main')

        <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 rights-policy">
            <h1 class="text-2xl font-semibold mb-4">Third-Party Event Posting Terms and Conditions </h1>
    
            <div class="flex justify-start items-start gap-10 flex-col">
                <p class="leading-[19px]">By posting events on Caribbean Air Force (referred to as “events.caribbeanairforce.com”), third-party users (referred to as “Organizers”) agree to the following Terms and Conditions. These terms govern the rights, responsibilities, and liabilities associated with posting content on the Platform.</p>
    
                <ol class="faq-wrapper w-full ml-3">
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Acceptance of Terms</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">By submitting content or events to the Platform, you agree to comply with these Terms and all applicable laws. If you do not agree, you are prohibited from using the Platform to post events.</p>
                            </div>
                        </div>
                    </li>

                    
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="faq-wrapper w-full">
                            <div class="border-b border-gray-100 faq-item">
                                <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                    <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Organizer Responsibilities</h3>
                                    <span class="text-gray-500">
                                        <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                    </span>
                                </div>
                                <div class="faq-answer-wrapper hide-faq-answer">
                                    <ol class="faq-wrapper w-full px-8">
                                        <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                <h3 class="font-semibold text-lg tracking-[0.05rem]">Accuracy of Information:</h3>
                                                <span class="text-gray-500">
                                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                </span>
                                            </div>
                                            <div class="faq-answer-wrapper hide-faq-answer">
                                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Organizers are solely responsible for ensuring the accuracy, completeness, and legality of all event information, including but not limited to event titles, descriptions, images, pricing, and ticketing.</p>
                                            </div>
                                        </li>
                                        <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                <h3 class="font-semibold text-lg tracking-[0.05rem]">Compliance with Laws:</h3>
                                                <span class="text-gray-500">
                                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                </span>
                                            </div>
                                            <div class="faq-answer-wrapper hide-faq-answer">
                                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">All posted events must comply with applicable local, state, and federal laws, including but not limited to intellectual property, consumer protection, and anti-discrimination laws.</p>
                                            </div>
                                        </li>
                                        <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                <h3 class="font-semibold text-lg tracking-[0.05rem]">Content Ownership:</h3>
                                                <span class="text-gray-500">
                                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                </span>
                                            </div>
                                            <div class="faq-answer-wrapper hide-faq-answer">
                                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Organizers must own or have authorization to use all materials submitted to the Platform, including logos, images, videos, and written descriptions.</p>
                                            </div>
                                        </li>
                                        <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                <h3 class="font-semibold text-lg tracking-[0.05rem]">Prohibited Content:</h3>
                                                <span class="text-gray-500">
                                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                </span>
                                            </div>
                                            <div class="faq-answer-wrapper hide-faq-answer">
                                                <div class="border-b border-gray-100 faq-item">
                                                    <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                                        <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Organizers are prohibited from posting content that:</h3>
                                                        <span class="text-gray-500">
                                                            <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                                        </span>
                                                    </div>
                                                    <div class="faq-answer-wrapper hide-faq-answer">
                                                        <ol class="w-full px-8">
                                                            <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Violates copyright, trademark, or intellectual property laws.</li>
                                                            <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Promotes hate speech, violence, or illegal activities.</li>
                                                            <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Contains false or misleading information.</li>
                                                            <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Harms the reputation or functionality of the Platform.</li>
                                                        </ol>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>



                    </li>

                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Intellectual Property</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <ol class="faq-wrapper w-full px-8">
                                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Ownership:</h3>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                        </div>
                                        <div class="faq-answer-wrapper hide-faq-answer">
                                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform does not claim ownership of the content submitted by Organizers. However, by posting content, Organizers grant the Platform a non-exclusive, royalty-free license to display, distribute, and promote the content in connection with the Platform's services.</p>
                                        </div>
                                    </li>
                                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Copyright and Trademark Compliance:</h3>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                        </div>
                                        <div class="faq-answer-wrapper hide-faq-answer">
                                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">Organizers warrant that their content does not infringe on the intellectual property rights of third parties.</p>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </li>

                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Indemnification</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Organizers agree to indemnify and hold harmless Caribbean Airforce, its affiliates, officers, and employees from and against all claims, damages, losses, and expenses arising out of:</p>
                                
                                <ol class="w-full px-8">
                                    <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Violations of these Terms.</li>
                                    <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Alleged infringement of intellectual property rights.</li>
                                    <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Legal disputes related to the event.</li>
                                </ol>
                            </div>
                        </div>
                    </li>

                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Liability and Disclaimers</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <ol class="faq-wrapper w-full px-8">
                                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Platform Responsibility:</h3>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                        </div>
                                        <div class="faq-answer-wrapper hide-faq-answer">
                                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform serves solely as a facilitator for event postings and ticket sales. Caribbeanairforce.com is not liable for the accuracy, legality, or quality of the events posted by Organizers.</p>
                                        </div>
                                    </li>
                                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                            <h3 class="font-semibold text-lg tracking-[0.05rem]">No Guarantees:</h3>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                        </div>
                                        <div class="faq-answer-wrapper hide-faq-answer">
                                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform does not guarantee ticket sales, audience size, or event success.</p>
                                        </div>
                                    </li>
                                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Third-Party Claims:</h3>
                                            <span class="text-gray-500">
                                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                            </span>
                                        </div>
                                        <div class="faq-answer-wrapper hide-faq-answer">
                                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform is not responsible for disputes between Organizers and third parties, including attendees, vendors, or contractors.</p>
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Content Removal</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform reserves the right to review, edit, or remove any content that violates these Terms or is deemed inappropriate, harmful, or in violation of applicable laws at its sole discretion.</p>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Termination</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform may suspend or terminate an Organizer’s account for violations of these Terms or misuse of the Platform.</p>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Privacy Policy</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">Organizers must comply with the Platform’s Privacy Policy, which governs the collection and use of attendee data.</p>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Dispute Resolution</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">All disputes related to these Terms shall be resolved through binding arbitration in accordance with the laws of [Your State/Country].</p>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Changes to Terms</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <p class="py-4 pr-4 text-gray-700 text-base font-normal">The Platform reserves the right to modify these Terms at any time. Organizers will be notified of significant changes via email or notice on the Platform. Continued use of the Platform after changes are made constitutes acceptance of the revised Terms.</p>
                        </div>
                    </li>

                    <li class="list-decimal font-semibold text-lg border-b border-gray-100 faq-item">
                        <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                            <h3 class="font-semibold text-lg tracking-[0.05rem]">Simple Pricing</h3>
                            <span class="text-gray-500">
                                <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                            </span>
                        </div>
                        <div class="faq-answer-wrapper hide-faq-answer">
                            <ol class="w-full px-8">
                                <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">No fees for free events</li>
                                <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">3.9% + $2.59 service fee per ticket</li>
                                <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">3.7% payment processing fee per order</li>
                                <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">$1.00 per ticket transaction fee</li>
                                <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Fees are paid by ticket buyers on paid tickets, unless Organizer chose to cover them.</li>
                            </ol>
                        </div>
                    </li>
                </ol>
            </div>
        </section>

        <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 rights-policy">
            <h1 class="text-2xl font-semibold mb-4">Disclosure Agreement </h1>
            <div class="flex justify-start items-start gap-10 flex-col">
                <p class="leading-[19px]">This disclosure agreement ensures the confidentiality, integrity, and protection of the Caribbean Air Force and all associated activities related to the development, design, and operation of the website, event, network, radio, and advertising company. By participating in this project, all associates, builders, designers, contractors, workers, and end users agree to the following terms and conditions</p>

                <ol class="faq-wrapper w-full ml-3">
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Confidentiality:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">All information, materials, and strategies provided or developed for this project are strictly confidential. No party shall disclose, share, or distribute any proprietary information to third parties without prior written consent from the Caribbean Air Force.</p>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Non-Compete:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Associates, builders, designers, contractors, workers, and end users agree not to use any knowledge, skills, or materials gained from this project to create or support any competing ventures, products, or services.</p>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Non-Destructive Intent:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">All parties agree that under no circumstances, whether deliberate or unintentional, will they:</p>
                                
                                <ol class="w-full px-8">
                                    <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Use any information, materials, or resources to harm, discredit, or destroy the Caribbean Air Force Brand, its reputation, or its operations.</li>
                                    <li class="list-decimal py-4 pr-4 text-gray-700 text-base font-normal">Engage in activities that undermine the integrity or growth of the Caribbean Air Force brand, whether online, offline, or within any associated or Caribbean markets. </li>
                                </ol>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Intellectual Property:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">All intellectual property, designs, concepts, and content developed for the website, event, network radio, and advertising company remain the sole property of the company. No party shall claim ownership or unauthorized use of these materials./p>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Accountability:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Any breach of this agreement will result in legal consequences, including but not limited to termination of contracts, monetary compensation for damages, and potential legal action to protect the brand and its interests.</p>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Commitment to Caribbean Integrity:</h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">All parties acknowledge this initiative's cultural and economic importance to the Caribbean community. They pledge to uphold values of respect, collaboration, and commitment to positively contributing to the Caribbean Air Force brand’s success.</p>
                            </div>
                        </div>
                    </li>
                    <li class="faq-wrapper list-decimal font-semibold text-lg w-full">
                        <div class="border-b border-gray-100 faq-item">
                            <div class="flex justify-between items-center py-4 pr-4 cursor-pointer faq-question-wrapper">
                                <h3 class="list-decimal font-semibold text-lg tracking-[0.05rem]">Password and Login: </h3>
                                <span class="text-gray-500">
                                    <i class="fa-solid fa-plus faq-expand-collapse-icon"></i>
                                </span>
                            </div>
                            <div class="faq-answer-wrapper hide-faq-answer">
                                <p class="py-4 pr-4 text-gray-700 text-base font-normal">Passwords, login information, and all banking and financial information of Caribbean Air Force or its clients are confidential. They cannot be shared or used for any purpose other than the Caribbean Air Force benefit.</p>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>

        </section>

        <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 rights-policy">
            <h1 class="text-2xl font-semibold mb-4">Contact Information</h1>
            <p class="leading-[19px]">If you have questions or concerns about these Terms, contact us at:</p>
    
            <div class="mt-5 flex flex-col gap-2 w-full">
                <a href="tel:404-579-1211" class="text-[15px] font-medium lg:text-lg">404-579-1211</a>
                <a href="mailto:info@caribbeanairforce.com" class="text-[15px] font-medium lg:text-lg">info@caribbeanairforce.com</a>
                <p class="hover:text-primary text-14px text-primary font-medium text-wrap">3343 Peachtree Rd NE Ste 145-1162</p>
                <p class="hover:text-primary text-14px text-primary font-medium text-wrap">Atlanta, GA 30326</p>
                <p class="hover:text-primary text-14px text-primary font-medium text-wrap">United States</p>
            </div>
    
            <p class="mt-8">By posting events on caribbeanairforce.com, you acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>
        </section>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            handleFaq();
        });
    </script>
@endpush