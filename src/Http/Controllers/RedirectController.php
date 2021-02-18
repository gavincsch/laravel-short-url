<?php

namespace Glowtech\ShortUrl\Http\Controllers;

use Glowtech\ShortUrl\Url;
use Illuminate\Routing\Controller;

class RedirectController extends Controller
{
    /**
     * Redirect to url by its code.
     *
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect($code)
    {
        $url = \Cache::rememberForever("url.$code", function () use ($code) {
            return Url::whereCode($code)->first();
        });

        if ($url === null) {
            abort(404);
        }
        if ($url->hasExpired()) {
            if(config('shorturl.enable_custom_expired_handle') === true) {
                $link = "/".config('shorturl.url_prefix') . config('shorturl.expired_redirect') ."/$code";
                return redirect()->away($link, 301);
            } else {
                abort(410);
            }
        }

        $url->increment('counter');

        return redirect()->away($url->url, $url->couldExpire() ? 302 : 301);
    }

    /**
     * Redirect to expired url with code.
     * @param $code
     *
     * @return \Illuminate\Http\Response
     */
    public function expired($code)
    {
        $url = \Cache::rememberForever("url.$code", function () use ($code) {
            return Url::whereCode($code)->first();
        });

        if ($url === null) {
            abort(404);
        }

        return view('shorturl::urls.expired', compact('url'));
    }
}