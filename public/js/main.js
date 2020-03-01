/*cart*/
$('body').on('click', ' .add-to-cart-link', function (e) {
    e.preventDefault();
    console.log('111');
});
/*cart*/

$('#currency').change(function(){
    window.location = 'currency/change?curr=' + $(this).val();
});

$('.available select').on('change', function(){
    var modId = $(this).val(),
        color = $(this).find('option').filter(':selected').data('title'),
        basePrice = $('#base-price').data('base'),
        price = $(this).find('option').filter(':selected').data('price');
    if (price)
    {
        $('#base-price').text(symboleLeft + price + symboleRight);

    } else {
        $('#base-price').text(symboleLeft + basePrice + symboleRight);
    }
});