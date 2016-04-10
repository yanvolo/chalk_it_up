<html>
  <head xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <style>      * {
      font-family: sans;
      }
    </style>
    
    <title>no</title>
    
  </head>
  <body>
    <?php 
       require "library.php";

sql();
echo "pg_connect exists? it MUST for things to work:" . (function_exists("pg_connect") ? "t" : "f") . "<br/>";
echo "sqlCon !== NULL:" . ($sqlCon !== NULL ? "t" : "f") . "<br/>";
if($sqlCon !== NULL){
    $res = sqlVersion();
    if($res === FALSE){
        echo "SELECT version():" . "FALSE";
    }else{
        echo "SELECT version():" . printSql($res);
    }
    #echo printSql(runSql('', 'SELECT * FROM user_;', array()));
}
doneWithSql();
       ?>
    
    <h1>phpinfo():</h1>
    <?php phpinfo(); ?>

    <script>if(Math.random()<.01){confirm("Do you liek bananas?");}</script>
    
    
  </body>
  
</html>
