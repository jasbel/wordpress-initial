(function($) {

    $('#categorias-productos').change(function() {
        $.ajax({
            url: ajar.ajaxurl,
            method: 'POST',
            data: {
                'action': "ajarFilterProducts",
                'categoria': $(this).find(':selected').val()
            },
            beforeSend: function() {
                $('#resultado-productos').html("cargando...");
            },

            success: function(data) {
                // console.log(data);
                let html = "";
                data.forEach(item => {
                    html += `<div class="col-4 my-3">
                        <figure> ${item.imagen} </figure>
                        <h4 class="text-center my-2">
                            <a href="${item.link}">${item.titulo}</a>
                        </h4>
                    </div>`
                })
                $("#resultado-productos").html(html);
            },
            error: function(error) {
                console.log(error);
            }
        })
    });

    
    $(document).ready(function() {
        /* Para las entradas (3ultimas) que se visualizaran en rl front-page */
        $.ajax({
            url: ajar.apiurl+"novedades/3",
            
            method: 'GET',
            beforeSend: function() {
                $('#resultado-novedades').html("cargando...");
            },

            success: function(data) {
                // console.log(data);
                let html = "";
                data.forEach(item => {
                    html += `<div class="col-4 my-3">
                        <figure> ${item.imagen} </figure>
                        <h4 class="text-center my-2">
                            <a href="${item.link}">${item.titulo}</a>
                        </h4>
                    </div>`
                })
                $("#resultado-novedades").html(html);
            },
            error: function(error) {
                console.log(error);
            }
        })
    });

})(jQuery);