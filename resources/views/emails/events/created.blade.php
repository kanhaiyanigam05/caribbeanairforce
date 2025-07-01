<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Event Request Received</title>
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
                                        title="logo" style="margin-top: 26px;" alt="logo"></td>
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
                                    <h1
                                        style="color:#000; text-align: left; font-weight:700;  width: 90%; margin: 0px auto;font-size:34px;font-family:'Rubik',sans-serif;margin-top:30px;">
                                        Dear {{ $data->site_name }} Team</h1>
                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        A new event request has been submitted through website. Here are the details of
                                        the event:</p>
                                    <div style="text-align: left; width: 90%;margin: 0px auto;margin-top:20px;">
                                        <p
                                            style="width:40%;display:inline-block;margin:0;font-weight:600;font-size:18px;    text-align: left;">
                                            Event Name:</p> <span>{{ $event->name }}</span>
                                    </div>
                                    <div style="text-align: left; width: 90%;margin: 0px auto;margin-top:20px;">
                                        <p
                                            style="width:40%;display:inline-block;margin:0;font-weight:600;font-size:18px;    text-align: left;">
                                            Start At:</p>
                                        <span style="font-weight:400;">{{ "{$event->next_slot?->date?->format('D, M j')}, {$event->next_slot?->start_time?->format('h:i A')}" }}</span>
                                    </div>
                                    <div style="text-align: left; width: 90%;margin: 0px auto;margin-top:20px;">
                                        <p
                                            style="width:40%;display:inline-block;margin:0;font-weight:600;font-size:18px;    text-align: left;">
                                            Venue:</p>
                                        <span
                                            style="font-weight:400;">{{ $event->venue }}</span>
                                    </div>
                                    <div style="text-align: left; width: 90%;margin: 0px auto;margin-top:20px;">
                                        <p
                                            style="width:40%;display:inline-block;margin:0;font-weight:600;font-size:18px;    text-align: left;">
                                            Address:</p>
                                        <span style="font-weight:400;">{{ $event->address }}</span>
                                    </div>
                                    <p
                                        style="color:#000; text-align: left; width: 90%;margin: 0px auto; font-size:18px;line-height:30px; margin-top:30px;font-weight:400;">
                                        Please review the details and take the necessary steps to list this event on the
                                        website. If any additional information is needed or if there are any questions,
                                        please reach out to the organizer using the contact information provided:</p>
                                    <a target="_blank" href="{{ route('admin.events.show', $event->slug) }}"
                                        style="width:200px; background-color: #bd191f;text-decoration: none !important;font-weight: 600;margin: 32px 0;color:
                                                     #fff;text-transform: capitalize;font-size: 19px;padding: 14px 30px;display: inline-block;border-radius: 5px;">
                                        View Details</a>
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
