jQuery(document).ready(function($){
  $(window).scroll(function() {

    $('.services h3').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeIn");
        $(this).addClass("animated");
      }
    });

    $('#service1 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeftBig");
        $(this).addClass("animated");
      }
    });


    $('#service2 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInUpBig");
        $(this).addClass("animated");
      }
    });

    $('#service3 div').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInRightBig");
        $(this).addClass("animated");
      }
    });   

    $('.feature2 li:nth-child(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft2");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft3");
        $(this).addClass("animated");
      }
    });  

    $('.feature2 li:nth-child(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft4");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(5)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft5");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(6)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft6");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(7)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft7");
        $(this).addClass("animated");
      }
    }); 

    $('.feature2 li:nth-child(8)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft8");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(9)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft9");
        $(this).addClass("animated");
      }
    });

    $('.feature2 li:nth-child(10)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("fadeInLeft10");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    }); 

    $('#skills .skill-container:nth-of-type(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInRight");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    });   

    $('#skills .skill-container:nth-of-type(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInRight");
        $(this).addClass("animated");
      }
    });

    $('#skills .skill-container:nth-of-type(5)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+500) {
        $(this).addClass("slideInLeft");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(1)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(2)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn2");
        $(this).addClass("animated");
      }
    }); 

    $('.flex-recent-posts .slides li:nth-of-type(3)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn3");
        $(this).addClass("animated");
      }
    });

    $('.flex-recent-posts .slides li:nth-of-type(4)').each(function(){
    var imagePos = $(this).offset().top;

    var topOfWindow = $(window).scrollTop();
      if (imagePos < topOfWindow+350) {
        $(this).addClass("fadeIn4");
        $(this).addClass("animated");
      }
    });    

  });
});