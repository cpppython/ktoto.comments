$( document ).ready(function() {
  var wordsMin = document.getElementById("wordsMin").innerText;
  var wordsMax = document.getElementById("wordsMax").innerText;
  var templateFolder = document.getElementById("templateFolder").innerText;
  var lengthResult = document.getElementById("lengthResult");
  var commentSubmit = document.getElementById("commentSubmit");
  commentSubmit.disabled = true;
  commentSubmit.setAttribute("style","opacity:0.4; -moz-opacity:0.4; filter:alpha(opacity=40)");

  function showCount() {

      if (messms.value.length < wordsMin) {
          lengthResult.innerHTML = "&#8194;" + messms.value.length + " из " + wordsMax + " символов (минимум " + wordsMin + ")";
          lengthResult.setAttribute("style","color:red;");
      } 
      else 
      {
          if (messms.value.length < wordsMax) {
              lengthResult.innerHTML = "&#8194;" + messms.value.length + " из " + wordsMax + " символов";
              lengthResult.setAttribute("style","color:green;");
              commentSubmit.disabled = false;
              commentSubmit.setAttribute("style","opacity:1; -moz-opacity:1; filter:alpha(opacity=100)");
          } 
          else
          {
              lengthResult.innerHTML = "&#8194;" + messms.value.length + " из " + wordsMax + " допустимых символов";
              lengthResult.setAttribute("style","color:red;");
              commentSubmit.disabled = true;
              commentSubmit.setAttribute("style","opacity:0.4; -moz-opacity:0.4; filter:alpha(opacity=40)");
          }
      }
      var last = messms.value.slice(-1);
      var penult = messms.value.substr(messms.value.length-2, 1);
      if (last == " " && penult == " ") { document.getElementById("messms").value = messms.value.slice(0, -1) }

  }

  messms.onkeyup = messms.oninput = showCount;
  messms.onpropertychange = function() {
      if (event.propertyName == "value") showCount();
  }
  messms.oncut = function() {
      setTimeout(showCount, 0); 
  };

  $('#commentSubmit').click(function(e) {
    e.preventDefault();
      $.ajax({
        method: "POST",
        url: '' + templateFolder + '/ajax.php',
        type: "post",
        data: {
          'formID': $("#formIDUser").val(),
          'name': $("#commentName").val(),
          'msg': $("#messms").val(),
          'email': $("#commentEmail").val(),
          'IBLOCK_ID_BASE': $("#iblockIDBASE").text(),
          'IBLOCK_ID': $("#iblockID").text(),
          'ELEMENT_ID': $("#elementID").text(),
          'MAIL_ADMIN': $("#postMail").text(),
          'PAGE_URL': $("#pageURL").text()
          
        },
        success: function(data) {
          
          $("#commentForm").fadeOut(800); 
          
          setTimeout(function (){
            $('#responceOfComment').html(data);
            $("#responceOfComment").fadeIn(800);
          }, 800);
          setTimeout(function (){
            $("#responceOfComment").fadeOut(800);
          }, 3000);
          
        }
      });
  });

  $('.adminModerCommentsButtonsAdd').click(function(e) {
    e.preventDefault(); 
    
    var formid = $(this).attr('data-formid-local');
    var elementid = $("#elementid-" + formid + "").val();
    var newtime = $("#meeting-time-" + formid + "").val();

    $.ajax({
      method: "POST",
      url: '' + templateFolder + '/ajax.php',
      type: "post",
      data: {
        'formID': $("#formID").val(),
        'elementid': elementid,
        'newtime': newtime,
        'add': 1
        
      },
      success: function(data) {
        
        $("#commentForm").fadeOut(800); 
        
        setTimeout(function (){
          $('#commentItemNew-' + formid + '').html(data);
          $('#commentItemNew-' + formid + '').fadeIn(800);
        }, 800);
        setTimeout(function (){
          $('#commentItemNew-' + formid + '').fadeOut(800);
        }, 3000);

        setTimeout(function (){
        $('#commentsItemsPublic').load(document.URL +  ' #commentsItemsPublic');
      }, 3500);
        
      }
    });

  });

  $('.adminModerCommentsButtonsDel').click(function(e) {
    e.preventDefault(); 
    
    var formid = $(this).attr('data-formid-local');
    var elementid = $("#elementid-" + formid + "").val();

    $.ajax({
      method: "POST",
      url: '' + templateFolder + '/ajax.php',
      type: "post",
      data: {
        'formID': $("#formID").val(),
        'elementid': elementid,
        'delete': 1
        
      },
      success: function(data) {
        
        $("#commentForm").fadeOut(800); 
        
        setTimeout(function (){
          $('#commentItemNew-' + formid + '').html(data);
          $('#commentItemNew-' + formid + '').fadeIn(800);
        }, 800);
        setTimeout(function (){
          $('#commentItemNew-' + formid + '').fadeOut(800);
        }, 4000);

        setTimeout(function (){
        $('#commentsItemsPublic').load(document.URL +  ' #commentsItemsPublic');
      }, 4900);
        
      }
    });

  });

  $("#forCommentOpenAddForm").on("click","a", function (event) {
    event.preventDefault();
    var id  = $(this).attr('href'),
    top = $(id).offset().top - 70;
    $('body,html').animate({scrollTop: top}, 1200);
  });
});
