$(document).ready(function(){
    $('#submit').on('click',function(){
        if($('#fullname').val()==''||$('#username').val()==''||$('#password').val()==''||$('#c_password').val()==''||$('#gender').val()==''||
        $('#email').val()==''||$('#phone').val()==''||$('#birthday').val()==''||$('#address').val()=='')
        {
            alert('Vui lòng nhập đầy đủ thông tin');
            return false;
        }
    });
});