$("#searchBar").on("input propertychange keyup", function () {
    var input_value = $("#searchBar").val();

    if(input_value != "" && input_value != null){
        $.ajax({
            cache: false,
            type: "POST",
            url: '/search/multiple/' + input_value,
            success: function(result){
                $("#searchlist").html(result);

                if($("#searchlist").find("option").length == 1){
                    $("#searchlist").find("option").each(function () {
                        $.ajax({
                            cache: false,
                            type: "POST",
                            url: '/search/one/' + $(this).attr('id'),
                            success: function(result){
                                $("#result_search").html(result);
                                $("#result_search").show();
                                $('#add_to_basket').click(function () {
                                    var number_ingredients = $('#number_items').text();
                                    $(this).parent().parent().find('li').each(function () {
                                        $.ajax({
                                            cache: false,
                                            type: "POST",
                                            url: '/basket/add/',
                                            data: {
                                                ingredient: $(this).find('.ingredient').attr('id'),
                                                quantity: $(this).find('.quantity').text(),
                                            },
                                            success: function(result){
                                                number_ingredients++;
                                                $('#number_items').html(number_ingredients);
                                            },
                                        });
                                    });
                                });
                            },
                        });
                    });
                }
                else{
                    $("#result_search").hide();
                }

            },
        });
    }
    else{
        $("#result_search").hide();
    }
});

