/**
 * Display some message to the user on top of the page
 *
 * @param notifications {object} Notification object like this one: { type: 'error, message: 'some error message' }
 */
function displayMessage( notifications )
{
    var msg = '';

    // decide by the notification type in which color the message should be displayed
    switch( notifications.type.toLowerCase() )
    {
        case "error":
            msg = "<span style='color: red'>";
            break;

        case "erfolg":
            msg = "<span style='color: darkgreen'>";
            break;

        default:
            msg = "<span style='color: black'>";
    }

    // build and display the message
    msg += notifications.type.toUpperCase() + ": " + notifications.message + "</span>";
    $( '#message' ).html( msg );
}

/**
 * Add an order ID to the oder list protocol
 *
 * @param orderID {int} An order ID
 */
function addToOrderList( orderID )
{
    var removed = '';

    // if the order ID was a negative value, the order was remove and not added to the list. So we will add the
    // 'GELÖSCHT' prefix to the list entry
    if( orderID < 0 )
    {
        removed = 'GELÖSCHT ';
        orderID = orderID * -1;
    }

    // get the actual date and time so we can display it in the list beside the order ID
    var date = new Date();

    // build up a new list element that we can append inside the <ul> html tag
    var newOrderListItem = document.createElement( "li" );
    newOrderListItem.innerHTML = "<b>" + removed + orderID + "</b> - " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();

    // append the new list elemtn to the order list <ul> html tag
    var orderList = $( '#orderList' );
    orderList.prepend( newOrderListItem );

    // if the list has more than 20 elements, then remove the oldest one
    var orderListElements = orderList.find( 'li' );
    if( orderListElements.length > 20 )
    {
        orderListElements.eq( 20 ).remove();
    }
}

/**
 * Checks if the last pressed was a number, minus or enter. Adds the order ID to the order List and diplays some
 * Messages
 *
 * If the pressed key was none of the above mentioned keys it will prevent the default action and not display the character in the
 * input field.
 * If the pressed key was a number key or the minus key, it will display it in the input field.
 * If the pressed key was a enter key, then the data in the input field will be send to the api.
 *
 *
 * @param keyPress {Event} Event of the pressed key on the keyboard
 */
function newOrderID( keyPress )
{
    // select the orderID field with the help of jQuery
    var orderID = $( '#orderID' ).val();

    // allow the key backspace (8), delete (46), end (35), home (36), left arrow (37), up arrow (38) and right arrow (39)
    // to be pressed, do there default action and then return to do nothing
    if( keyPress.keyCode >= 35 &&
        keyPress.keyCode <= 39 ||
        keyPress.keyCode === 46 ||
        keyPress.keyCode === 8 )
    {
        return;
    }

    // if the pressed key is no no a number, prevent the default action so the pressed key will not displayed in the
    // input field
    if( (keyPress.which < 48 || keyPress.which > 57) && keyPress.which !== 45 )
    {
        keyPress.preventDefault();
    }

    // if the pressed key is not the enter key, display the pressed number and then do nothing else
    if( keyPress.which !== 13 )
    {
        return;
    }

    // do nothing when the order id is to short, it has to be at least one digit long
    if( orderID.length === 0 )
    {
        return;
    }

    // in your case the orderID can not be greater then 9999, so we throw an error if something bigger was entered
    if( orderID > 9999 )
    {
        displayMessage( {
            'type': 'error',
            'message': 'Bestellnummer ' + orderID + ' zu lang (max. 9999)' + '.'
        } );
        return;
    }

    // build the data object that will be send by a post api call
    var postData = {
        'orderID': orderID,
        'debug': debug
    };

    // POST api call to a php file that handles the newly entered orderID
    // this call is asynchronous
    // the server variable is automatic globally declared in serverIPAsJS.php
    $.post( "http://" + server + "/krs/api/saveNewOrder.php", postData, function( returnData )
    {
        // this is the callback function of the api, it gets called if no http error occured and a well formed
        // return data was received

        // check if the return data has a notification but no success message. If so display the notification as
        // error and stop
        if( !returnData.hasOwnProperty( "success" ) && returnData.hasOwnProperty( "notifications" ) )
        {
            // if the returned dat contained no success message, display what ever message came back from the api call
            displayMessage( returnData.notifications[ 0 ] );
            return
        }

        // if so, build a success message we can display to the user
        var actionTXT = ' gespeichert';
        var orderIDField = $( '#orderID' );
        var orderID = orderIDField.val();


        var dispMsg = 'Bestellung ' + orderID + ' gespeichert.';
        // but build a diverent message if the order ID was negative, this means the order was not added but removed
        if( orderID < 0 )
        {
            dispMsg = 'Bestellung ' + orderID * -1 + ' GELÖSCHT.';
        }

        // display the previously build message to the user
        displayMessage( {
            'type': 'Erfolg',
            'message': dispMsg
        } );

        // add the order ID to the displayed protocol list
        addToOrderList( orderID );
        // clear the orderID input field
        orderIDField.val( "" );
    } );
}

// this will run when the document is "ready" (loaded)
$( document ).ready( function()
{
    // if debug is set to true, the api call will return the send data and do nothing else
    debug = false;

    // register the onKeyPress event to the input field with the id 'orderID'
    // on every key press, in the input field, newOrderID is called
    $( '#orderID' ).on( 'keypress', function( event )
    {
        newOrderID( event );
    } );
} );