<form method="post" action="/wp-admin/admin-post.php">
  
  <!-- Deck name input -->
  <label for="deck_name">Deck name</label>
  <input type="text" name="deck_name" id="deck_name" autocomplete="off" required>

  <!-- Action name hidden field -->
  <input type="hidden" name="action" value="create_aerialogy_deck">
  
  <!-- User ID hidden field -->
  <input type="hidden" name="user_id" value="<?= $user_id ?>">

  <!-- Nonce -->
  <?php wp_nonce_field( 'create_aerialogy_deck', AERIALOGY_NONCE ); ?>

  <!-- Submit button -->
  <button>Create a new deck</button>

</form>