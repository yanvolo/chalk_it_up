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

		</style>
		  
		<title>Chalk it up!</title>
	
	</head>
	<body>
		<?php require 'library.php'; printNav(); ?>
		<table class="table table-bordered card-table">
         <thead class="thead-inverse">
             <th> <h4 class="text-center"> Question </h4> </th>
             <th> <h4 class="text-center"> Answer </h4> </th>
             <th> <h4 class="text-center"> Distractors </h4> </th>
         </thead>
         <tbody class="text-center" id="deck">
             <tr id="card-1"> 
                 <td> <textarea rows="4" cols="50" class="question" id="qustion-1"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer" id="answer-1"></textarea> </td>
                 <td> 
					<div class="form-group" style="float:left">
                      <textarea rows="1" cols="50" class="distractor" id="distractor-1a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-1b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-1c"></textarea>
					</div>  
					<div style="float:right">
					  <a class="btn btn-default delete-card"><span class="glyphicon glyphicon-remove text-center"></span></a> 
					</div>
                 </td>
             </tr>
            <tr id="card-2"> 
                 <td> <textarea rows="4" cols="50" class="question" id="qustion-2"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer" id="answer-2"></textarea> </td>
                 <td> 
                     <textarea rows="1" cols="50" class="distractor" id="distractor-2a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-2b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-2c"></textarea>
                 </td>
             </tr>
             <tr id="card-3"> 
                 <td> <textarea rows="4" cols="50" class="question" id="qustion-3"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer" id="answer-3"></textarea> </td>
                 <td> 
                     <textarea rows="1" cols="50" class="distractor" id="distractor-3a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-3b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-3c"></textarea>
                 </td>
             </tr>
             <tr id="card-4"> 
                 <td> <textarea rows="4" cols="50" class="question" id="qustion-4"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer" id="answer-4"></textarea> </td>
                 <td> 
                     <textarea rows="1" cols="50" class="distractor" id="distractor-4a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-4b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-4c"></textarea>
                 </td>
             </tr>
             <tr id="card-5"> 
                 <td> <textarea rows="4" cols="50" class="question" id="qustion-5"></textarea> </td>
                 <td> <textarea rows="4" cols="50" class="answer" id="answer-5"></textarea> </td>
                 <td> 
                     <textarea rows="1" cols="50" class="distractor" id="distractor-5a"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-5b"></textarea> <br> 
                      <textarea rows="1" cols="50" class="distractor" id="distractor-5c"></textarea>
                 </td>
             </tr>
         </tbody>
      </table>
      <button class="btn btn-danger" style="float:right; padding:10px;margin:10px;" id="rem-card"><span class="glyphicon glyphicon-minus" > </span> Rem. Card </button>
      <button class="btn btn-primary" style="float:right;padding:10px;margin:10px;" id="add-card"><span class="glyphicon glyphicon-plus" > </span> Add Card </button>
      
      
      
      <!-- Jquery -->
      <script src="http://code.jquery.com/jquery-2.2.2.js" > </script>
      <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"   integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
      <script type="text/javascript">
          var numCards = 5;
          function createID(name){
            return "#" + name.toString();   
          }
          function generateCard(number){
            var ret = '<tr id="card-' + number.toString() + '">';
            ret += '<td> <textarea rows="4" cols="50" class="question" id="qustion-'+number.toString()+'"></textarea> </td>';
            ret += '<td> <textarea rows="4" cols="50" class="answer" id="answer-'+number.toString()+'"></textarea> </td> <td>';
            ret += '<textarea rows="1" cols="50" class="distractor" id="distractor-'+number.toString()+'a"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor" id="distractor-'+number.toString()+'b"></textarea> <br>';
            ret += '<textarea rows="1" cols="50" class="distractor" id="distractor-'+number.toString()+'c"></textarea>';
            ret += '</td></tr>'
            return ret;
          }
          function addCard(){
              numCards += 1;
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
          //Listeners
          $(document).ready(function(){
              $("#add-card").click(function(){
                  addCard();
              });
              $("#rem-card").click(function(){
                  removeCard();
              });
          });
      </script>
			</body>

</html>