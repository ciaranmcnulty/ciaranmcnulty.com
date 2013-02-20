<?php

/**
* Very simple router
*/
date_default_timezone_set('Europe/London');

$uri = $_SERVER['REQUEST_URI'];
$pagesFolder = dirname(__FILE__) . '/../pages/';
$includesFolder = dirname(__FILE__) . '/../includes/';
$blogFolder = dirname(__FILE__) . '/../blog/';
$blogIndex = dirname(__FILE__) . '/../blog-index.json';

$blogs = (array)json_decode(file_get_contents($blogIndex));

// front page
if ('/' == $uri) {
    require_once($pagesFolder . 'front.php');
}

// old blog URLs
else if ( 0 === strpos($uri, '/blog') ) {
    
    // actual blog post that we want to redirect
    if (preg_match('#/blog/[0-9]+/[0-9]+/(?P<blog>.+)#', $uri, $matches)) {
        header('HTTP/1.0 302 Moved');
        header('Location: /' . $matches['blog']);
        exit;
    }
    
    // some other blog URL that's deprecated
    else {
        header('HTTP/1.0 410 Gone');
        require_once($pagesFolder . 'gone.php');
    }
}

// it's either a blog post or a generic unknown URL
else {
    
    $blogKey = preg_replace('#^/#', '', $uri);
    
    if (array_key_exists($blogKey, $blogs)) {
        $blog = $blogs[$blogKey];
        require_once($pagesFolder . 'blog.php');
    }
    
    else {
    
        header('HTTP/1.0 404 Not Found');
        require_once($pagesFolder . 'not-found.php');
        
    }
}