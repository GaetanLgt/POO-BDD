<h1>Liste des articles</h1>

<?php foreach($annonces as $annonce): ?>
<article>
	<h2><a href="/annonces/lire/<?= $annonce->id ?>"> <?= $annonce->titre ?></a></h2>
	<div><?= $annonce->description ?></div>
</article>
<?php endforeach; ?>