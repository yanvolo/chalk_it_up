<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
	<head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
     <?php require 'library.php'; printHead(); ?>
     <title>Chalk it up!</title>
		<style>  
      textarea { 
          resize:none;
      }
      .question{
          placeholder="Question";
		  padding:5px !important;
		  margin:0px !important;
		  width:100% !important;
		  height:140px !important;
      }
      .answer{
          placeholder="Answer";
		  padding:5px !important;
		  margin:0px !important;
		  width:100% !important;
		  height:140px !important;
      }
      .distractor{
          placeholder="First Distractor";
		  width:100% !important;
		  height: 30px !important;
		  padding: 5px !important;
		  margin: 0px !important;
		  margin-bottom: 5px !important;
      }
	  .card{
		  padding:0px;
		  margin:0px;
		  width:100%;
		  height: 145px !important;
	  }
	  .card-table {
		  padding:0px !important; 
		  border:0px !important;
		  width:100% !important;
	  }
	  .delete-card{
		  height: 1em;
		  width: 1em;
		  font-size: 0.6em;
		  
	  }
	  .warning{
		  border: 1px solid red;
	  }
	  .full-width{
		  width:100%;
	  }
	  .question-area {
		  padding:0px !important;
		  margin:0px !important;
		  width:35% !important;
		  background-color:black !important;
	  }
	  .answer-area {
		  background-color:black !important;
		  padding:0px !important;
		  margin:0px !important;
		  width:35% !important;
		  
	  }
	  .distractor-area {
		  background-color:black !important;
		  padding:0px !important;
		  margin:0px !important;
		  width:30%; !important
	  }
	</style>
	</head>
	<body>
		<?php printNav(); ?>
		<form id="deck-data">
			<h3> Create a set! </h3>
			<p> Helper text that explains stuff </p>
			<div class="form-group">
				<label> Set Name: </label>
				<input type="text" placeholder="Set Name" name="set-name" class="form-control card-input" id="set-name" maxlength="100">
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
	  <div id="button-tray">
	  <button class="btn btn-danger" style="float:right; padding:10px;margin:10px;" id="rem-card"><span class="glyphicon glyphicon-minus" > </span> Rem. Card </button>
      <button class="btn btn-primary" style="float:right;padding:10px;margin:10px;" id="add-card"><span class="glyphicon glyphicon-plus" > </span> Add Card </button>
	  <button class="btn btn-default" style="float:right; padding:10px;margin:10px;" id="create-set"><span class="glyphicon glyphicon-th-large" > </span>Create Set</button> 
      <div>
      
	  <?php loadBasicScripts();?>
      <script src="js/createSet.js"></script>
	  </body>

</html>
