<h2>Dashboard Admin</h2>

<div>
  <?php if (!empty($animalsWithClicks)): ?>
    <h3>Liste des animaux</h3>
    <?php foreach ($animalsWithClicks as $animal): ?>
      <div>
       <?= htmlspecialchars($animal['breed']); ?> -
        Clicks : <?= htmlspecialchars($animal['click_count']); ?>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>Aucun animal trouvé.</p>
  <?php endif; ?>
</div>