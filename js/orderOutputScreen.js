function displayOrders(openOrders) {
    var date = new Date();

    for (var order = 0; order < openOrders.length; order++) {

        var begin = new Date(openOrders[order].begin);
        var timer = new Date(date - begin);

        addToOrderList(openOrders[order].nr, timer.getMinutes());

    }
}

function addToOrderList(orderID, minutes) {

    var newOrderListItem = document.createElement("li");
    newOrderListItem.innerHTML = orderID;

    if (minutes > 3)
    {
        newOrderListItem.className += " krsLabelRed"

    }
    $('#orderListScreen').append(newOrderListItem);

}

function loadOrders() {

    $.ajax("http://" + server + "/krs/api/getReadyOrders.php")
        .done(function (returnData) {
            $('#orderListScreen').empty();
            displayOrders(returnData);

        }).fail(function (returnData) {
    }).always(function () {

    });
}

$(document).ready(function () {
    debug = false;

    loadOrders();
    setInterval(loadOrders, 1000);

});
