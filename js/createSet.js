numCards = 0;
minCards = 5;
maxCards = 2000;
isLoading = false;
function generateCard(number){
ret  = '<tr class="card" id="card-' + number.toString() + '">';
ret += '<td class="question-area"> <textarea maxlength="1023" class="question form-control card-input" id="question-'+number.toString()+'"></textarea> </td>';
ret += '<td class="answer-area"> <textarea maxlength="1023" class="answer form-control card-input" id="answer-'+number.toString()+'"></textarea></td>';
ret += '<td class="distractor-area">';
ret += '<textarea  maxlength="1023" class="distractor form-control card-input" id="distractor-'+number.toString()+'a"></textarea> <br>';
ret += '<textarea maxlength="1023" class="distractor form-control card-input" id="distractor-'+number.toString()+'b"></textarea> <br>';
ret += '<textarea maxlength="1023" class="distractor form-control card-input" id="distractor-'+number.toString()+'c"></textarea>';
ret += '</td></tr>'
return ret;
}
function addCard(){
  if(numCards<=maxCards){
	  numCards++;
	  //Create New Blank Card
	  $("#deck").append(generateCard(numCards));
	  $('.card-input').blur(function(){
			if(isBlank($(this))){
				$(this).addClass('warning');
			}
			else{
				$(this).removeClass('warning');
			}
		});	  
  }
}
function removeCard(){
  if(numCards>minCards){
	  $(createID("card-"+numCards)).empty();
	  $(createID("card-"+numCards)).remove();
	  numCards--;
	}
}
function isBlank($field){
  try{
	  return $field.val().length === 0;
  }
  catch(err){
	  //Would prefer to warn user of non blank card rather than pass up blank one
	  //Also, this allows the code to pass over deleted cards
	  return true; 
  }
   
}
function isBlankCard(i){
  $question = $("#question-"+ i.toString());
  $answer = $("#answer-"+ i.toString());
  $distractorA = $("#distractor-"+ i.toString() + "a");
  $distractorB = $("#distractor-"+ i.toString() + "b");
  $distractorC = $("#distractor-"+ i.toString() + "c");
  return isBlank($question) && isBlank($answer) && isBlank($distractorA) && isBlank($distractorB) && isBlank($distractorC);
}
function checkForBlanks(){
  $('.card-input').blur();
  if(isBlank($("#set-name"))){
	  alert("Please name your set");
	  return false;
  }
  for(i=1;i<=numCards;i++){
	  $questionID = $("#question-"+ i.toString());
	  $answerID = $("#answer-"+ i.toString());
	  $distractorAID = $("#distractor-"+ i.toString() + "a");
	  $distractorBID = $("#distractor-"+ i.toString() + "b");
	  $distractorCID = $("#distractor-"+ i.toString() + "c");
	  
	  questionCheck = isBlank($questionID);
	  answerCheck = (isBlank($answerID));
	  distractorACheck = isBlank($distractorAID);
	  distractorBCheck = isBlank($distractorBID);
	  distractorCCheck = isBlank($distractorCID);
	  
	  if((isBlank($questionID)||isBlank($answerID) ||isBlank($distractorAID) ||isBlank($distractorBID) ||isBlank($distractorCID)) && !(isBlankCard(i))){
		  return confirm("Some fields are blank. Proceed and sumbmit blank entries?"); 
	  }
  }
  return true; 
}
function submitCard(){
  deck = new Array();
  if(checkForBlanks()){
	  //Name of set is first element and is followed by all cards
	  console.log("Num cards:" +numCards);
	  for(i=1;i<=numCards;i++){
		  if(!isBlankCard(i)){
			  $questionID = $("#question-"+ i.toString());
			  $answerID = $("#answer-"+ i.toString());
			  $distractorAID = $("#distractor-"+ i.toString() + "a");
			  $distractorBID = $("#distractor-"+ i.toString() + "b");
			  $distractorCID = $("#distractor-"+ i.toString() + "c");
			 
			  deck.push({
			     	  question: $questionID.val(),
				  answers: [$answerID.val(), $distractorAID.val(), $distractorBID.val(), $distractorCID.val()]
//				  answers: CSV.encode([[$answerID.val(), $distractorAID.val(), $distractorBID.val(), $distractorCID.val()]])
			  }); 
		}
	  }
		  
	  //Make sure that deck meets minimum length
	  if(deck.length<minCards){
		  alert("Please include at least "+minCards +" cards");
	  }
	  else{
		//Notify the user that we are loading
		if(!isLoading){
			$("#button-tray").prepend("<p>Loading...</p>");
			isLoading = true; 
			
			$("#create-set").unbind("click");
			

			data = {name: $("#set-name").val(),
				desc: 'No description.',
				cards: deck
			       };

			//posting = $.post("new_deck_processor.php",data,function(){console.log("Data sent successfully")});
		    posting = $.post("new_deck_processor.php",data,function(res){
console.log("Data sent successfully");
var w = window.open('about:blank');
with(w.document){
open();
write(res);
close();
}
});


			posting.done(function(data){
				console.log(data);
			});
		}
		

		return deck;
	  }
  }
return deck;  
}
//Listeners and init
$(document).ready(function(){
	//init
	//Add min number of cards during init
	while(numCards<minCards){
	 addCard(); 
	}
	$("#add-card").click(function(){
	  addCard();
	});
	$("#rem-card").click(function(){
	  removeCard();
	});	  
	$('#create-set').click(function(){
		submitCard();
	});
});

//use M-q M-w to fill all fields w/ a-zA-Z
var debug = null;
$('body')[0].onkeydown = function(e){
    if(!e.altKey){
	if(debug){$('body')[0].style.backgroundColor = debug;}
	debug = null;
	return;
    }
    if(!debug && String.fromCharCode(e.keyCode) == 'Q'){
	debug = $('body')[0].style.backgroundColor || '#fff';
	$('body')[0].style.backgroundColor = '#f00';
    }else if(debug){
	if(String.fromCharCode(e.keyCode) == 'W'){
	    var xs = $('input').toArray().concat($('textarea').toArray());
	    var ix = 0;
	    var alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    for(var i = 0; i < xs.length; i++){
		if(xs[i].tagName == 'textarea' || xs[i].type == 'text' || xs[i].type == 'textarea'){
		    xs[i].value = alpha.charAt(ix++ );
		}
	    }
	}
	$('body')[0].style.backgroundColor = debug;
	debug = null;
    }
}
