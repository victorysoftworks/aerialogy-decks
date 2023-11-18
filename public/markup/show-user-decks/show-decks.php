<?php foreach ($decks as $deck): ?>

  <h3><?= $deck['deck_name'] ?></h3>

  <?php include plugin_dir_path( dirname( __FILE__ ) ) . '/show-user-decks/delete-deck-form.php'; ?>

  <?php if (count($deck['cards']) > 0): ?>

    <ul>
      <?php foreach ($deck['cards'] as $card): ?>
        
        <?php $post = get_post($card['card_post_id']); ?>
        <li><?= $post->post_title ?></li>

      <?php endforeach; ?>
    </ul>

  <?php else: ?>
    <p>You have not yet added any cards to this deck. <a href="#">Find cards to add</a></p>
  <?php endif; ?>

<?php endforeach; ?>