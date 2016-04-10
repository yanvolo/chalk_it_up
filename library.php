<?php
function importXML($filename){
    $xmlDoc = new DOMDocument();
    $xmlDoc->load($filename);
    echo $xmlDoc -> saveXML();
}
$logged_in = NULL;
$display_name = NULL;
$login_name = NULL;
$uid = NULL;
function needUserInfo(){
    global $logged_in, $display_name, $login_name, $uid;
    if($logged_in !== NULL){
        return;
    }
    if($_COOKIE['sessionid'] === NULL){
        $logged_in = FALSE;
        return;
    }
    sql();
    $uid = getUidFromSession($_COOKIE['sessionid']);
    if($uid === FALSE or $uid === NULL){
        $uid = NULL;
        delSession($_COOKIE['sessionid']);
        setcookie("sessionid");
        $logged_in = FALSE;
        return;
    }
    $userRow = getUserRow($uid);
    if($userRow === FALSE){
        $uid = NULL;
        delSession($_COOKIE['sessionid']);
        setcookie("sessionid");
        $logged_in = FALSE;
        return;
    }
    $logged_in = TRUE;
    $display_name = $userRow['display_name'];
    $login_name = $userRow['login_name'];
}
function printDeps(){
    echo '<link rel="stylesheet" href="css/bootstrap.min.css"> </link>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"></link>
<link rel="stylesheet" href="css/default.css"></link>
<script src="http://code.jquery.com/jquery-2.2.2.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
';
    if($logged_in === FALSE){
        echo '    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("ID: " + profile.getId()); // Dont send this directly to your server!
        console.log("Full Name: " + profile.getName());
        console.log("Given Name: " + profile.getGivenName());
        console.log("Family Name: " + profile.getFamilyName());
        console.log("Image URL: " + profile.getImageUrl());
        console.log("Email: " + profile.getEmail());

        // The ID token you need to pass to your backend:
        var id_token = googleUser.getAuthResponse().id_token;
        console.log("ID Token: " + id_token);
      };
    </script>
	  <meta name="google-signin-scope" content="profile email"/>
        <meta name="google-signin-client_id" content="1054699344422-jr8acquecheeh5lrghtcvhabto42hni4.apps.googleusercontent.com"/>
	   <script src="https://apis.google.com/js/platform.js" async defer></script>
	   <link rel="icon" type="img/ico" href="cp.ico">';
    }
}

function printNav(){
    global $logged_in, $display_name, $login_name;
    echo '<nav class="navbar navbar-inverse navbar-fixed">
          <div class="container"> 
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-nav">
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span> 
						<span class="icon-bar"></span>
					</button>
					<a href="index.php" class="navbar-brand"> <img style="height:1em;" alt="Chalk it up" src="https://www.googledrive.com/host/0B9YkvbHM062yZTJzdGtGUi1jelk/img/logo_horzontal.png"/></a>
				</div>
				<div class="collapse navbar-collapse" id="my-nav">
					<ul class="nav navbar-nav navbar-right">
							<li>
' . ($logged_in === NULL ? '<script>alert("Ignore this message. logged_in is null. you didnt call needUserInfo.");</script>' : '') . (($logged_in === FALSE) ?
'<a data-toggle="modal" data-target="#loginModal">Login</a>
' :
     ("<a href=\"/profile.php?login_name=$login_name\">" . $display_name . '</a> <a href="/logout.php">Logout</a>')
) . '
</li>
					</ul>
					<ul class="nav navbar-nav">
						<li><a href="play_home.php"> Play </a> </li>
						<li><a href="classrooms_home.php"> Classrooms </a> </li>
						<li><a href="create_set.php"> @DEBUG: Create a set </a> </li>
						<li><a href="#"> Report an Issue </a> </li>
					</ul>
				</div>
			</div>
      </nav>
<div class="modal fade" role="dialog" id="loginModal">
<div class="modal-dialog">
<div class="modeal-content">

<div class="modal-header">
<span class="modal-title">Login</span>
<button class="close" data-dismess="modal">x</button>
</div>

<form action="auth_native.php" method="post">
<div class="modal-body">
<input type="text" name="login_name"/><br/>
<input type="password" name="secret"/><br/>
</div>
<div class="modal-footer">

