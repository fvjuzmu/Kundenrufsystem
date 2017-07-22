function displayOrders(openOrders) {
    var date = new Date();

    for (var order = 0; order < 10; order++) {

        var begin = new Date(openOrders[order].begin);
        var timer = new Date(date - begin);

        addToOrderList(openOrders[order].nr, timer, begin);

    }
}

function addToOrderList(orderID, timer, begin) {

    var newOrderListItem = document.createElement("div");
    newOrderListItem.innerHTML = orderID;
    var minute = timer.getMinutes();

    if (minute > 3)
    {
        newOrderListItem.className += " krsLabelRed"
    }
    if (minute > 3 && !$(newOrderListItem).hasClass("overdue")) {
        $(newOrderListItem).addClass("krsLabelRed");
        $(newOrderListItem).addClass("overdue");
    } else if (minute <= 3 && $(newOrderListItem).hasClass("overdue")) {
        $(newOrderListItem).removeClass("krsLabelRed");
        $(newOrderListItem).removeClass("overdue");
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

function blink(selector) {
    selector.fadeOut('slow', function () {
        $(this).fadeIn('slow', function () {
            blink(this);
        });
    });
}

function classToggle() {
    $('.overdue').toggleClass('krsLabelRed');
}


$(document).ready(function () {
    debug = false;

    loadOrders();
    setInterval(classToggle, 1000);
    setInterval(loadOrders, 2000);

});