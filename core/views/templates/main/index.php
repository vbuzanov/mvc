<h1 class="bg-primary"><?= $title ?></h1>

<a href="/pdf-articles" class="btn btn-primary">Save articles in PDF</a>
<a href="/excel-articles" class="btn btn-primary">Save articles in Excel</a>

<h2>Lorem, ipsum.</h2>

<?php foreach($articles as $article): ?>
<h2> <a href="/article/<?= $article->id ?>"> <?= $article->name?> </a> </h2>
<a href="/article/<?= $article->id ?>/edit-form"> Редактировать </a>
<form    action="/article/<?= $article->id ?>/delete" method="POST">
    <button>Удалить статью</button>
</form>
<p><?= $article->text?></p>

<?php endforeach ?>    

<a href="/article/add-form" class="btn btn-primary"> Добавить статью </a><br><br>

<a href="/import" class="btn btn-primary"><h3>Добавить или обновить товары</h3></a>
