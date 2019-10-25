var page=1;
var is_busy = false;
var stopped = false;
function filter_data()
    {
        $('.filter_data').html('<div id="loading" style=""></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');
        var productor = get_filter('productor');
        var search = $('#search').val();

        $.ajax({
            url:"?c=ajax&a=filter",
            method:"post",
            dataType:"text",
            data:{
                action:action,
                minimum_price:minimum_price,
                maximum_price:maximum_price,
                category:category,
                productor:productor,
                search:search,
            },
            success: function(result){
                $('.filter_data').html(result);
                //reset page to pagingation
                stopped=false;
                page = 1;
            }
        });
    }

function load_more()
    {
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');
        var productor = get_filter('productor');
        var search = $('#search').val();

        $.ajax({
            url:"?c=ajax&a=filter",
            method:"post",
            dataType:"text",
            data:{
                action:action,
                minimum_price:minimum_price,
                maximum_price:maximum_price,
                category:category,
                productor:productor,
                search:search,
                page:page
            },
            success: function(result){
                $('.filter_data').append(result);
            }
        });
    }



function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

$(document).ready(function(){

    filter_data();

    $('#search').keyup(function(){
        filter_data();
        
    });

    $('.common_selector').on('click',function(){
        filter_data();
        
    });

    $('#price_range').slider({
        range:true,
        min:10000,
        max:50000000,
        values:[10000,50000000],
        step:10000,
        stop:function(event,ui)
        {
            $('#price_show').html(ui.values[0]+' VND - '+ui.values[1]+' VND');
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
            
        }
    });

    $(window).scroll(function() {
        if($(window).scrollTop() == $(document).height() - $(window).height()) {
            //check loading data or out of data
            if(is_busy==true||stopped==true){
                return false;
            }
            is_busy = true;
            load_more();
            page = page + 1 ;
            is_busy = false;
            return false;
        }
    });
});