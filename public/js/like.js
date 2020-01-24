$(document).ready(function () {
   $('.like').on('click',function () {
       var like_s=$(this).attr('data-like');
       var post_id=$(this).attr('data-postid');
       post_id=post_id.slice(0,2);


       $.ajax({
           type:'POST',
           data:{post_id: post_id,like_s: like_s,_token:token},
           url:url,
           success:function(data) {
               if(data.is_like==1){

                   $('*[data-postid="'+post_id +'_l"]').removeClass('btn btn-secondary').addClass('btn btn-success');
                   $('*[data-postid="'+post_id +'_d"]').removeClass('btn btn-danger').addClass('btn btn-secondary');

                   //compute number
                   var current_like=$('*[data-postid="'+post_id +'_l"]').find('.like-count').text() // text used to get number
                   var new_like=parseInt(current_like) + 1;
                   $('*[data-postid="'+post_id +'_l"]').find('.like-count').text(new_like);

                   //when update like delete dislike
                   if(data.change_like==1){
                       var current_dislike=$('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text() // text used to get number
                       var new_dislike=parseInt(current_dislike) - 1;
                       $('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text(new_dislike);

                   }
               }
               if(data.is_like==0){

                   $('*[data-postid="'+post_id +'_l"]').removeClass('btn btn-success').addClass('btn btn-secondary');

                   var current_like=$('*[data-postid="'+post_id +'_l"]').find('.like-count').text() // text used to get number
                   var new_like=parseInt(current_like) - 1;
                   $('*[data-postid="'+post_id +'_l"]').find('.like-count').text(new_like);

               }
           }

       });

   });

   //===================================================================================================
    //============================================================================
    //================================================
    $('.dislike').on('click',function () {
        var like_s=$(this).attr('data-like');
        var post_id=$(this).attr('data-postid');
        post_id=post_id.slice(0,2);


        $.ajax({
            type:'POST',
            data:{post_id: post_id,like_s: like_s,_token:token},
            url:url_dis,
            success:function(data) {
                if(data.is_dislike==1){

                    $('*[data-postid="'+post_id +'_d"]').removeClass('btn btn-secondary').addClass('btn btn-danger');
                    $('*[data-postid="'+post_id +'_l"]').removeClass('btn btn-success').addClass('btn btn-secondary');

                    var current_dislike=$('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text() // text used to get number
                    var new_dislike=parseInt(current_dislike) + 1;
                    $('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text(new_dislike);
                    if(data.change_dislike==1){
                        var current_like=$('*[data-postid="'+post_id +'_l"]').find('.like-count').text() // text used to get number
                        var new_like=parseInt(current_like) - 1;
                        $('*[data-postid="'+post_id +'_l"]').find('.like-count').text(new_like);

                    }


                }
                if(data.is_like==0){

                    $('*[data-postid="'+post_id +'_d"]').removeClass('btn btn-danger').addClass('btn btn-secondary');

                    var current_dislike=$('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text() // text used to get number
                    var new_dislike=parseInt(current_dislike) - 1;
                    $('*[data-postid="'+post_id +'_d"]').find('.dislike-count').text(new_dislike);
                }
            }

        });

    });
});
