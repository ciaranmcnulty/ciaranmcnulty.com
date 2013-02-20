<?php

$blogs = array_slice($blogs, -5);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Ciaran McNulty</title>
    <?php include $includesFolder . 'head-boilerplate.php' ?>
</head>

<body>
    
<header>
    <h1>Ciaran McNulty</h1>
</header>

<section id="intro">
    <h2>Who I am</h2>
    <ul>
        <li>I am a web developer / project manager / scrum master who lives in South West London</li>
        <li>There's more to me than that but I don't like putting it all online! You can find out more if you get to know me</li>
    </ul>
</section>

<section id="bio">
    <h2>My history</h2>
    <ul>
        <li>I come from <a href="http://en.wikipedia.org/wiki/Stourbridge">Stourbridge</a> in the West Midlands</li>
        <li>I was educated at <a href="http://www.our-lady.dudley.sch.uk">Our Lady and St Kenelm's School</a>, <a href="http://www.hagleyrc.com">Hagley RC High School</a> and <a href="http://www.chu.cam.ac.uk">Churchill College, Cambridge</a></li>
        <li>I have worked at <a href="http://www.themlondon.com">Them</a>, <a href="http://www.propertymall.com">PropertyMall</a> and <a href="http://www.beam.tv">Beam</a></li>
    </ul>
</section>

<section id="profiles">
    <h2>What I do online</h2>
    <ul>
        <li>I micro-blog on <a href="http://twitter.com/CiaranMcNulty" rel="me">Twitter</a></li>
        <li>I keep my photos in <a href="http://www.flickr.com/photos/ciaranmcnulty/" rel="me">Flickr</a></li>
        <li>You can see the music I listen to at <a href="http://www.last.fm/user/CiaranMcNulty/" rel="me">Last.fm</a></li>
        <li>There is some of my code on <a href="https://github.com/ciaranmcnulty" rel="me">Github</a></li>
        <li>My friends keep in touch with me on <a href="http://www.facebook.com/people/Ciaran_McNulty/600005468" rel="me">Facebook</a></li>
        <li>I play a lot of games on <a href="http://live.xbox.com/member/CMCNULTY" rel="me">Xbox Live</a></li>
        <li>I used to blog about my twentysomething life on <a href="http://ciaranmcnulty.livejournal.com/profile" rel="me">LiveJournal</a> but haven't for years</li>
        <li>I used to blog about crosswords on <a href="http://fifteensquared.net/author/mcnulty" rel="me">Fifteensquared</a> but I just don't find the time any more</li>
        <li>I have an account on <a href="http://uk.youtube.com/user/ciaranmcnulty" rel="me">YouTube</a> but just use it to 'favourite' things</li>
        <li>Work contacts may be interested in seeing my profile on <a href="http://www.linkedin.com/in/ciaranmcnulty" rel="me">LinkedIn</a></li>
        <li>Sometimes I sell things, but mostly I buy on <a href="http://myworld.ebay.co.uk/ciaranmcnulty" rel="me">Ebay</a></li>
        <li>From time to time I help people with tech issues on <a href="http://stackoverflow.com/users/34024/ciaran-mcnulty" rel="me">Stack Overflow</a></li>
    </ul>
</section>

<section id="blog">
    <h2>What I think</h2>
    <p>I've written a few blog posts over the years, sadly not so many recently. Here are the most recent five.</p>
    <ul>
        <?php foreach ($blogs as $blog): ?>
        <li><a href="/<?=htmlspecialchars($blog->url)?>"><?= htmlspecialchars($blog->title) ?></a></li>
        <?php endforeach; ?>
    </ul>
</section>

</body>

</html>