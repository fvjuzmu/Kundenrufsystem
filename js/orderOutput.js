function displayMessage(notifications) {

    var msg;

    if (notifications != '') {
        $('#divErrorMsg').show();


        switch (notifications.type.toLowerCase()) {
            case "error":
                msg = "<span style='color: red'>";
                break;
            case "erfolg":
                msg = "<span style='color: darkgreen'>";
                break;
        }

        msg += notifications.type + ": " + notifications.message + "</span>";
    } else {
        $('#divErrorMsg').hide();
        msg = '';
    }

    $('#message').html(msg);
}

function displayOrders(openOrders) {
    var date = new Date();

    for (var buttonCount = 0; buttonCount < $('.krsButton').length; buttonCount++) {
        if (typeof(openOrders[buttonCount]) === "undefined") {
            hideButton(buttonCount);
            $('#button' + buttonCount).val('');
            $('#button' + buttonCount).html('');
            $('#button' + buttonCount).removeClass('krsButtonRed');
            $('#button' + buttonCount).removeClass('overdue');
            continue;
        }

        showButton(buttonCount);
        var begin = new Date(openOrders[buttonCount].begin);
        var timer = new Date(date - begin);
        $('#button' + buttonCount).html("<b class='krsButtonOrderID'>" + openOrders[buttonCount].nr + "</b><br>(" + timer.getMinutes() + ":" + timer.getSeconds() + ")");
        $('#button' + buttonCount).val(openOrders[buttonCount].nr);
        if (timer.getMinutes() > 3 && !$('#button' + buttonCount).hasClass("overdue")) {
            $('#button' + buttonCount).addClass("krsButtonRed");
            $('#button' + buttonCount).addClass("overdue");
        } else if (timer.getMinutes() <= 3 && $('#button' + buttonCount).hasClass("overdue")) {
            $('#button' + buttonCount).removeClass("krsButtonRed");
            $('#button' + buttonCount).removeClass("overdue");
        }

    }
}

function loadOrders() {
    $.ajax("http://" + server + "/krs/api/getReadyOrders.php")
        .done(function (returnData) {
            if (returnData.hasOwnProperty("notifications")) {
                displayMessage(returnData.notifications[0]);

            } else {
                displayOrders(returnData);
            }

        }).fail(function (returnData) {
        displayMessage(returnData.notifications[0]);
    }).always(function () {

    });
}

function showButton(buttonID) {
    $('#button' + buttonID).show();
}

function hideButton(buttonID) {
    $('#button' + buttonID).hide();
}

function confirmPopup(orderId) {
    $('#confirmMessage').html("Bestellung " + orderId + " löschen?");
    $("#dialog-confirm").dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "Löschen": function () {
                removeOrder(orderId)
                $(this).dialog("close");
            },
            'Abbruch': function () {
                $(this).dialog("close");
            }
        }
    });
}

function removeOrder(orderID) {

    var postData = {
        'orderID': orderID,
        'debug': debug
    };

    $.post("http://" + server + "/krs/api/removeOrder.php", postData, function (returnData) {

        if (returnData.hasOwnProperty("success")) {

            //$('#'+id).removeClass('krsButtonRed');
            //$('#'+id).removeClass('overdue');
            loadOrders();

        } else if (returnData.hasOwnProperty("notifications")) {
            displayMessage(returnData.notifications[0]);
        }
    }).fail(function () {

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
    $('.overdue').toggleClass('krsButtonRed');
}

$(document).ready(function () {
    debug = false;
    $('#divErrorMsg').hide();
    $("#dialog-confirm").hide();

    $('#btnErrorMsg').on('click', function () {
        displayMessage('');
    })

    $('.krsButton').on('click', function () {
        confirmPopup($(this).val());
    })
    loadOrders();
    setInterval(classToggle, 1000);
    setInterval(loadOrders, 2000);

});
