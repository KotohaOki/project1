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
