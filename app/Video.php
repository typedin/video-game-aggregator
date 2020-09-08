<?php

namespace App;

/**
 * Class Video
 * @author yourname
 */
class Video
{
    public $url;
    
    public function __construct($url)
    {
        $this->url = $url;
    }


    public static function youtube($id)
    {
        return new Video("https://youtube.com/watch/{$id}");
    }
}
