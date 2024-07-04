<main>
  <h3>Avis des clients</h3>

  <div>

    <?php foreach ($allReviews as $reviews) : ?>

      <?php $label = $reviews->status == 1 ? "Désactiver" : "Activer" ?>

      <div><?= $reviews->pseudo ?></div>
      <div><?= $reviews->review ?></div>

      <form method="POST" action="employeeReview/toggleStatus/<?= $reviews->id ?>">
        <button type="submit" name="toggleStatusReviews"><?= $label; ?></button>
      </form>

    <?php endforeach; ?>

  </div>
</main>