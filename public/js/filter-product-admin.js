var page=1;

function filter_data()
    {
        var action = 'fetch_data';
        var category = get_filter('category');
        $.ajax({
            url:"?c=ajax&a=index",
            method:"post",
            dataType:"text",
            data:{
                action:action,
                category:category,
                page:page,
            },
            success: function(result){
                $('.filter_data').html(result);
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

function pagination()
{
    if(event.target.value=='Prev')
    page--;
    else if(event.target.value=='Next')
    page++;
    else 
    page = parseInt(event.target.value);
    filter_data();
}

$(document).ready(function(){

    filter_data();

    $('.common_selector').on('click',function(){
        page = 1;
        filter_data();
    });
});