<?php

/**
 * Contains markup for the "show user decks" block.
 *
 * @link       https://github.com/victorysoftworks/aerialogy-decks
 * @since      1.0.0
 *
 * @package    Aerialogy_Decks
 * @subpackage Aerialogy_Decks/public/partials
 */
?>

<?php if (count($decks) > 0): ?>

  <?php foreach ($decks as $deck): ?>

    <h3><?= $deck['deck_name'] ?></h3>
    
    <?php if (count($deck['cards']) > 0): ?>

      <ul>
      <?php foreach ($deck['cards'] as $card): ?>
        
        <?php $post = get_post($card['card_post_id']); ?>
        <li><?= $post->post_title ?></li>

      <?php endforeach; ?>
      </ul>

    <?php else: ?>
      <p>You have not yet added any cards to this deck.</p>
    <?php endif; ?>

  <?php endforeach; ?>

<?php else: ?>

  <div>
    <p>You have not created any decks.</p>
  </div>

<?php endif; ?>