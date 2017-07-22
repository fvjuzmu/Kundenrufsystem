function displayMessage( notifications )
{
    var msg;
    switch ( notifications.type.toLowerCase() )
    {
        case "error":
            msg = "<span style='color: red'>";
            break;
        case "erfolg":
            msg = "<span style='color: darkgreen'>";
            break;
    }
    msg += notifications.type.toUpperCase() + ": " + notifications.message + "</span>";
    $( '#message' ).html( msg );
}

function addToOrderList( orderID )
{

    var date = new Date();
    var newOrderListItem = document.createElement( "li" );
    var removed = '';
    if ( orderID < 0 )
    {
        removed = 'GELÖSCHT ';
        orderID = orderID * -1;
    }
    newOrderListItem.innerHTML = "<b>" + removed + orderID + "</b> - " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    $( '#orderList' ).prepend( newOrderListItem );

    if ( $( '#orderList li' ).length > 10 )
    {
        $( '#orderList li' ).eq( 10 ).remove();
    }

}

function newOrderID( keyPress )
{
    if ( keyPress.keyCode >= 35 &&
        keyPress.keyCode <= 39 ||
        keyPress.keyCode == 46 ||
        keyPress.keyCode == 8 )
    {
        return;
    }

    if ( (keyPress.which < 48 || keyPress.which > 57) && keyPress.which != 45 )
    {
        keyPress.preventDefault();
    }

    if ( keyPress.which != 13 )
    {
        return;
    }

    if ( $( '#orderID' ).val().length == 0 )
    {
        return;
    }

    if ( $( '#orderID' ).val() > 9999 )
    {
        displayMessage( {
            'type': 'error',
            'message': 'Bestellnummer ' + $( '#orderID' ).val() + ' zu lang (max. 9999)' + '.'
        } );
        return;
    }

    var postData = {
        'orderID': $( '#orderID' ).val(),
        'debug': debug
    };

    $.post( "http://" + server + "/krs/api/saveNewOrder.php", postData, function ( returnData )
    {

        if ( returnData.hasOwnProperty( "success" ) )
        {

            var actionTXT = ' gespeichert';
            var orderID = $( '#orderID' ).val();
            if ( orderID < 0 )
            {
                actionTXT = ' GELÖSCHT ';
                orderID = orderID * -1;
            }

            displayMessage( {
                'type': 'Erfolg',
                'message': 'Bestellung ' + orderID + actionTXT + '.'
            } );

            addToOrderList( $( '#orderID' ).val() );
            $( '#orderID' ).val( "" );

        }
        else if ( returnData.hasOwnProperty( "notifications" ) )
        {
            displayMessage( returnData.notifications[ 0 ] );
        }
    } ).fail( function ()
    {

    } ).always( function ()
    {

    } );
}

$( document ).ready( function ()
{
    debug = false;

    $( '#orderID' ).on( 'keypress', function ( event )
    {
        newOrderID( event );
    } );
} );
