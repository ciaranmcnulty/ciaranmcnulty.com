<!DOCTYPE html>
<html>

<head>
    <title>Ciaran McNulty</title>
    <?php include $includesFolder . 'head-boilerplate.php' ?>
</head>

<body>

<?php include $includesFolder . 'header-boilerplate.php' ?>
    
<section id="blog">
    <h2><?= htmlspecialchars($blog->title) ?></h2>
    <h3><time><?= date('c', strtotime($blog->created)) ?></time></h3>
    <?php require_once $blogFolder . $blog->url . '.html' ?>
</section>

<?php if ($blog->comments): ?>
<section id="comments">
    
    <h2>Comments</h2>
    
<?php foreach ($blog->comments as $comment): ?>
    <h3><a href="<?=htmlspecialchars($comment->website) ?>"><?=htmlspecialchars($comment->name) ?></a> <time><?= date('c', strtotime($comment->created)) ?></time></h3>
    <p><?=htmlspecialchars($comment->comment) ?></p>
<?php endforeach; ?>
    
</section>
<?php endif; ?>

</body>

</html>