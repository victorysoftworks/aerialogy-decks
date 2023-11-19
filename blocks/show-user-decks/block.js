( function ( blocks, React ) {
  var el = React.createElement

  blocks.registerBlockType( 'aerialogy-decks/show-user-decks', {
    edit: function () {
      return el( 'p', { }, "The currently logged-in user's decks will appear here, dummy." )
    }
  } )
} )( window.wp.blocks, window.React )