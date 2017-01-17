function displayMessage(notifications) {
    var msg;
    switch (notifications.type.toLowerCase()) {
        case "error":
            msg = "<span style='color: red'>";
            break;
        case "erfolg":
            msg = "<span style='color: darkgreen'>";
            break;
    }

    msg += notifications.type + ": " + notifications.message + "</span>";
    $('#message').html(msg);
}

function addToOrderList(orderID) {

    var date = new Date();
    var newOrderListItem = document.createElement("li");
    newOrderListItem.innerHTML = "<b>" + orderID + "</b> - " + +date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
    $('#orderList').prepend(newOrderListItem);

    if ($('#orderList li').length > 10) {
        $('#orderList li').eq(10).remove();
    }

}

function newOrderID(keyPress) {
    if (keyPress.keyCode >= 35 &&
        keyPress.keyCode <= 39 ||
        keyPress.keyCode == 46 ||
        keyPress.keyCode == 8) {
        return;
    }

    if (keyPress.which < 48 || keyPress.which > 57) {
        keyPress.preventDefault();
    }

    if (keyPress.which != 13) {
        return;
    }

    var postData = {
        'orderID': $('#orderID').val(),
        'debug': debug
    };

    $.post("http://127.0.0.1/krs/api/saveNewOrder.php", postData, function (returnData) {

        if (returnData.hasOwnProperty("success")) {

            displayMessage({
                'type': 'Erfolg',
                'message': 'Bestellung ' + $('#orderID').val() + ' gespeichert.'
            });

            addToOrderList($('#orderID').val());

        } else if (returnData.hasOwnProperty("notifications")) {
            displayMessage(returnData.notifications[0]);
        }
    }).fail(function () {

    }).always(function () {

    });
}

$(document).ready(function () {
    debug = false;

    $('#orderID').on('keypress', function (event) {
        newOrderID(event);
    });
});