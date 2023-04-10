/* Funcionalidad para dar like y dislike */
var url = 'http://localhost:8000';

$(document).ready(function() {

    function like(){
        $('.btn-like').unbind('click').click( function(event){
            console.log('like');
            event.preventDefault();
            $(this).addClass('btn-dislike').removeClass('btn-like');
            image_id = $(this).data('imageid');

            $.ajax({
                url: `${url}/like/like/${image_id}`,
                type: 'GET'
            })
            .done(function(res){
                console.log('Has dado like a la publicacion');
                $(`#cantidad-likes-${image_id}`).text(res.cantidad);
            });

            dislike();
        });
    }
    like();

    function dislike(){
        $('.btn-dislike').unbind('click').click( function(event){
            console.log('dislike');
            event.preventDefault();
            $(this).addClass('btn-like').removeClass('btn-dislike');
            image_id = $(this).data('imageid');

            $.ajax({
                url: `${url}/like/dislike/${image_id}`,
                type: 'GET'
            })
            .done(function(res){
                console.log('Has dado dislike a la publicacion');
                $(`#cantidad-likes-${image_id}`).text(res.cantidad);
            });

            like();
        });
    }
    dislike();

});
