$(document).ready(function() {
    $('#search_form').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        
        $.ajax({
            url: '/search',
            method: 'GET',
            data: formData,
            success: function(response) { 
                $('#search_results').html(response); 
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});
