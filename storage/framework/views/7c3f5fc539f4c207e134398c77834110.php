<?php $__env->startPush('style'); ?>
    <style>
        .share-modal {
            background: rgba(57, 54, 79, 0.8);
            height: 100%;
            overflow: hidden;
            position: fixed;
            width: 100%;
            display: none;
            z-index: 0;
            -webkit-box-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            align-items: center;
            animation: 0.24s linear 1 forwards;
            justify-content: center;
            align-items: center;
            transition: 0.3s ease all;
        }

        .share-modal.show {
            display: flex;
            left: 0;
            top: 0;
            z-index: 1999999999;
        }

        .share-modal-inner-wrapper {
            background: white;
            width: fit-content;
            min-width: 600px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .share-modal-header {
            padding: 0.8rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.137);
            width: 100%;
            position: relative;
        }

        .share-modal-body {
            padding: 1rem;
            width: 100%;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .share-modal-header h5 {
            font-size: 1.125rem;
            line-height: 1.5rem;
            font-weight: 600;
            letter-spacing: 0.25px;
            color: #39364f;
            text-align: center;
        }

        .share-modal-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin: 0 auto;
            max-width: 80%;
            gap: 10px;
        }

        .share-modal-logo-item {
            text-decoration: none;
            width: 35px;
            transition: 0.2s ease all;
            padding: 0.3rem;
            border-radius: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            display: block;
        }

        .share-modal-logo-item * {
            display: block;
            margin: 0 auto;
            height: 24px;
            width: 24px;
        }

        .share-modal-logo-item:hover {
            background: #0000000e;
        }

        .share-modal-share-link-wrapper {
            padding: 12px;
            position: relative;
        }

        .share-modal-share-link-wrapper label {
            user-select: none;
        }

        .share-modal-share-link-wrapper input {
            font-size: 14px;
            line-height: 22px;
            border: 1px solid rgba(0, 0, 0, 0.301);
            outline: none;
            padding: 22px 54px 6px 20px;
            width: 100%;
        }

        .share-modal-share-link-wrapper label {
            position: absolute;
            top: 15px;
            padding-left: 20px;
            font-size: 12px;
            line-height: 22px;
            color: #39364f;
        }

        .share-modal-share-link-wrapper .share-modal-share-link-button {
            position: absolute;
            top: 50%;
            right: 20px;
            padding-right: 10px;
            transform: translateY(-50%);
        }

        .share-button {
            box-sizing: border-box;
            width: 36px;
            height: 36px;
            color: #cccccc;
            border: none;
            cursor: pointer;
            position: relative;
            outline: none;
        }

        .share-button-tooltip {
            position: absolute;
            opacity: 0;
            visibility: 0;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 12px;
            color: rgb(50, 50, 50);
            background: #f4f3f3;
            padding: 7px;
            border-radius: 4px;
            pointer-events: none;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .share-button-tooltip::before {
            content: attr(data-text-initial);
        }

        .share-button-tooltip::after {
            content: "";
            position: absolute;
            bottom: calc(7px / 2 * -1);
            width: 7px;
            height: 7px;
            background: inherit;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            z-index: -999;
            pointer-events: none;
        }

        .share-button svg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .share-button-checkmark {
            display: none;
        }

        .share-button:hover .share-button-tooltip,
        .share-button:focus:not(:focus-visible) .share-button-tooltip {
            opacity: 1;
            visibility: visible;
            top: calc((100% + 8px) * -1);
        }

        .share-button:focus:not(:focus-visible) .share-button-tooltip::before {
            content: attr(data-text-end);
        }

        .share-button:focus:not(:focus-visible) .clipboard-icon {
            display: none;
        }

        .share-button:focus:not(:focus-visible) .share-button-checkmark {
            display: block;
        }

        .share-button:active {
            outline: 1px solid rgba(0, 0, 0, 0.301);
        }

        .close-share-modal-btn {
            position: absolute;
            right: 0.8rem;
            top: 0.8rem;
            height: 24px;
            width: 24px;
            display: flex;
            align-items: center;
        }

        @media only screen and (max-width: 660px) {
            .share-modal-inner-wrapper {
                width: 90%;
                min-width: fit-content;
            }
        }

    </style>
<?php $__env->stopPush(); ?>
<section class="share-modal">
    <div class="share-modal-inner-wrapper">
        <div class="share-modal-header">
            <button class="close-share-modal-btn" onclick="closeShareModal(this);">
                <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" aria-hidden="true">
              <path d="M13.4 12l3.5-3.5-1.4-1.4-3.5 3.5-3.5-3.5-1.4 1.4 3.5 3.5-3.5 3.5 1.4 1.4 3.5-3.5 3.5 3.5 1.4-1.4z"></path>
            </svg>
            </button>
            <h5>Share with friends</h5>
        </div>
        <div class="share-modal-body">
            <div class="share-modal-logos">
                <a href="javascript:void(0);" class="facebook-share share-modal-logo-item">
                    <svg viewBox="0 0 22 22">
                        <path d="M14.893 11.89L15.336 9h-2.773V7.124c0-.79.387-1.562 1.63-1.562h1.26v-2.46s-1.144-.196-2.238-.196c-2.285 0-3.777 1.385-3.777 3.89V9h-2.54v2.89h2.54v6.989a10.075 10.075 0 003.124 0V11.89h2.33"
                              fill="#4b4d63"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="messenger-share share-modal-logo-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M12.7 14.5l5.2-5.8-4.6 2.9-2.7-2.9-5.2 5.8 4.8-2.7 2.5 2.7zM12 2c5.5 0 10 4.1 10 9.2s-4.5 9.2-10 9.2c-1 0-2.1-.1-3-.4l-3.3 2v-3.6C3.4 16.7 2 14.1 2 11.2 2 6.1 6.5 2 12 2z"
                              fill="#4b4d63"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="linkedin-share share-modal-logo-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M20.45 2H3.55A1.55 1.55 0 0 0 2 3.55v16.9A1.55 1.55 0 0 0 3.55 22h16.9A1.55 1.55 0 0 0 22 20.45V3.55A1.55 1.55 0 0 0 20.45 2zM8.3 19H5.4V9.8h2.9V19zm-1.45-10.3a1.7 1.7 0 1 1 0-3.4 1.7 1.7 0 0 1 0 3.4zm12.2 10.3h-2.9v-4.7c0-1.1 0-2.5-1.5-2.5s-1.7 1.2-1.7 2.4V19h-2.9V9.8h2.8v1.3h.04c.38-.72 1.3-1.46 2.68-1.46 2.86 0 3.39 1.88 3.39 4.33V19z"
                              fill="#4b4d63"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="twitter-share share-modal-logo-item">
                    <svg viewBox="0 0 24 24">
                        <path d="M21.4 4.1s-.6.4-1.2.7c-.6.2-1.3.4-1.3.4s-2-2.3-4.9-.8c-2.9 1.5-2 4.5-2 4.5s-2.9-.2-4.9-1.2C4.9 6.5 3.4 4.6 3.4 4.6s-.9 1.4-.5 3 1.8 2.5 1.8 2.5-.4 0-.9-.2c-.5-.1-1-.4-1-.4s-.1 1.3.8 2.6S6 13.6 6 13.6l-.8.2h-.9s.2 1.1 1.4 2c1.1.8 2.3.8 2.3.8s-1.1.9-2.7 1.4c-1.6.5-3.3.3-3.3.3s6 4 12.2.3c6.2-3.7 5.7-10.7 5.7-10.7s.6-.4 1-.9l1-1.2s-.7.3-1.3.5c-.5.2-.9.2-.9.2s.6-.4.9-.9c.5-.7.8-1.5.8-1.5z"
                              fill="#4b4d63"/>
                    </svg>
                </a>
                <a href="javascript:void(0);" class="mail-share share-modal-logo-item">
                    <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                <path d="M12 14.2L4 8.4V18h16V8.4l-8 5.8z" fill="#4b4d63"></path>
                        <path d="M4.1 6l7.9 5.8L19.9 6z" fill="#4b4d63"></path>
              </svg>
                </a>
            </div>
            <div class="share-modal-share-link-wrapper share-current-link">
                <label for="share-link">Event URL</label>
                <input type="text" name="share-link" id="share-link" class="share-link-input"/>
                <button class="share-button share-modal-share-link-button share-current-link-btn"
                        onclick="copyShareLink(this)">
                    <span data-text-end="Copied!" data-text-initial="Copy to clipboard"
                          class="share-button-tooltip"></span>
                    <span>
                        <svg x="0" y="0" viewBox="0 0 24 24" xml:space="preserve" height="20" width="20"
                             class="clipboard-icon">
                          <path fill="#4b4d63" fill-rule="evenodd" clip-rule="evenodd"
                                d="M4 8v12h12V8H4zm10 10H6v-8h8v8z"></path>
                          <path fill="#4b4d63" fill-rule="evenodd" clip-rule="evenodd"
                                d="M20 5v10h-2V6h-8V4h10v1z"></path>
                        </svg>
                        <svg xml:space="preserve" style="enable-background: new 0 0 512 512" viewBox="0 0 24 24" y="0"
                             x="0"
                             height="18" width="18" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                             xmlns="http://www.w3.org/2000/svg" class="share-button-checkmark">
                          <g>
                            <path data-original="#4b4d63" fill="#4b4d63"
                                  d="M9.707 19.121a.997.997 0 0 1-1.414 0l-5.646-5.647a1.5 1.5 0 0 1 0-2.121l.707-.707a1.5 1.5 0 0 1 2.121 0L9 14.171l9.525-9.525a1.5 1.5 0 0 1 2.121 0l.707.707a1.5 1.5 0 0 1 0 2.121z"></path>
                          </g>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
</section>

<?php $__env->startPush('script'); ?>
    <script>
        function copyShareLink() {
            const linkInput = $(".share-link-input");
            linkInput.select();
            document.execCommand("copy");
        }


        function closeShareModal(button) {
            $(".share-modal").each(function () {
                console.log("Close");
                $(this).removeClass("show");
                $(".share-current-link").find(".share-link-input").val('');
            });
        }
        // $(document).on('click', function(e) {
        //     if (!$(e.target).is('.share-modal') && $(e.target).closest('.share-modal').hasClass('show')) {
        //         closeShareModal();
        //     }
        // });

        $(document).on('click', function(e) {
            // Check if the clicked element is outside the modal
            if (!$(e.target).closest('.share-modal-inner-wrapper').length && $(e.target).closest('.share-modal').hasClass('show')) {
                closeShareModal();
            }
        });


        function openShareModal(button, url) {
            $(".share-modal").each(function () {
                console.log("Open");
                $(this).addClass("show");
                $(".share-current-link").find(".share-link-input").val(url);

                // Update the share URLs with the provided URL
                $(".facebook-share").attr("href", "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(url));
                $(".messenger-share").attr("href",
                    "https://www.facebook.com/dialog/send?" +
                    $.param({
                        link: url,
                        app_id: '1148834913260669', // replace with your actual Facebook app ID
                        redirect_uri: url // replace with your redirect URI
                    })
                );
                $(".linkedin-share").attr("href", "http://www.linkedin.com/shareArticle?mini=true&url=" + encodeURIComponent(url));
                $(".twitter-share").attr("href", "https://twitter.com/intent/tweet?url=" + encodeURIComponent(url) + "&text=Check this out!");
                $(".mail-share").attr("href", "mailto:?subject=Check this out!&body=" + encodeURIComponent(url));
            });

            // Set up click event to open share links in a new window
            $(".facebook-share, .messenger-share, .twitter-share, .mail-share").on("click", function (e) {
                e.preventDefault();
                const href = $(this).attr("href");
                window.open(href, "_blank");
            });
        }


    </script>
<?php $__env->stopPush(); ?><?php /**PATH E:\laragon\www\caribbean-airforce\resources\views/models/share.blade.php ENDPATH**/ ?>