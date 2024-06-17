$(document).ready(function() {
    $('#search_form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/products/search',
            method: 'GET',
            data: formData,
            dataType: 'json',
        })
            .done(function(response) {
                $('#search_results').html(response); 
            })
            .fail(function(xhr, status, error) {
                alert('エラー');
            })
        });
    });

$(document).ready(function()  {
    $('.delete-product').on('click', function(e) {
        e.preventDefault();
    
        var deleteConfirm = confirm('削除してよろしいでしょうか？');

        if(deleteConfirm == true) {
            var clickEle = $(this);
            var productID = clickEle.attr('data-product-id');

            $.ajax({
                type: 'POST',
                url: '/products/' + productID,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN':  $('meta[name="csrf-token"]').attr('content')
                },
                data: {'id':productID,
                    '_method': 'DELETE'},
            })
            .done(function() {
                clickEle.parents('tr').remove();
            })
            .fail(function() {
                alert('エラー');
            });
        }
    });
});
