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
    newOrderListItem
    if (minutes > 3)
    {
        newOrderListItem.className += " krsLabelRed"

    }
    $('#orderListScreen').append(newOrderListItem);

}

function loadOrders() {
    $('#orderListScreen').empty();
    $.ajax("http://" + server + "/krs/api/getReadyOrders.php")
        .done(function (returnData) {
            displayOrders(returnData);

        }).fail(function (returnData) {
    }).always(function () {

    });
}

$(document).ready(function () {
    debug = false;

    $('.krsButton').on('click', function () {
        removeOrder($(this).val());
    })
    loadOrders();
    setInterval(loadOrders, 4000);

});
