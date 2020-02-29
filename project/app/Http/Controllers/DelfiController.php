<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

class DelfiController extends Controller
{
    /**
     * Index page view
     * Fetch and output RSS feed data with paginator
     * Selected channels and paginated pages are set depending on default values defined in app services config
     * Or authenticated user settings
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Set default channel and paginate defined in app services.php
        $default_channel = auth()->check() ? auth()->user()->default_channel : config('services.delfi.default_channel');
        $default_paginate = auth()->check() ? auth()->user()->default_paginate : config('services.delfi.default_paginate');

        // Set selected channel and paginate per page.
        $selected_channel = request()->exists('channel') ? request()->get('channel') : $default_channel;
        $selected_paginate = request()->exists('paginate') ? (int)request()->get('paginate') : $default_paginate;

        // Check if selected channel exists. Otherwise use default channel.
        if(!in_array($selected_channel, array_flip(config('services.delfi.channels'))))
            $selected_channel = $default_channel;

        // Get xml data from RSS feed URL defined in app services.php and appended with selected channel.
        $url = config('services.delfi.rss').$selected_channel;
        $rss = false;

        // Check if xml was loaded. Return custom 404 page in case of error. Invalid url, xml or empty content.
        try {
            $rss = simplexml_load_file($url, null, LIBXML_NOERROR);

            if(!$rss)
                throw new \Exception;

        } catch (\Exception $e){
            abort(404, 'Delfi.lv ziņu barotne šobrīd nav pieejama, ienāc vēlāk.');
        }

        // Register namespaces to in order to read slash:comments and media:content
        $rss->registerXPathNamespace('c', 'http://purl.org/rss/1.0/modules/slash/');
        $rss->registerXPathNamespace('m', 'http://search.yahoo.com/mrss/');

        // Initialize collection for articles
        $articles = collect();

        /*
         * Loop through each item, create new object with item data and push object into articles collection
         * Use $i counter because keys are not available in xml item objects
         */
        $i = 0;
        foreach($rss->channel->item as $item){
            $article = new \stdClass();
            $article->title = (string)$item->title;
            $article->link = (string)$item->link;
            $article->description = (string)$item->description;
            $article->pubDate = Carbon::parse($item->pubDate)->format('d.m.Y H:i');

            // set comments and image from namespaces, and just in case check if they are actually set
            $article->comments = (int)($rss->xpath('//c:comments')[$i]) ?? false;
            $article->image = (string)($rss->xpath('//m:content')[$i]->attributes()->url) ?? false;

            $articles->push($article);
            $i++;
        }

        // Paginate article collection. Uses "paginate" macro defined in AppServiceProvider.php
        $articles = $articles->paginate($selected_paginate);

        // Get generated paginator HTML with appended input variables (channel, paginate, page)
        $paginator = $articles->appends(request()->input())->links();

        // Return index view with article data
        return view('index', [
            'title'             => (string)$rss->channel->title,
            'description'       => (string)$rss->channel->description,
            'link'              => (string)$rss->channel->link,
            'image'             => (string)$rss->channel->image->url,
            'articles'          => $articles,
            'selected_channel'  => $selected_channel,
            'selected_paginate' => $selected_paginate,
            'paginator'         => $paginator,
        ]);
    }

}
