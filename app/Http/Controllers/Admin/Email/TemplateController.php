<?php

namespace App\Http\Controllers\Admin\Email;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleXMLElement;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = Template::all();
        return view('admin.email.templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $templates = Template::all();
        return view('admin.email.templates.create', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'template' => 'required|exists:templates,uid',
        ]);
        $selectedTemplate = Template::where('uid', $request->template)->first();

        if (!$selectedTemplate) {
            return response()->json(['template' => 'Please select a template'], 422);
        }
        $newTemplate = $selectedTemplate->replicate();
        $newTemplate->uid = (string) Str::uuid();
        $newTemplate->name = $request->name;
        $newTemplate->save();
        // return redirect()->route('admin.email.templates.edit', $newTemplate->uid);
        return response()->json(['message' => 'Successfully template deleted', 'template' => $newTemplate], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $template = Template::where('uid', $id)->first();
        if (!$template) {
            abort(404);
        }
        return $template->content;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $template = Template::where('uid', $id)->first();
        if (!$template) {
            abort(404);
        }
        $templates = Template::all();
        $customer = User::find(Auth::id());
        return view('admin.email.templates.edit', compact('template', 'templates', 'customer'));
    }
    public function builderEditContent(Request $request, $uid)
    {
        // Generate info
        $template = Template::where('uid', $uid)->first();

        return view('admin.email.templates.content', [
            'content' => $template->content,
        ]);
    }
    public function uploadTemplateAssets(Request $request, $uid)
    {
        $template = Template::where('uid', $uid)->first();


        if ($request->assetType == 'upload') {
            $assetUrl = $template->uploadAsset($request->file('file'));
        } elseif ($request->assetType == 'url') {
            $assetUrl = $template->uploadAssetFromUrl($request->url);
        } elseif ($request->assetType == 'base64') {
            $assetUrl = $template->uploadAssetFromBase64($request->url_base64);
        }

        return response()->json([
            'url' => $assetUrl
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $template = Template::where('uid', $id)->first();
        $rules = [
            'content' => 'required',
        ];

        $template->name = $request->name;
        $template->content = $request->content;
        $template->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Template updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $template = Template::where('uid', $id)->first();
        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }
        $template->delete();
        return response()->json(['message' => 'Successfully template deleted'], 200);
    }
    public function templatesThumbnail(Request $request, string $uid)
    {
        $request->validate([
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg,svg,webp,gif'
        ]);
        $template = Template::where('uid', $uid)->first();
        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }
        $thumbnail = ImageHelper::store($request->file('thumbnail'), 'thumbnails');
        $template->thumbnail = $thumbnail['filename'];
        $template->save();

        return response()->json([
            'message' => 'Successfully Template deleted',
        ]);
    }
    public function changeName(Request $request, string $uid)
    {
        $template = Template::where('uid', $uid)->first();
        $template->name = $request->name;
        $template->save();

        return response()->json([
            'message' => 'Successfully Template deleted',
        ]);
    }
    public function parseRss(Request $request)
    {
        $config = $request->config;
        $rss = [];

        // Parse RSS content
        $rssArray = $this->xml_to_array(simplexml_load_string($this->url_get_contents_ssl_safe($config['url']), 'SimpleXMLElement', LIBXML_NOCDATA));
        $rssFeed = simplexml_load_string($this->url_get_contents_ssl_safe($config['url']), 'SimpleXMLElement', LIBXML_NOCDATA);

        // Take 10 records only
        $records = array_slice($rssArray['rss']['channel']['item'], 0, $config['size']);

        // feed data
        $feedData = [];
        $feedData['feed_title'] = (string) $rssFeed->channel->title;
        $feedData['feed_description'] = $rssFeed->channel->description->__toString();
        $feedData['feed_link'] = $rssFeed->channel->link->__toString();
        $feedData['feed_pubdate'] = $rssFeed->channel->pubDate->__toString();
        $feedData['feed_build_date'] = $rssFeed->channel->lastBuildDate->__toString();

        // feed parse template
        $rss['FeedTitle'] = $this->parseRssTemplate($config['templates']['FeedTitle']['template'], $feedData);
        $rss['FeedSubtitle'] = $this->parseRssTemplate($config['templates']['FeedSubtitle']['template'], $feedData);
        $rss['FeedTagdLine'] = $this->parseRssTemplate($config['templates']['FeedTagdLine']['template'], $feedData);

        // records
        $rss['items'] = [];
        $count = 0;
        foreach ($rssFeed->channel->item as $item) {
            // item data
            $itemData['item_title'] = $item->title;
            $itemData['item_pubdate'] = $item->pubDate;
            $itemData['item_description'] = $item->description;
            $itemData['item_url'] = $item->link;
            $itemData['item_enclosure_url'] = $item->enclosure['url'];
            $itemData['item_enclosure_type'] = $item->enclosure['type'];

            // item parse template
            $item = [];
            $item['ItemTitle'] = $this->parseRssTemplate($config['templates']['ItemTitle']['template'], $itemData);
            $item['ItemDescription'] = $this->parseRssTemplate($config['templates']['ItemDescription']['template'], $itemData);
            $item['ItemMeta'] = $this->parseRssTemplate($config['templates']['ItemMeta']['template'], $itemData);
            $item['ItemEnclosure'] = $this->parseRssTemplate($config['templates']['ItemEnclosure']['template'], $itemData);
            $item['ItemStats'] = $this->parseRssTemplate($config['templates']['ItemStats']['template'], $itemData);

            // add item to rss items
            $rss['items'][] = $item;

            $count += 1;
            if ($config['size'] == $count) {
                break;
            }
        }


        // Return HTML
        return view('helpers.rss.template', [
            'rss' => $rss,
            'templates' => $config['templates'],
        ]);
    }
    public function xml_to_array(SimpleXMLElement $xml)
    {
        $parser = function (SimpleXMLElement $xml, array $collection = []) use (&$parser) {
            $nodes = $xml->children();
            $attributes = $xml->attributes();

            if (0 !== count($attributes)) {
                foreach ($attributes as $attrName => $attrValue) {
                    $collection['attributes'][$attrName] = html_entity_decode(strval($attrValue));
                }
            }

            if (0 === $nodes->count()) {
                // $collection['value'] = strval($xml);
                // return $collection;
                return html_entity_decode(strval($xml));
            }

            foreach ($nodes as $nodeName => $nodeValue) {
                if (count($nodeValue->xpath('../' . $nodeName)) < 2) {
                    $collection[$nodeName] = $parser($nodeValue);
                    continue;
                }

                $collection[$nodeName][] = $parser($nodeValue);
            }

            return $collection;
        };

        return [
            $xml->getName() => $parser($xml)
        ];
    }
    function url_get_contents_ssl_safe($url)
    {
        // Check if $url is a URL
        if (!preg_match('/^https{0,1}:\/\//', $url)) {
            throw new \Exception('url_get_contents_ssl_safe() requires a URL as input. Received: ' . $url);
        }

        $client = curl_init();
        curl_setopt_array($client, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $result = curl_exec($client);
        curl_close($client);

        return $result;
    }
    public function parseRssTemplate($template, $feedData)
    {
        foreach ($feedData as $key => $value) {
            $template = str_replace('@' . $key, $value, $template);
        }

        if (isset($feedData['item_enclosure_url']) && $feedData['item_enclosure_url'] != '') {
            if (strpos($feedData['item_enclosure_type'], 'video') !== false) {
                $html = '<video controls width="320">
                        <source src="https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4" type="audio/mpeg">
                        Your browser does not support the audio element.
                </video>';
            } elseif (strpos($feedData['item_enclosure_type'], 'video') !== false) {
                $html = '<audio controls>
                        <source src="' . $feedData['item_enclosure_url'] . '" type="audio/mpeg">
                        Your browser does not support the audio element.
                </audio>';
            } else {
                $html = '<img class="my-2" src="' . $feedData['item_enclosure_url'] . '" height="100px" />';
            }
            $template = str_replace('@item_enclosure', $html, $template);
        }

        return $template;
    }
}