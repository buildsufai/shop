function recalculateOrder() {
    var el = $(this);
    var id = el.data('id');
    var price = el.data('price');
    var count = el.val();
    var total = price*count;
    $('div#total-'+id).html(total);
}

function productAdded(res) {
    alert(res);
}

function addToCart(ev) {
    ev.preventDefault();
    var el= $(this);
    var url = el.attr('href');
    var count = $(el[0].parentElement.parentElement).find('input[type="number"]').val();

    $.ajax(url, {
        'data' : {
            count: count
        },
        'success': productAdded,
        'dataType': 'json'
    });
}

$(document).ready(function() {
    $('div#product-list input').change(recalculateOrder);

    $('a.add-to-cart').click(addToCart);
});