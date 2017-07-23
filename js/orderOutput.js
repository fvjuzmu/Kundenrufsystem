/**
 * Display a error message on top of the page
 *
 * @param notifications {object}
 */
function errorMessageDisplay( notifications )
{
    errorMessageClear();

    var msg;
    $( '#divErrorMsg' ).show();

    switch( notifications.type.toLowerCase() )
    {
        case "error":
            msg = "<span style='color: red'>";
            break;
        case "erfolg":
            msg = "<span style='color: darkgreen'>";
            break;
    }

    msg += notifications.type + ": " + notifications.message + "</span>";
    $( '#message' ).html( msg );
}

/**
 * Clear the error message and hide the error message display area
 */
function errorMessageClear()
{
    $( '#message' ).html( '' );
    $( '#divErrorMsg' ).hide();
}

/**
 * Takes an array with orders and assigns them to free buttons
 *
 * @param openOrders {object[]}
 */
function ordersDisplay( openOrders )
{
    var date = new Date();

    // loop over every available button and assign order IDs (if available)
    for( var buttonCount = 0; buttonCount < $( '.btnOrder' ).length; buttonCount++ )
    {
        // assign the next button to the variable 'button'
        var button = $( '#button' + buttonCount );

        // if no order should be displayed on this button, then hide the button, remove its value and text and
        // continue to the next button
        if( typeof(openOrders[ buttonCount ]) === "undefined" )
        {
            buttonHide( buttonCount );
            button.val( '' );
            button.html( '' );
            button.removeClass( 'btnOrderRed' );
            button.removeClass( 'overdue' );
            continue;
        }

        // display the button with the specified id (=buttonCount)
        buttonShow( buttonCount );

        // calculate how no customer hast picked up the order
        var begin = new Date( openOrders[ buttonCount ].begin );
        var timer = new Date( date - begin );

        // display the order id and the previously passed time inside a button
        button.html( "<b class='btnOrderIdText'>" + openOrders[ buttonCount ].nr + "</b><br>(" + timer.getMinutes() + ":" + timer.getSeconds() + ")" );
        button.val( openOrders[ buttonCount ].nr );

        // remove the overdue marker class and the colouring class for blinking buttons
        button.removeClass( "btnOrderRed" );
        button.removeClass( "overdue" );

        // if the order wasn't picked up 3 minutes after it was ready, add the overdue marker class and colouring class
        // for blinking buttons
        if( timer.getMinutes() > 3 && !button.hasClass( "overdue" ) )
        {
            button.addClass( "btnOrderRed" );
            button.addClass( "overdue" );
        }
    }
}

/**
 * Loads some orders
 *
 * Calls the getReadyOrders API, receive some orders and display them
 */
function ordersLoad()
{
    $.ajax( "http://" + server + "/krs/api/getReadyOrders.php" ).done( function( returnData )
    {
        if( returnData.hasOwnProperty( "notifications" ) )
        {
            errorMessageDisplay( returnData.notifications[ 0 ] );
            return;
        }

        ordersDisplay( returnData );

    } ).fail( function( returnData )
    {
        errorMessageDisplay( returnData.notifications[ 0 ] );
    } );
}

/**
 * Show the button with the given button ID
 *
 * @param buttonID {int}
 */
function buttonShow( buttonID )
{
    $( '#button' + buttonID ).show();
}

/**
 * Hide the button with the given button ID
 * @param buttonID {int}
 */
function buttonHide( buttonID )
{
    $( '#button' + buttonID ).hide();
}

/**
 * Display a confirmation message, before the order gets removed
 *
 * @param orderId
 */
function confirmationPopupDisplay( orderId )
{
    $( '#confirmMessage' ).html( "Bestellung <h2>" + orderId + "</h2> löschen?" );
    $( "#dialog-confirm" ).dialog( {
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Löschen": function()
            {
                orderRemove( orderId );
                $( this ).dialog( "close" );
            },
            'Abbruch': function()
            {
                $( this ).dialog( "close" );
            }
        }
    } );
}

/**
 * Remove an order from the list (set the database column 'end' to now())
 *
 * @param orderID {int}
 */
function orderRemove( orderID )
{
    // build the data object that will be send by a post api call
    var postData = {
        'orderID': orderID,
        'debug': debug
    };

    // POST api call to a php file that handles the removal of the order
    // this call is asynchronous
    // the server variable is automatic globally declared in serverIPAsJS.php
    $.post( "http://" + server + "/krs/api/removeOrder.php", postData, function( returnData )
    {
        // check if the return data has a notification but no success message. If so display the notification as
        // error and stop
        if( !returnData.hasOwnProperty( "success" ) && returnData.hasOwnProperty( "notifications" ) )
        {
            // if the returned dat contained no success message, display what ever message came back from the api call
            errorMessageDisplay( returnData.notifications[ 0 ] );
            return;
        }

        // load some orders
        ordersLoad();
    } );
}

/**
 * Toggle the colour of every button that represents an overdue order (has the class .overdue)
 */
function btnToggleColor()
{
    $( '.overdue' ).toggleClass( 'btnOrderRed' );
}

// this will run when the document is "ready" (loaded)
$( document ).ready( function()
{
    // if debug is set to true, the api call will return the send data and do nothing else
    debug = false;

    // hide the error message area and the confirm dialog
    $( '#divErrorMsg' ).hide();
    $( "#dialog-confirm" ).hide();

    // bind an onClick event to the the error message button, so error messages can be removed
    $( '#btnErrorMsg' ).on( 'click', function()
    {
        errorMessageClear();
    } );

    // bind an onClick event to all order buttons, on click display the removal confirmation popup
    $( '.btnOrder' ).on( 'click', function()
    {
        confirmationPopupDisplay( $( this ).val() );
    } );

    // load some orders
    ordersLoad();

    // toggles the button colour of overdue orders every second
    setInterval( btnToggleColor, 1000 );

    // refresh the buttons every two seconds
    setInterval( ordersLoad, 2000 );
} );
