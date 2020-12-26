<h1><?= $article->name ?></h1>
<div>Автор: <?= $article->getAuthor()->name ?> </div>
<div><?= $article->text ?></div>