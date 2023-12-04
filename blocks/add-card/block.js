( function ( blocks, React ) {
  var el = React.createElement

  blocks.registerBlockType( 'aerialogy-decks/add-card', {
    edit: function () {
      return el( 'p', { }, "A button to add this card to a deck will appear here." )
    }
  } )
} )( window.wp.blocks, window.React )