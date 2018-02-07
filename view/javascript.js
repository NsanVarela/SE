
//activating download button
$("#call").on("click",function(){
  $("#download").removeClass("disabled");
  $("#SaveTags").removeClass("disabled");
})

//Adding tags
$("input[type='text']").keypress(function(e){
	if(e.which === 13||e.which===32){
		//grabbing tag text from input
		var val = $(this).val();
    var regex = /</;
    // if(regex.test(val)==false){
      $(this).val("");
  		//create a new li and add to ul
      var list = $("#detect_tags > ul");
  		var item = $('<li name="tag" class="btn btn-outline-success tagval"></li>').append('<span><i class="fas fa-times close"></i></span>')
      var tag = $('<span></span>');
      tag.text(val);
      tag.appendTo(item);
      item.appendTo(list);
      $("#tags").val('');


	}
});
//Click on X to delete Tag
$("#detect_tags > ul").on("click","span", function(e){
  $(this).parent().remove();
  e.stopPropagation();
});

//showing contact



$("#contact").on("click",function(){
  $("#card_contacts").toggleClass('hidden');
});
/////SOUND SPEECH///////
       var recognizing;
        var recognition = new webkitSpeechRecognition();
        recognition.continuous = true;
        reset();
        recognition.onend = reset();

        recognition.onresult = function (event) {
          for (var i = event.resultIndex; i < event.results.length; ++i) {
            if (event.results[i].isFinal) {
              textarea.value += event.results[i][0].transcript;
            }
          }
        }

        function reset() {
          recognizing = false;
          
        }

        function toggleStartStop() {
          if (recognizing) {
            recognition.stop();
            reset();
          } else {
            recognition.start();
            recognizing = true;
            call.removeClass("btn-sucess").addClass("btn-danger");
           
          }
        }