<input style="float:left;" class="btn btn-primary" type="submit" value="Login"/>
<button style="float:left;" class="btn btn-default" data-dismiss="modal">Cancel</button>
<br/><br/>
<div class="g-signin2 navbar-btn" data-onsuccess="onSignIn" data-theme="dark"></div>
</div>
</form>

</div>
</div>
</div>

';
}

$rootDomain = "159.203.98.220";
$protocol = "http://";
$root = $protocol . $rootDomain . "/";

$goHome = '<a href="'.$root.'">How about we get you Home.</a>';

$sqlCon = NULL;

function sql(){
    global $sqlCon;

    if($sqlCon !== NULL){
        return;
    }

    $host = "/var/run/postgresql";
    $user = "postgres";
#    $pass = "<snip>";
    $dbName = "postgres";
    $sqlCon = pg_connect("host=$host dbname=$dbName user=$user "/*password=$pass*/)
        or die ("Could not connect to sql server\n");   
}
function doneWithSql(){
    global $sqlCon;
    if($sqlCon === NULL){
        return;
    }
    pg_close($sqlCon);
    $sqlCon = NULL;
}
function runSql($name, $stmt, $args){
    global $sqlCon;
    $res = pg_execute($sqlCon, $name, $args);
    if($res === FALSE){
        pg_prepare($sqlCon, $name, $stmt);
        $res = pg_execute($sqlCon, $name, $args);
    }
    return $res;
}
function runSql1( $name, $stmt, $args){
    $res = runSql($name, $stmt, $args);
    if($res === FALSE){
        return FALSE;
    }
    return pg_fetch_assoc($res, 0);
}
function runSql1Col($name, $stmt, $args, $col){
    $res = runSql1($name, $stmt, $args);
    if($res === FALSE){
        return FALSE;
    }
    return $res[$col];
}

function sqlVersion(){
    return runSql("version", "SELECT version();", array());
}
function printSql($res){
    $acc = "<table><tbody>";
    $acc .= "<tr><th>Row #</th>";
    for($i = 0; $i < pg_num_fields($res); $i++){
        $acc .= "<th>" . pg_field_name($res, $i) . "</th>";
    }
    $acc .= "</tr>";
    for($i = 0; $i < pg_num_rows($res); $i++){
        $acc .= "<tr><td>$i</td>";
        foreach(pg_fetch_row($res, $i) as $v) {
            $acc .= "<td>$v</td>";
        }
        $acc .= "<tr/>";
    }
    return $acc . "</tbody></table>";
}

function newSession($uid){
    $sessionid = base64_encode(random_bytes(16));
    $good = runSql("new_session", 'INSERT INTO session_ (sessionid, uid, last_ip, start_time) VALUES ($1, $2, $3, $4);', array($sessionid, $uid, $_SERVER['REMOTE_ADDR'], time()));    
    return $good ? $sessionid : FALSE;
}
function delSession($sessiond){
    $good = runSql("del_session", 'DELETE FROM session_ WHERE session_id = $1;', array($sessionid));    
    return $good;
}
function getUserRow($uid){
    return runSql1("get_user", 'SELECT * FROM user_ WHERE uid = $1;', array($uid));}
function getUidFromSession($sessionid){
    return runSql1Col("uid_from_session", 'SELECT uid FROM session_ WHERE sessionid = $1;', array($sessionid), 'uid');}
function getUidFromLoginName($login_name){
    $res = runSql1Col("select_user", 'SELECT uid FROM user_ WHERE login_name = $1;', array($login_name), "uid");
    return (($res === NULL or $res === FALSE) ? FALSE : $res);}
function newUser($login_name, $display_name){
    $uid = base64_encode(random_bytes(16));
    $good = runSql("new_user", 'INSERT INTO user_ (uid, login_name, display_name) VALUES ($1, $2, $3);', array($uid, $login_name, $display_name));
    return $good ? $uid : FALSE;
}
#function cleanSessions(){
#    $old = runSql("get_old_sessions", 'SELECT sessionid FROM session_ WHERE start_time < $1;', array(time() - 10));
