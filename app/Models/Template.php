<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

use function App\Helpers\helpers;

class Template extends Model
{
    protected $fillable = [
        'uid',
        'name',
        'content',
        'builder'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function tags($list = null)
    {
        $tags = [];

        $tags[] = ['name' => 'SUBSCRIBER_EMAIL', 'required' => false];

        // List field tags
        if (isset($list)) {
            foreach ($list->fields as $field) {
                if ($field->tag != 'EMAIL') {
                    $tags[] = ['name' => 'SUBSCRIBER_' . $field->tag, 'required' => false];
                }
            }
        }

        $tags = array_merge($tags, [
            ['name' => 'UNSUBSCRIBE_URL', 'required' => false],
            ['name' => 'SUBSCRIBER_UID', 'required' => false],
            ['name' => 'WEB_VIEW_URL', 'required' => false],
            ['name' => 'UPDATE_PROFILE_URL', 'required' => false],
            ['name' => 'CAMPAIGN_NAME', 'required' => false],
            ['name' => 'CAMPAIGN_UID', 'required' => false],
            ['name' => 'CAMPAIGN_SUBJECT', 'required' => false],
            ['name' => 'CAMPAIGN_FROM_EMAIL', 'required' => false],
            ['name' => 'CAMPAIGN_FROM_NAME', 'required' => false],
            ['name' => 'CAMPAIGN_REPLY_TO', 'required' => false],
            ['name' => 'CURRENT_YEAR', 'required' => false],
            ['name' => 'CURRENT_MONTH', 'required' => false],
            ['name' => 'CURRENT_DAY', 'required' => false],
            ['name' => 'LIST_NAME', 'required' => false],
            ['name' => 'LIST_FROM_NAME', 'required' => false],
            ['name' => 'LIST_FROM_EMAIL', 'required' => false],
        ]);

        return $tags;
    }
    public static function builderTags($list = null)
    {
        $tags = self::tags($list);

        $result = [];

        if (true) {
            // Unsubscribe link
            $result[] = [
                'type' => 'label',
                'text' => '<a href="{UNSUBSCRIBE_URL}">Click here to unsubscribe</a>',
                'tag' => '{UNSUBSCRIBE_LINK}',
                'required' => true,
            ];

            // web view link
            $result[] = [
                'type' => 'label',
                'text' => '<a href="{WEB_VIEW_URL}">Click to view web version of this email</a>',
                'tag' => '{WEB_VIEW_LINK}',
                'required' => true,
            ];
        }

        foreach ($tags as $tag) {
            $result[] = [
                'type' => 'label',
                'text' => '{' . $tag['name'] . '}',
                'tag' => '{' . $tag['name'] . '}',
                'required' => true,
            ];
        }

        return $result;
    }
    public function uploadAssetFromBase64($base64)
    {
        // upload file by upload image
        $filename = uniqid();

        // Storage path of the uploaded asset:
        // For example: /storage/templates/{type}/{ID}/604ce5e36d0fa
        $filepath = $this->getStoragePath($filename);

        // Store it
        file_put_contents($filepath, file_get_contents($base64));
        $assetUrl = $this->generatePublicPath($filepath);

        return $assetUrl;
    }

    public function uploadAssetFromUrl($url)
    {
        return $url;

        /* Another way is to fetch and save the image to the local directory of the template */
    }

    /**
     * Upload asset.
     */
    public function uploadAsset($file)
    {
        // Store to template storage storage/app/customers/000000/templates/111111/ASSET.JPG
        $name = preg_replace('/[^a-zA-Z0-9\.\-]+/', '_', trim($file->getClientOriginalName()));
        $name = $this->generateUniqueName($this->getStoragePath(), $name);

        // Move uploaded file
        $file->move($this->getStoragePath(), $name);
        $assetUrl = $this->generatePublicPath($this->getStoragePath($name));

        return $assetUrl;
    }
    public function generateUniqueName($directory, $name)
    {
        $count = 1;
        $path = join_paths($directory, $name);
        $newName = $name;
        while (file_exists($path)) {
            $regxp = '/(?<ext>\.[^\/\.]+$)/';
            preg_match($regxp, $name, $matched);

            if (array_key_exists('ext', $matched)) {
                $fileExt = $matched['ext'];
            } else {
                $fileExt = '';
            }

            $base = preg_replace($regxp, '', $name);
            $newName = $base . '_' . $count . $fileExt;
            $path = join_paths($directory, $newName);
            $count += 1;
        }

        return $newName;
    }
    function generatePublicPath($absPath, $withHost = false)
    {
        // Notice: $relativePath must be relative to storage/ folder
        // For example, with a real path of /home/deploy/acellemail/storage/app/sub/example.png
        // then $relativePath should be "app/sub/example.png"

        if (empty(trim($absPath))) {
            throw new Exception('Empty path');
        }

        $excludeBase = storage_path();
        $pos = strpos($absPath, $excludeBase); // Expect pos to be exactly 0

        if ($pos === false) {
            throw new Exception(sprintf("File '%s' cannot be made public, only files under storage/ folder can", $absPath));
        }

        if ($pos != 0) {
            throw new Exception(sprintf("Invalid path '%s', cannot make it public", $absPath));
        }

        // Do not use string replace, as path parts may occur more than once
        // For example: abc/xyz/abc/xyz...
        $relativePath = substr($absPath, strlen($excludeBase) + 1);

        if ($relativePath === false) {
            throw new Exception("Invalid path {$absPath}");
        }

        $dirname = dirname($relativePath);
        $basename = basename($relativePath);
        $encodedDirname = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($dirname));

        // If Laravel is under a subdirectory
        $subdirectory = $this->getAppSubdirectory();

        if (empty($subdirectory) || $withHost) {
            // Return something like
            //     "http://localhost/{subdirectory if any}/p/assets/ef99238abc92f43e038efb"   # withHost = true, OR
            //     "/p/assets/ef99238abc92f43e038efb"                   # withHost = false
            $url = route('admin.email.public_assets', ['dirname' => $encodedDirname, 'basename' => rawurlencode($basename)], $withHost);
        } else {
            // Make sure the $subdirectory has a leading slash ('/')
            $subdirectory = join_paths('/', $subdirectory);
            $url = join_paths($subdirectory, route('admin.email.public_assets', ['dirname' => $encodedDirname, 'basename' => $basename], $withHost));
        }

        return $url;
    }
    public function getAppSubdirectory()
    {
        // IMPORTANT: do not use url('/') as it will not work correctly
        // when calling from another file (like filemanager/config/config.php for example)
        // Otherwise, it will always return 'http://localhost' --> without subdirectory
        $path = parse_url(config('app.url'), PHP_URL_PATH);

        if (is_null($path)) {
            return null;
        }

        $path = trim($path, '/');
        return empty($path) ? null : $path;
    }
    public function urlTagsDropdown()
    {
        return [
            ['value' => '{UNSUBSCRIBE_URL}', 'text' => 'Click here to unsubscribe'],
            ['value' => '{UPDATE_PROFILE_URL}', 'text' => 'Update your profile'],
            ['value' => '{WEB_VIEW_URL}', 'text' => 'Click to view web version of this email'],
        ];
    }
    public static function defaultRssConfig()
    {
        return [
            'url' => '',
            'size' => 10,
            'templates' => [
                'FeedTitle' => [
                    'title' => 'Feed title',
                    'show' => true,
                    'template' => '@feed_title',
                ],
                'FeedSubtitle' => [
                    'title' => 'Feed subtitle',
                    'show' => true,
                    'template' => 'Updated at: @feed_build_date',
                ],
                'FeedTagdLine' => [
                    'title' => 'Tagline',
                    'show' => true,
                    'template' => 'TOP STORIES FOR YOU',
                ],
                'ItemTitle' => [
                    'title' => 'Item title',
                    'show' => true,
                    'template' => 'Title: @item_title',
                ],
                'ItemMeta' => [
                    'title' => 'Meta line',
                    'show' => true,
                    'template' => '<img src="' . asset('images/avatar1.svg') . '" width="30px" style="margin-right:5px" /> something here - @item_pubdate',
                ],
                'ItemDescription' => [
                    'title' => 'Item description',
                    'show' => true,
                    'template' => '@item_description <a href="@item_url">Read more</a>',
                ],
                'ItemStats' => [
                    'title' => 'Statistics',
                    'show' => true,
                    'template' => '<img src="' . url('images/icon-up.svg') . '" width="16px" style="margin-right:5px" /> 400k updates, &nbsp; &nbsp;
                        <img src="' . url('images/icon-comment.svg') . '" width="16px" style="margin-right:5px" /> 1.2k comments',
                ],
                'ItemEnclosure' => [
                    'title' => 'Enclosure (Image|Audio|Video)',
                    'show' => false,
                    'template' => '@item_enclosure',
                ],
            ],
        ];
    }
    public function getStoragePath($path = '/')
    {
        if ($this->customer) {
            // storage/app/users/{uid}/templates
            $base = $this->customer->getTemplatesPath($this->uid);
        } else {
            // storage/app/templates/templates
            // IMPORTANT: templates are created from migration without associating with an admin
            $base = $this->getSystemStoragePath($this->uid);
        }

        if (!File::exists($base)) {
            File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }
    private function getSystemStoragePath($path = null)
    {
        $base = storage_path('app/templates/');

        if (!File::exists($base)) {
            File::makeDirectory($base, 0777, true, true);
        }

        return join_paths($base, $path);
    }
    public function uploadThumbnail($file)
    {
        $file->move($this->getStoragePath(), 'thumbnail.png');
    }
}