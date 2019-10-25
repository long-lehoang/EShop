$(document).ready(function () {
    $('#checkout').on('click',function(){
        if ($('#name').val()==''||$('#phone').val()==''||$('#address').val()==''||$('#email').val()=='')
        {
            alert("Vui lòng điền đầy đủ thông tin để thanh toán");
            return false;
        }
        if (!$('.cart_price').length)
        {
            alert("Không có sản phẩm để thanh toán");
            return false;
        }   
        ;
    });	
});
