<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css"> </link>

		<!-- Optional theme -->
		<link rel="stylesheet" href="css/bootstrap-theme.min.css"> </link>
		  
		<meta name="google-signin-scope" content="profile email"/>
		<meta name="google-signin-client_id" content="1054699344422-jr8acquecheeh5lrghtcvhabto42hni4.apps.googleusercontent.com"/>
	   <script src="https://apis.google.com/js/platform.js" async defer></script>
		<style>
		* {
			border-radius: 0 !important;
		}
      .strokeme{
            color: white;
            text-shadow:
            -2px -2px 0 #000,
            2px -2px 0 #000,
            -2px 2px 0 #000,
            2px 2px 0 #000;  
        }    
      textarea { 
          resize:none;
      }
      .question{
          placeholder="Question";
      }
      .answer{
          placeholder="Answer";
      }
      .distractor{
          placeholder="First Distractor";
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
		<title>Chalk it up!</title>
	
	</head>
	<body>
		<?php require 'library.php'; printNav(); ?>
		<form>
		<table class="table table-bordered card-table">
         <thead class="thead-inverse">
             <th> <h4 class="text-center"> Question </h4> </th>
             <th> <h4 class="text-center"> Answer </h4> </th>
             <th> <h4 class="text-center"> Distractors </h4> </th>
         </thead>
         <tbody class="text-center" id="deck">
             <tr id="card-1"> 
                 <td> <textarea rows="4" cols="50" class="question form-control card-input" id="qustion-1"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer form-control card-input" id="answer-1"></textarea> </td>
                 <td> 
					<div class="form-group">
                      <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-1a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-1b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-1c"></textarea>
					</div>  
                 </td>
             </tr>
            <tr id="card-2"> 
                 <td> <textarea rows="4" cols="50" class="question form-control card-input" id="qustion-2"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer form-control card-input" id="answer-2"></textarea> </td>
                 <td> 
                     <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-2a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-2b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor form-control card-input" id="distractor-2c"></textarea>
                 </td>
             </tr>
         </tbody>
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
          numCards = 2;
          function createID(name){
            return "#" + name.toString();   
          }
          function generateCard(number){
            var ret = '<tr id="card-' + number.toString() + '">';
            ret += '<td> <textarea rows="4" cols="50" class="question card-input form-control" id="qustion-'+number.toString()+'"></textarea> </td>';
            ret += '<td> <textarea rows="4" cols="50" class="answer card-input form-control" id="answer-'+number.toString()+'"></textarea> </td> <td>';
            ret += '<textarea rows="1" cols="50" class="distractor card-input form-control" id="distractor-'+number.toString()+'a"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor card-input form-control" id="distractor-'+number.toString()+'b"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor card-input form-control" id="distractor-'+number.toString()+'c"></textarea>';
            ret += '</td></tr>'
            return ret;
          }
          function addCard(){
			  numCards++;
			  //Create New Blank Card
			  $("#deck").append(generateCard(numCards));
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
			  for(i=1;i<=numCards;i++){
				  console.log(i);
				  $questionID = $("#question-"+ i.toString());
				  $answerID = $("#answer-"+ i.toString());
				  $distractorAID = $("#distractor-"+ i.toString() + "a");
				  $distractorBID = $("#distractor-"+ i.toString() + "b");
				  $distractorCID = $("#distractor-"+ i.toString() + "c");
				  if(isBlank($questionID)||isBlank($answerID) ||isBlank($distractorAID) ||isBlank($distractorBID) ||isBlank($distractorCID)){
					  $('.card-input').blur();
					  return confirm("Some fields are blank. Are you sure you would like to submit blank entries?"); 
				  }
			  }
			  return true; 
		  }
		  function submitCard(){
			  return checkForBlanks();
			  
		  }
          //Listeners
          $(document).ready(function(){
              $("#add-card").click(function(){
                  addCard();
              });
              $("#rem-card").click(function(){
                  removeCard();
              });
			  $('.card-input').blur(function(){
					if(isBlank($(this))){
						$(this).addClass('warning');
					}
					else{
						$(this).removeClass('warning');
					}
				});
				$('#create-set').click(function(){
					submitCard();
				});
          });
      </script>
	  </body>

</html>
