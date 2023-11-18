<form method="post" action="/wp-admin/admin-post.php">
  <input type="hidden" name="user_id" value="<?= $user_id ?>">
  <input type="hidden" name="deck_id" value="<?= $deck['id'] ?>">
  <input type="hidden" name="action" value="delete_aerialogy_deck">
  <?php wp_nonce_field( 'delete_aerialogy_deck', AERIALOGY_NONCE ); ?>

  <button>Delete deck <span class="sr-only">"<?= $deck['deck_name'] ?>"</span></button>
</form>