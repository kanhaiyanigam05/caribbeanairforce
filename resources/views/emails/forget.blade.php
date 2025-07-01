<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password Mail</title>
</head>

<body>

    <tbody>
        <tr>
            <td>
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
                    style="max-width:700px;background:#e9e9e9; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:40px 20px">
                    <tbody>
                        <tr>
                            <td style="text-align:center;"><img width="250" src="{{ asset($data->logo) }}" title="Unifying Caribbean People Socially Mentally $ Economically"
                                    style="margin-top: 26px;" alt="logo"></td>
                        </tr>
                        <tr>
                            <td style="height:40px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="padding:0 35px;">
                                <div
                                    style="background:#512376;text-decoration: none !important;font-weight: 600;margin-top: 35px;padding: 30px 26px;display: inline-block;border-radius: 14px;">
                                    <h5 style="font-size:22px; margin: 0px;color: #fff;">
                                        Welcome to</h5>
                                    <h2 style="font-size:32px; margin: 15px 0px 0px; color: #fff; width:400px;">
                                        {{ $data->site_name }}</h2>
                                </div>
                                {{-- <h1
                                    style="color:#000; font-weight:700; margin:0;font-size:34px;font-family:'Rubik',sans-serif;margin-top:30px;">
                                    UserName</h1> --}}

                                <p
                                    style="color:#000; font-size:18px;line-height:30px;margin:0; margin-top:30px;font-weight:500;">
                                    This password reset link will expire in 60 minutes.
                                    If you did not request a password reset, no further action is required.</p>
                                <a target="_blank" href="{{ route('admin.reset.password', $token) }}"
                                    class="button_name"
                                    style=" width:200px; background: #e60000;text-decoration: none !important;font-weight: 600;margin-top: 32px;color:
                                                 #fff;text-transform: capitalize;font-size: 19px;padding: 14px 30px;display: inline-block;border-radius: 5px;">
                                    Reset Link</a> <br>
                                <a href=" {{ route('admin.reset.password', $token) }}" rel="noopener" target="_blank"
                                    style="text-decoration:none;color: #3E97FF">
                                    {{ route('admin.reset.password', $token) }}
                                </a>
                                <p
                                    style="border-bottom: 2px grey solid;padding-bottom: 30px;font-size:20px;line-height: 32px;width: 80%;margin: 30px auto;">
                                    For more information, Contact Us : <br>
                                    <a href="tel{{ $data->phone }}" style="font-size: 18px;text-decoration: none;">{{
                                        $data->phone }}</a>&nbsp;
                                    <span style="font-size: 18px;">OR
                                    </span> &nbsp;<a href="mailto:{{ $data->email }}"
                                        style="font-size: 18px;text-decoration: none;">{{ $data->email }}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:0 35px;">
                                <p style="font-size:20px;line-height: 32px;margin: 0px;text-align: center;">
                                    {{ $data->site_name }}</p>
                                <p
                                    style="font-size:20px;line-height: 32px;margin: 0px;text-align: center; margin-top: 10px;">
                                    <span style="border-right: 1px grey solid;padding-right: 6px;font-size: 18px;">{{
                                        $data->site_url }}</span>
                                    <span style="font-size: 18px;">Copyright © {{ now()->format('Y') }}</span>
                                </p>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </td>


        </tr>

    </tbody>

</body>

</html>