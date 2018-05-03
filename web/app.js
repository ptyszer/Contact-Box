$(function () {
    $('#formAddress').hide();
    $('#formEmail').hide();
    $('#formPhone').hide();
});

$('#new-address').click(function(){
    $('#formAddress').show();
});

$('#new-email').click(function(){
    $('#formEmail').show();
});

$('#new-number').click(function(){
    $('#formPhone').show();
});

$(".delete-address").on('click', function () {
    var id = $(this).data('id');
    $.ajax({
        url: "/deleteAddress/" + id,
        data: {
            id: id
        },
        type: "DELETE",
        dataType: "json"
    }).done(function () {
        location.reload();
    }).fail(function () {
        alert( "Error");
    });
});

$(".delete-email").on('click', function () {
    var id = $(this).data('id');
    $.ajax({
        url: "/deleteEmail/" + id,
        data: {
            id: id
        },
        type: "DELETE",
        dataType: "json"
    }).done(function () {
        location.reload();
    }).fail(function () {
        alert( "Error");
    });
});

$(".delete-number").on('click', function () {
    var id = $(this).data('id');
    $.ajax({
        url: "/deletePhone/" + id,
        data: {
            id: id
        },
        type: "DELETE",
        dataType: "json"
    }).done(function () {
        location.reload();
    }).fail(function () {
        alert( "Error");
    });
});