/**
 * Loop over the received orders from the api call and display each of them
 *
 * @param openOrders {object[]}
 */
function displayOrders( openOrders )
{
    var date = new Date();

    for( var order = 0; order < 10; order++ )
    {
        var begin = new Date( openOrders[ order ].begin );
        var timer = new Date( date - begin );

        addToOrderList( openOrders[ order ].nr, timer );
    }
}

/**
 * Add an order to the order list
 *
 * @param orderID {int}
 * @param timer {Date}
 */
function addToOrderList( orderID, timer )
{
    var newOrderListItem = document.createElement( "div" );
    newOrderListItem.innerHTML = orderID;
    var minute = timer.getMinutes();

    $( newOrderListItem ).removeClass( "krsLabelRed" );
    $( newOrderListItem ).removeClass( "overdue" );

    if( minute > 3 && !$( newOrderListItem ).hasClass( "overdue" ) )
    {
        $( newOrderListItem ).addClass( "krsLabelRed" );
        $( newOrderListItem ).addClass( "overdue" );
    }

    $( '#orderListScreen' ).append( newOrderListItem );
}

/**
 * Call the getReadyorders API and display the received orders that are ready for pick up
 */
function loadOrders()
{
    $.ajax( "http://" + server + "/krs/api/getReadyOrders.php" ).done( function( returnData )
    {
        $( '#orderListScreen' ).empty();
        displayOrders( returnData );
    } );
}

/**
 * Toggle the colour of every lable that represents an overdue order (has the class .overdue)
 */
function lableToggleColour()
{
    $( '.overdue' ).toggleClass( 'krsLabelRed' );
}


$( document ).ready( function()
{
    debug = false;

    loadOrders();
    setInterval( lableToggleColour, 1000 );
    setInterval( loadOrders, 2000 );
} );