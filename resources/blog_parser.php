<?php

$blogs = json_decode(file_get_contents(dirname(__FILE__) . '/blog_full.json'));
$blog_content_folder = dirname(__FILE__) . '/../blog/';
$blog_index_path = dirname(__FILE__) . '/../blog-index.json';

$blog_index = array();
foreach ($blogs as $blog) {
    file_put_contents($blog_content_folder . $blog->url . '.html', $blog->content);
    unset($blog->content);
    $blog_index[$blog->url] = $blog;
}

file_put_contents($blog_index_path, json_encode($blog_index));