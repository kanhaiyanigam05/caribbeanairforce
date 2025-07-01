import "./echo";

/*window.Echo.channel("emailing").listen("MailEvent", (data) => {
    const tbody = document.getElementById("mail-status");
    const row = `
                    <tr>
                        <td>${data.to}</td>
                        <td>${data.status}</td>
                    </tr>
                `;
    tbody.insertAdjacentHTML("beforeend", row);
});*/

let totalEmails = 0,
    sentEmails = 0,
    failedEmails = 0,
    progress = 0;

$(document).ready(function () {
    const select = new SlimSelect({
        select: "#multiple",
        settings: {
            placeholderText: "Select Email Recipients",
        },
    });

    $(".search-results button").on("click", function (e) {
        var selectedEmails = $(this).attr("value").split(",");

        select.setData(
            $("#multiple option")
                .map(function () {
                    return {
                        text: $(this).text(),
                        value: $(this).val(),
                    };
                })
                .get()
        );

        select.setSelected(selectedEmails);

        $("#multiple").trigger("change");
    });
    $(".dropdown-toggle").on("click", function () {
        select.close();
    });

    $("#compose-mail").on("submit", function (e) {
        e.preventDefault();
        const form = $(this);

        totalEmails = select.getSelected().length;

        const selectedEmails = select.getSelected();
        $("#multiple").val(selectedEmails);

        const formData = new FormData(form[0]);

        $(".errors").text("");
        $.ajax({
            url: form.attr("action"),
            method: form.attr("method"),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                form[0].reset();
                select.setSelected([]);
                emailProgress(sentEmails, failedEmails, totalEmails);
                $(".progress-btn").trigger("click");
            },
            error: function (xhr, status, error) {
                console.error("Error:", xhr, status, error);
                Swal.fire({
                    title: "Failed!",
                    text: "Failed to send email. Please try again.",
                    icon: "error",
                });
                if (xhr.status == 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (field, error) {
                        if (field.includes("attachments.")) {
                            $(".error_attachments").append(error[0] + "<br />");
                        } else {
                            $(".error_" + field).text(error[0]);
                        }
                    });
                }
            },
        });
    });
});

function emailProgress(sentEmails, failedEmails, totalEmails) {
    progress = (((sentEmails + failedEmails) / totalEmails) * 100).toFixed(0);
    $(".total-emails").text(totalEmails);
    $(".sent-emails").text(sentEmails);
    $(".failed-emails").text(failedEmails);
    $(".progress-emails").text(progress + "%");
    $(".progress-bar").css("width", progress + "%");
    console.log(
        `Total: ${totalEmails}, Sent: ${sentEmails}, Failed: ${failedEmails}, Progress: ${progress}`
    );
    return progress;
}
window.Echo.channel("emailing").listen("MailEvent", (data) => {
    const tbody = document.getElementById("email-status");
    let row = null;
    if (data.status === "failed") {
        ++failedEmails;
        progress = emailProgress(sentEmails, failedEmails, totalEmails);
        row = `
            <tr class="text-black text-sm font-medium">
                <td class="p-[10px] w-[10%]">${data.to}</td>
                <td class="p-[10px] w-[80%]">
                    <div class="h-1 w-full bg-[#bebebe] rounded-full">
                        <div class="h-full w-full bg-primary rounded-full"></div>
                    </div>
                </td>
                <td class="p-[10px] text-end w-[10%]">
                    <button class="text-primary flex justify-end items-center w-full group">
                        <svg class="transition-all duration-300 group-active:rotate-[360deg]" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                            <path class="fill-primary group-active:fill-black" d="M12.4253 18.5684C12.4253 18.7673 12.3463 18.958 12.2056 19.0987C12.065 19.2393 11.8742 19.3184 11.6753 19.3184C7.8833 19.3184 4.7793 16.3134 4.7793 12.5684C4.7793 8.82336 7.8833 5.81836 11.6753 5.81836C14.7803 5.81836 17.4243 7.83336 18.2803 10.6194L18.8833 9.59936C18.9845 9.42803 19.1496 9.30391 19.3423 9.25431C19.535 9.2047 19.7395 9.23368 19.9108 9.33486C20.0821 9.43604 20.2062 9.60114 20.2558 9.79383C20.3055 9.98652 20.2765 10.191 20.1753 10.3624L18.5453 13.1174C18.4455 13.2864 18.2834 13.4095 18.0938 13.4604C17.9042 13.5112 17.7023 13.4857 17.5313 13.3894L14.7093 11.7984C14.6235 11.75 14.548 11.6851 14.4873 11.6076C14.4265 11.53 14.3816 11.4413 14.3551 11.3464C14.3287 11.2515 14.3212 11.1523 14.333 11.0545C14.3449 10.9567 14.3759 10.8622 14.4243 10.7764C14.4727 10.6905 14.5375 10.6151 14.6151 10.5543C14.6926 10.4936 14.7814 10.4487 14.8763 10.4222C14.9712 10.3957 15.0704 10.3882 15.1682 10.4001C15.266 10.412 15.3605 10.443 15.4463 10.4914L16.9183 11.3214C16.3443 9.03336 14.2273 7.31836 11.6763 7.31836C8.6783 7.31836 6.2793 9.68536 6.2793 12.5684C6.2793 15.4514 8.6783 17.8184 11.6753 17.8184C11.8742 17.8184 12.065 17.8974 12.2056 18.038C12.3463 18.1787 12.4253 18.3694 12.4253 18.5684Z" />
                        </svg>
                        ${
                            data.status.charAt(0).toUpperCase() +
                            data.status.slice(1).toLowerCase()
                        }
                    </button>
                </td>
            </tr>
        `;
    } else {
        ++sentEmails;
        progress = emailProgress(sentEmails, failedEmails, totalEmails);
        row = `
            <tr class="text-black text-sm font-medium">
                <td class="p-[10px] w-[10%]">${data.to}</td>
                <td class="p-[10px] w-[80%]">
                    <div class="h-1 w-full bg-[#bebebe] rounded-full">
                        <div class="h-full w-full bg-success rounded-full"></div>
                    </div>
                </td>
                <td class="p-[10px] text-end w-[10%]">${
                    data.status.charAt(0).toUpperCase() +
                    data.status.slice(1).toLowerCase()
                }</td>
            </tr>
        `;
    }
    tbody.insertAdjacentHTML("beforeend", row);
    console.log(data);
});
