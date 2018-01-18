$("img").click(function () {
    var image = $(this);
    $.ajax({
        cache: false,
        type: "POST",
        url: '/basket/delete/',
        data: {
            id: image.parent().attr('id'),
        },
        success: function(result){
            var delete_alert = "<div class='alert alert-danger'><h3>L'article a bien été supprimé</h3></div>"
            image.parent().html(delete_alert);
            $('.alert-danger').each(function () {
                $(this).fadeOut(600, function () {
                    $(this).parent().parent().remove();
                });
            });
            var counting = $('#number_items').text();
            counting--;
            $('#number_items').html(counting);
        },
    });
});