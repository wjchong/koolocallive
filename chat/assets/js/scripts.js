var $window = $(window);
function setCSS() {
    // var windowHeight = $(window).innerHeight();
    var windowHeight = $(window).height();
    var windowWidth = $(window).width(); 
    var boxHeight = ($(window).height() - 40 ); 
    var boxHeight = ($(window).height() - 40 );
    var sideBtHeight = $(".top-logo").outerHeight(true);
    var sideBtmHeight = ( boxHeight - sideBtHeight );
    var msgNavHeight = $(".msg-nav").outerHeight(true);
    var btmMsgHeight = $(".btm-msg").outerHeight(true);
    var msgouterHeight = ( msgNavHeight + btmMsgHeight );
    var msgHeight = ( boxHeight - msgouterHeight );
    var searchTop = $(".search-top").outerHeight(true);
    var SearchBtm = ( boxHeight - searchTop );
    var mamtchTop = $(".match-top").outerHeight(true);
    var matchBtm = ( boxHeight - mamtchTop );

    var dicTop = $(".discovery-top").outerHeight(true);
    var dicbtn = $(".disc-btn").outerHeight(true);
    var disout = ( dicTop + dicbtn );
    var disinn = ( boxHeight - disout );

    var homeBtm = $(".btm-btns").outerHeight(true);
    var homeTop = ( boxHeight - homeBtm );

    var proTop = $(".pro-top").outerHeight(true);
    var proBtm = ( boxHeight - proTop );

    $('.full-outer').css('height', windowHeight);
    
    $('.full-outer').css('width', windowWidth); 
    $('.full-outer').css('padding', 20); 
    $('.full-outer').css('padding-left', 40); 
    $('.full-outer').css('padding-right', 40); 
    $('.box-outer').css('height', boxHeight); 
    $('.center-box').css('height', boxHeight); 
    $('.new-log .left-blk').css('height', boxHeight); 

    $('.side-btm').css('margin-top', sideBtHeight);    
    $('.side-btm').css('height', sideBtmHeight); 

    $('.msg').css('height', msgHeight);
    $('.search-list').css('height', SearchBtm);
    $('.home-top').css('height', homeTop);    
    $('.pro-btm').css('height', proBtm);    
    $('.match-btm').css('height', matchBtm); 
       
    $('.discovery-btm').css('height', disinn);    

    if($(window).width() < 768) {
        $('#mobile-app').show();
    } else {
        $('#mobile-app').hide();
    }
}

$(document).ready(function() {

  setCSS();
  $(window).resize(function() {
    setCSS();
  });



  $('.image-area').thumbchanger({
  mainImageArea: '.main-image',
  subImageArea:  '.sub-image',
  trigger:       'click',
  easing:        'linear',
  animateTime:   300,
  fixHeight:     true,
  onload: true
});

}); 


$(document).ready(

  function() { 

    $(".smooth-scroll").niceScroll();

  }

);

//   $(function() {
//   var output = document.querySelectorAll('output')[0];
  
//   $(document).on('input', 'input[type="range"]', function(e) {
//         output.innerHTML = e.currentTarget.value;
//   });
  
//   $('input[type=range]').rangeslider({
//     polyfill: false
//   });
  
// });

  $(function() {
  var output = document.querySelectorAll('output')[0];
  
  $(document).on('input', 'input[type="range"]', function(e) {
   
        document.querySelector('output.'+this.id).innerHTML = e.target.value;
  });
  
  $('input[type=range]').rangeslider({
    polyfill: false
  });
});


  //profile image upload preview
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#profile_image_preview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn").change(function(){
    readURL(this);
});


function readURL_2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#profile_image_preview2').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn2").change(function(){
    readURL_2(this);
});

function readURL_3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#profile_image_preview3').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn3").change(function(){
    readURL_3(this);
});


function readURL_4(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#profile_image_preview4').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn4").change(function(){
    readURL_4(this);
});


function readURL_5(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#profile_image_preview5').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#profile_img_upload_btn5").change(function(){
    readURL_5(this);
});


  $( document ).ready(function() {

      $("#match-popup-close").click(function(){
          $(".match-popup").hide();
      });

    


  $(".pay-popup").bind("click", function () {
          
         $(".pay-popup").hide();
      });

      $(".pay-outer").bind("click", function (event) {
          event.stopPropagation();
      });


      // $(".match-popup").bind("click", function () {
          
      //    $(".match-popup").hide();
      // });

      // $(".match-outer").bind("click", function (event) {
      //     event.stopPropagation();
      // });


});

function popup() {
    $('#likeCountPopup').show();
}

function paypopup() {

  //  $('#payPopup').show();

    $('#get-flamer-popup').show();
}


 