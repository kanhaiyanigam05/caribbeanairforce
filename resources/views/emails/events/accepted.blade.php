<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Request Approved</title>
</head>

<body>
    <table>

        <tbody>
            <tr>
                <td>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
                        style="max-width:700px;background:#e9e9e9; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:40px 20px">
                        <tbody>
                            <tr>
                                <td style="text-align:center;"><img width="250" src="{{ asset($data->logo) }}"
                                                                    title="Unifying Caribbean People Socially Mentally $ Economically" style="margin-top: 26px;" alt="logo"></td>
                            </tr>
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="padding:0 35px;">
                                    <div
                                        style="background:#bd191f;text-decoration: none !important;font-weight: 600;margin-top: 35px;padding: 30px 26px;display: inline-block;border-radius: 14px;">
                                        <h5 style="font-size:22px; margin: 0px;color: #fff;">
                                            Welcome to</h5>
                                        <h2 style="font-size:32px; margin: 15px 0px 0px; color: #fff; width:400px;">
                                            {{ $data->site_name }}</h2>
                                    </div>
                                    {{-- <h1
                                        style="color:#000; text-align: left; font-weight:700;  width: 90%; margin: 0px auto;font-size:34px;font-family:'Rubik',sans-serif;margin-top:30px;">
                                        Hello {{ $event->user->name }},</h1> --}}

                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        We are pleased to inform you that your event request has been approved.
                                        Your event is visible on our website now. Here is the link of your event:
                                    </p>
                                    {{-- <a target="_blank" href="{{ route('events.index', $event->slug) }}"
                                        style="width:200px; background: #bd191f;text-decoration: none !important;font-weight: 600;margin-top: 32px;color:
                                    #fff;text-transform: capitalize;font-size: 19px;padding: 14px 30px;display: inline-block;border-radius: 5px;">
                                        Event</a> --}}
                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        If you have any additional information or changes you'd like to make, please let
                                        us know. We will keep you updated once the listing is live.
                                    </p>

                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        Thank you for choosing {{ $data->site_name }} to promote your event. We look
                                        forward to helping you reach a wider audience!</p>
                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        Best regards</p>
                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        {{ $data->site_name }} Team</p>
                                    <p
                                        style="border-bottom: 2px grey solid;padding-bottom: 30px;font-size:20px;line-height: 32px;width: 80%;margin: 30px auto;">
                                        For more information, Contact Us : <br>
                                        <a href="###"
                                            style="font-size: 18px;text-decoration: none;">{{ $data->phone }}</a>&nbsp;
                                        <span style="font-size: 18px;">OR
                                        </span> &nbsp;<a href="###"
                                            style="font-size: 18px;text-decoration: none;">{{ $data->email }}</a>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 35px;">
                                    <p
                                        style="font-size:20px;line-height: 32px;margin: 0px;text-align: center; margin-top: 10px;">
                                        <span
                                            style="border-right: 1px grey solid;padding-right: 6px;font-size: 18px;">{{ $data->site_name }}</span>
                                        <span style="font-size: 18px;">Copyright © 2024</span>
                                    </p>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>


            </tr>

        </tbody>

    </table>
</body>

</html>
