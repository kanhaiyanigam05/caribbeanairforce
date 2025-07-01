<?php

function join_paths()
{
    $paths = array();
    foreach (func_get_args() as $arg) {
        if (is_null($arg)) {
            continue;
        }

        if (preg_match('/http:\/\//i', $arg)) {
            throw new \Exception('Path contains http://! Use `join_url` instead. Error for ' . implode('/', func_get_args()));
        }

        if ($arg !== '') {
            $paths[] = $arg;
        }
    }

    return preg_replace('#/+#', '/', implode('/', $paths));
}
function getFileType($filename)
{
    $mime_types = array(

        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',

        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $arr = explode('.', $filename);
    $ext = strtolower(array_pop($arr));
    if (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);

        return $mimetype;
    } else {
        return 'application/octet-stream';
    }
}
function tags($site = null, $sender = null, $receiver = null)
{
    return (object) [
        'SITE_NAME' => $site?->site_name,
        'SITE_URL' => $site?->site_url,
        'SITE_LOGO' => asset($site?->logo),
        'SITE_PHONE' => $site?->phone,
        'SITE_EMAIL' => $site?->email,
        // 'SITE_ADDRESS' => $site?->address,
        // 'SITE_FACEBOOK' => $site?->facebook,
        // 'SITE_TWITTER' => $site?->twitter,
        // 'SITE_LINKEDIN' => $site?->linkedin,
        // 'SITE_INSTAGRAM' => $site?->instagram,
        // 'SITE_YOUTUBE' => $site?->youtube,

        'CURRENT_YEAR' => date('Y'),
        'CURRENT_MONTH' => date('F'),
        'CURRENT_DAY' => date('l'),
        'CURRENT_DATE' => date('d'),

        // Sender Info
        'SENDER_NAME' => $sender?->full_name,
        'SENDER_PROFILE_ICON' => $sender?->profile,
        'SENDER_EMAIL' => $sender?->email,
        'SENDER_PHONE' => $sender?->phone,
        // 'SENDER_ADDRESS' => $sender?->address,
        // 'SENDER_FACEBOOK' => $sender?->facebook,
        // 'SENDER_TWITTER' => $sender?->twitter,
        // 'SENDER_LINKEDIN' => $sender?->linkedin,
        // 'SENDER_INSTAGRAM' => $sender?->instagram,
        // 'SENDER_YOUTUBE' => $sender?->youtube,

        // Receiver Info
        'RECEIVER_NAME' => $receiver?->full_name,
        'RECEIVER_EMAIL' => $receiver?->email,
        'RECEIVER_PHONE' => $receiver?->phone,
    ];
}