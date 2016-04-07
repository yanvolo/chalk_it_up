<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
     <!-- Latest compiled and minified CSS -->
	 <link rel="stylesheet" href="css/bootstrap.min.css"></link>
	 <!-- Optional theme -->
	 <link rel="stylesheet" href="css/bootstrap-theme.min.css"></link>
	 <!-- Personal Deafult Theme-->
	 <link rel="stylesheet" href="css/default.css"></link>
	 
	 <meta name="google-signin-scope" content="profile email"/>
     <meta name="google-signin-client_id" content="1054699344422-jr8acquecheeh5lrghtcvhabto42hni4.apps.googleusercontent.com"/>
	 <script src="https://apis.google.com/js/platform.js" async defer></script>
	 <link rel="icon" type="img/ico" href="cp.ico">
     <title>Chalk it up!</title>
		<style>  
      textarea { 
          resize:none;
      }
      .question{
          placeholder="Question";
      }
      .answer{
          placeholder="Answer";
		  padding:5px;
		  margin:10px;
		  width:100%;
		  height:1.5em;
      }
      .distractor{
          placeholder="First Distractor";
      }
	  .card{
		  width:100%;
	  }
	  .card-table{
		  padding:0px;
	  }
	  .delete-card{
		  height: 1em;
		  width: 1em;
		  font-size: 0.6em;
		  
	  }
	  .warning{
		  border: 1px solid red;
	  }
	</style>
	</head>
	<body>
		<?php require 'library.php'; printNav(); ?>
		
		<form>
		<h3> Create a set! </h3>
		<p> Helper text that explains stuff </p>
		<div class="form-group">
			<label> Set Name: </label>
			<input type="text" placeholder="Set Name" name="set-name" class="form-control card-input" id="set-name">
        </div>
		
		<table class="table table-bordered card-table">
         <thead class="thead-inverse">
             <th> <h4 class="text-center"> Question </h4> </th>
             <th> <h4 class="text-center"> Answer </h4> </th>
             <th> <h4 class="text-center"> Distractors </h4> </th>
         </thead>
		 <!-- 5 cards inserted by Jquerry at start-->
         <tbody class="text-center" id="deck"></tbody>
      </table>

      
      </form>
	  <button class="btn btn-danger" style="float:right; padding:10px;margin:10px;" id="rem-card"><span class="glyphicon glyphicon-minus" > </span> Rem. Card </button>
      <button class="btn btn-primary" style="float:right;padding:10px;margin:10px;" id="add-card"><span class="glyphicon glyphicon-plus" > </span> Add Card </button>
	  <button class="btn btn-default" style="float:right; padding:10px;margin:10px;" id="create-set"><span class="glyphicon glyphicon-th-large" > </span>Create Set</input>
      
      
      
      <!-- Jquery -->
      <script src="http://code.jquery.com/jquery-2.2.2.js" > </script>
      <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"   integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
      <script type="text/javascript">
          numCards = 0;
          function createID(name){
            return "#" + name.toString();   
          }
          function generateCard(number){
            var ret = '<tr class="card" id="card-' + number.toString() + '">';
            ret += '<td> <textarea rows="4" cols="50" class="question form-control card-input" id="question-'+number.toString()+'"></textarea> </td>';
            ret += '<td> <textarea rows="4" cols="50" class="answer form-control card-input" id="answer-'+number.toString()+'"></textarea> </td> <td>';
            ret += '<textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-'+number.toString()+'a"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-'+number.toString()+'b"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-'+number.toString()+'c"></textarea>';
            ret += '</td></tr>'
            return ret;
          }
          function addCard(){
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
          function removeCard(){
              if(numCards>1){
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
				  return true; 
			  }
			   
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
				  
				  if((isBlank($questionID)||isBlank($answerID) ||isBlank($distractorAID) ||isBlank($distractorBID) ||isBlank($distractorCID))
					  && !(isBlank($questionID)&&isBlank($answerID) &&isBlank($distractorAID) &&isBlank($distractorBID) &&isBlank($distractorCID))){
					  return confirm("Some fields are blank. Are you sure you would like to submit blank entries?"); 
				  }
			  }
			  return true; 
		  }
		  function submitCard(){
			  deck = [];
			  if(checkForBlanks()){
				  
				  for(i=1;i<=numCards;i++){
					  $questionID = $("#question-"+ i.toString());
					  $answerID = $("#answer-"+ i.toString());
					  $distractorAID = $("#distractor-"+ i.toString() + "a");
					  $distractorBID = $("#distractor-"+ i.toString() + "b");
					  $distractorCID = $("#distractor-"+ i.toString() + "c");
					  deck.push({
						  question:$questionID.val(),
						  answer:$answerID.val(),
						  distractorA:$distractorAID.val(),
						  distractorB:$distractorBID.val(),
						  distractorC:$distractorCID.val()
						  
					  });
				  }
			  }
			  return deck;
			  
		  }
          //Listeners and init
          $(document).ready(function(){
			  //init
			  //Add five cards for init
			  for(i=0;i<5;i++){
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
      </script>
	  </body>

</html>
