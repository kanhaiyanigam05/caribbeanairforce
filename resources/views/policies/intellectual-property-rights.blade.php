@extends('layout.front')
@push('title')
    <title>{{ $meta->meta_title }}</title>
    <meta name="keywords" content="{{ $meta->meta_keywords }}"/>
    <meta name="description" content="{{ $meta->meta_description }}"/>
@endpush
@section('main')
    <section class="px-14 xl:px-0 max-w-[1200px] mx-auto my-16 rights-policy">
        <h1 class="text-2xl font-semibold mb-4">Intellectual Property Rights Policy</h1>

        <div class="flex justify-start items-start gap-10 flex-col">
            <p class="leading-[19px]">Our organization is committed to respecting intellectual property (IP) rights and ensuring that our platform operates with integrity, transparency, and compliance with all applicable IP laws. By using our platform, you agree to abide by the following policies:</p>

            <ol class="flex justify-start items-start gap-6 flex-col">
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">Ownership of Content</li>
                    <p class="leading-[19px]">All content, trademarks, logos, images, text, and other materials displayed on this platform are the exclusive property of our organization or our content providers and are protected under intellectual property laws. Unauthorized use, reproduction, or distribution of this content is strictly prohibited.</p>
                </div>
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">User-Generated Content</li>
                    <p class="leading-[19px]">Users who upload, share, or otherwise make content available on our platform represent and warrant that they own or have obtained necessary permissions for any IP rights associated with their content. We reserve the right to remove or disable access to content that infringes on third-party rights.</p>
                </div>
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">Reporting IP Infringement</li>
                    <p class="leading-[19px]">If you believe that content on our platform infringes your IP rights, please contact us immediately at info@caribbeanairforce.com. Upon receipt of a complete and valid notice, we will investigate the issue promptly and may remove or restrict access to the infringing content as needed.</p>
                </div>
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">Fair Use and Permissible Use</li>
                    <p class="leading-[19px]">Certain uses of content may fall under "fair use" as defined by applicable copyright laws. However, users should consult the legal standards of fair use and ensure they have proper authorization for any use that may extend beyond fair use.</p>
                </div>
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">Policy Violations</li>
                    <p class="leading-[19px]">Violations of this policy may result in actions including content removal, suspension of user accounts, and other legal remedies as appropriate. Repeat offenders may face permanent restrictions from our platform.</p>
                    <p class="leading-[19px]">By accessing and using this platform, you agree to comply with this Intellectual Property Rights Policy. We appreciate your cooperation in helping to maintain a respectful, lawful online environment.</p>
                </div>
                <div class="flex justify-start items-start gap-4 flex-col">
                    <li class="list-decimal font-semibold text-lg tracking-[0.05rem]">Contact Us</li>
                    <p class="leading-[19px]">For any questions about our policy or to report potential infringements, please reach out at <a class="text-primary font-semibold" href="mailto:info@caribbeanairforce.com">info@caribbeanairforce.com</a></p>
                </div>
            </ol>
        </div>
    </section>

@endsection