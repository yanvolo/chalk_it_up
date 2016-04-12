<?php
	$logged_in = NULL;
	$display_name = NULL;
	$login_name = NULL;
	$uid = NULL;
$is_admin = NULL;
$admin_permissions = NULL;
	function needUserInfo(){
		global $logged_in, $display_name, $login_name, $uid, $admin_permissions, $is_admin;
		if(isset($logged_in)){
			return;
		}
		if(!isset($_COOKIE['sessionid'])){
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
        $admin = runSql1('select_admin_by_uid', 'SELECT * FROM admin WHERE uid = $1;', array($uid));
        if($admin){
            $is_admin = TRUE;
            $admin_permissions = str_getcsv($admin['permissions_csv']);
        }else{
            $is_admin = FALSE;
        }
	}
function printDeps(){
    global $logged_in;
    echo '<link rel="stylesheet" href="css/bootstrap.min.css"> </link>
<link rel="stylesheet" href="css/bootstrap-theme.min.css"></link>
<link rel="stylesheet" href="css/default.css"></link>
<script src="http://code.jquery.com/jquery-2.2.2.js" ></script>
<script src="js/bootstrap.min.js" ></script><script src="js/jquery.fittext.js"></script>
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
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
function getLoginFailMsg(){
    if(!isset($_GET['fail_auth_native_msgid'])){
        return '';
    }
    switch($_GET['fail_auth_native_msgid']){
    case '': return '';
    case 0: return $_GET['fail_auth_login_name'] === '' ? 'No username was entered.' : "No account named '".filter_var($_GET['fail_auth_login_name'], FILTER_SANITIZE_SPECIAL_CHARS)."' exists.";
    case 1: return "Your account was found, but you have no password set. Perhaps you've only logged in through an external service? (uid:".filter_var($_GET['fail_auth_uid'], FILTER_SANITIZE_SPECIAL_CHARS).").";
    case 2: return "Invalid password.";
    case 3: return "Internal server error (your account has an invalid hash type).";
    case 4: return "You did everything right, but i failed to create a session for you ¯\_('')_/¯";
    case 5: return "User {$_GET['fail_auth_login_name']} created. You may now login :D";
    default: return "";
    }
}

function printNav(){
    global $logged_in, $display_name, $login_name, $is_admin;
    if(!isset($logged_in)){
        echo '<script>alert("Ignore this message. logged_in is null. you didnt call needUserInfo.");</script>';
    }
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
					<ul class="nav navbar-nav">'.
($logged_in ? '<li><a href="play_home.php"> Play </a> </li>
						<li><a href="classrooms_home.php"> Classrooms </a> </li>
						<li><a href="feedback.php"> Feedback </a> </li>' : '').
($is_admin ? '<li><a href="admin.php">Admin</a></li>' : '' ).'
					</ul>
					<ul class="nav navbar-nav navbar-right">
' . (($logged_in === FALSE) ? '<li><button class="btn btn-primary navbar-btn" data-toggle="modal" data-target="#loginModal">Login or Register</button></li>' :
     ("<li><a href=\"/profile.php?login_name=$login_name\">" . $display_name . '</a></li><li><a href="/logout.php">Logout</a></li>')) . '
					</ul>
				</div>
			</div>
</nav>
      <div class="modal fade" role="dialog" id="loginModal" style="background-color:rgba(240,240,240,0.8);">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<span class="modal-title">Login</span>
<button class="close" data-dismiss="modal">x</button>
</div>

<form action="auth_native.php" method="post" onsubmit="$(\'#login_name_field\')[0].value = $(\'#login_name_field\')[0].value.toLowerCase();">
<div class="modal-body">
<p style="color: #f00;">'. getLoginFailMsg() .'</p>
<input class="form-control" type="text" name="login_name" placeholder="Username" value="'.(isset($_GET['fail_auth_login_name']) ? filter_var($_GET['fail_auth_login_name'], FILTER_SANITIZE_SPECIAL_CHARS) : '').'"/><br/>
<input class="form-control" type="password" name="secret" placeholder="Password"/><br/>
<input class="form-control" type="hidden" name="callback" value="'.$_SERVER['REQUEST_URI'].'"></input>
</div>
<div class="modal-footer">

<input style="float:left;" class="btn btn-primary" type="submit" value="Login"/>
<button style="float:left;" class="btn btn-default" data-dismiss="modal">Cancel</button>
<br/><br/>
<a href="/register.php"><button type="button" style="float:left; margin-right:.5em;" class="btn btn-success">Register</button></a>
<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
</div>
</form>

</div>
</div>
</div>

'.(($logged_in === FALSE and isset($_GET['fail_auth_native_msgid']) and $_GET['fail_auth_native_msgid'] !== '') ? '<script>$("#loginModal").modal("show");</script>' : '').'

';
	}

$rootDomain = "www.chalkitup.online";
$protocol = "http://";
$root = $protocol . $rootDomain . "/";

$goHome = '<a href="'.$root.'">How about we get you Home.</a>';

$sqlCon = NULL;

function sql(){
    global $sqlCon;

    if(isset($sqlCon) and $sqlCon !== NULL){
        return;
    }

    $host = "/var/run/postgresql";
    $user = "postgres";
    $dbName = "postgres";
    $sqlCon = pg_connect("host=$host dbname=$dbName user=$user")
        or die ("Could not connect to sql server\n");   
}
function doneWithSql(){
    global $sqlCon;
    if(!isset($sqlCon) or $sqlCon === NULL){
        return;
    }
    pg_close($sqlCon);
    $sqlCon = NULL;
}
function runSql($name, $stmt, $args){
    global $sqlCon;
    //$res = pg_execute($sqlCon, $name, $args);
    //if($res === FALSE){
    //    pg_prepare($sqlCon, $name, $stmt);
    //        $res = pg_execute($sqlCon, $name, $args);
        //}
    $res = pg_query_params($sqlCon, $stmt, $args);
    return $res;
}
function runSql1( $name, $stmt, $args){
    $res = runSql($name, $stmt, $args);
    if($res === FALSE){
        return FALSE;
    }
    if(pg_num_rows($res) > 0){
        return pg_fetch_assoc($res, 0);
    }else{
        return FALSE;
    }
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
function delSession($sessionid){
    $good = runSql("del_session", 'DELETE FROM session_ WHERE sessionid = $1;', array($sessionid));    
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
function txStart(){
    runSql('tx_start', 'START TRANSACTION;', array());
}
function txCommit(){
    runSql('tx_commit', 'COMMIT;', array());
}
function txCancel(){
    runSql('tx_end', 'ROLLBACK;', array());
}

function multiple($i, $total){
    if($i == 0){
        return '';
    }else if($i == $total - 1){
        if($i > 0){
            return ', and ';
        }else{
            return ' and ';
        }
    }else{
        return ', ';
    }
}

#by mpyw from https://gist.github.com/johanmeiring/2894568#gistcomment-1586957
if(!function_exists('str_putcsv')){
    function str_putcsv($input, $delimiter = ',', $enclosure = '"') {
        $fp = fopen('php://temp', 'r+b');
        fputcsv($fp, $input, $delimiter, $enclosure);
        rewind($fp);
        $data = rtrim(stream_get_contents($fp), "\n");
        fclose($fp);
        return $data;
    }
                                           }
function san($x){
    return filter_var($x, FILTER_SANITIZE_SPECIAL_CHARS);
}

function htmlId($name){
    $id = base64_encode(random_bytes(16));
    $id = substr($id, 0, 22);
    $id = str_replace('/', 'q', $id);
    $id = str_replace('+', 'Q', $id);
    return $name.$id;
}
function userSelectionInput($name, $friendly_name){
    $select_id = htmlId('select_user_');
    $id = htmlId('hidden_form_');
    $a = htmlId('_');

    $js_submit = htmlId('search_submit_');
    $select_change = htmlId('select_change_');
    echo "<input type='hidden' name='$name' id='$id'/><span id='user_select_show$a'></span><button type='button' onclick='$js_submit();' class='btn btn-default' data-toggle='modal' data-target='#user_select_modal_$a'>Select $friendly_name</button>";
    
    $login_name_id = htmlId('login_name_');
    $display_name_id = htmlId('dsiplay_name_');
    $search_id = htmlId('search_');
    $submit_button = htmlId('submit_');

    echo "<script>
var lastType$a = '';
var users$a = '';
var lastChange$a = 0;
var lastSearchText$a = '';
function $js_submit(fuhreal){
function disableOption(msg){
$select_change();
$('#$select_id')[0].innerHTML = '<option disabled>'+msg+'</option>';
}
function updateSelect(){
var sel = $('#$select_id')[0];
sel.innerHTML = '';
for(var i = 0; i < users$a.length; i++){
if(users{$a}[i] == null){continue;}//necessary, unsure why...
sel.innerHTML += '<option>'+(i+1)+'. '+users{$a}[i].login_name+' '+users{$a}[i].display_name+' '+users{$a}[i].uid+'</option>';
}
sel.selectedIndex = 0;
$select_change();
if(users$a.length == 0){
disableOption('No results.');
}
}

var type = $('#$login_name_id')[0].checked ? 'login_name' : 'display_name';
var search = $('#$search_id')[0].value.toLowerCase();
if(search.length < 3){
disableOption('Enter at least 3 characters');
}else{
disableOption('Waiting...');
if(!fuhreal && lastSearchText$a !== search){
lastChange$a = new Date().getTime();
setTimeout(function(){ $js_submit(true);}, 500);
return;
}
if((lastSearchText$a == search &&  lastType$a == type) || new Date().getTime() - lastChange$a < 400){
if(lastSearchText$a == search){
updateSelect();
}
return;
}
lastType$a = type;
lastSearchText$a = search;
disableOption('Loading...');

var searchObj = type == 'login_name' ? {login_name : search} : {display_name : search};
$.post('search_users.php', searchObj, function(data, status){
if(status != 'success'){
disableOption('Request failed.');
alert('Search request failed. Are you still connected to the inernet? ('+status+')');
return;}

disableOption('Parsing...');

var num = parseInt(data);
users$a = [];
var index = data.indexOf(',')+1;
for(var i = 0; i < num; i++){
var next = data.indexOf(',', index);
var _uid = data.substring(index, next);
index = next+1;
next = data.indexOf(',', index);
var _login_name = data.substring(index, next);
index = next+1;
next = data.indexOf('\\n', index);
var _display_name = data.substring(index, next);
index = next+2;
users{$a}[users$a.length+1] = {uid: _uid,
login_name: _login_name,
display_name: _display_name};
}
if(type == 'login_name'){
users$a.sort(function(x, y){return x.login_name.compareTo(y.login_name)});
}else{
users$a.sort(function(x, y){return x.display_name.compareTo(y.display_name)});
}

updateSelect();
    });

}
}
var selected$a = null;
function $select_change(){
var sel = $('#$select_id')[0];
selected$a = [].slice.call(sel.options).filter(function(x){return x.selected;});
selected$a = selected$a.map(function(x){return users{$a}[parseInt(x.value)-1];});
$('#$submit_button')[0].disabled = selected$a.length == 0;
var show = $('#user_select_show$a')[0];
var val = $('#$id')[0];
show.textContent = '';
val.value = '';
for(var i = 0; i < selected$a.length; i++){
show.textContent += (i == 0 ? '' : ', ') + selected{$a}[i].display_name;
val.value += (i == 0 ? '' : ', ') + selected{$a}[i].uid;
}
}

</script>";

    return '
<div class="modal face" role="dialog" id="user_select_modal_'.$a.'">
<div class="modal-dialog">
<div class="modal-content">

<div class="modal-header">
<span class="modal-title">Select '.$friendly_name.'</span>
<button class="close" data-dismiss="modal">x</button>
</div>

<div class="modal-body">
Search by: <br/>
<input type="radio" name="type" value="login_name" onchange="'.$js_submit.'()" id="'.$login_name_id.'" checked/><label for="'.$login_name_id.'"> Login Name</label><br/>
<input type="radio" name="type" value="display_name" onchange="'.$js_submit.'()" id="'.$display_name_id.'"/><label for="'.$display_name_id.'"> Display Name</label><br/>
Search: <input type="text" name="search" oninput="'.$js_submit.'()" id="'.$search_id.'" placeholder="Search Users"/>
<select multiple class="form-control" id="'.$select_id.'" onchange="'.$select_change.'()">
<option disabled>Search</a>
</select>

</div>
<div class="modal-footer">

<button style="float:left;" class="btn btn-primary" id="'.$submit_button.'" data-dismiss="modal" disabled>Select</button>
<button style="float:left;" class="btn btn-default" data-dismiss="modal" onclick=\'selected'.$a.' = null; $("#'.$id.'")[0].value = null; $("#user_select_show'.$a.'")[0].textContent="";\'>Cancel</button>
</div>

</div>
</div>
</div>';
}
function truncate_string($string, $max){
	if(strlen($string)>$max){
		$string = substr($string,0,$max)."...";
	}
	return $string;
}


#function cleanSessions(){
#    $old = runSql("get_old_sessions", 'SELECT sessionid FROM session_ WHERE start_time < $1;', array(time() - 10));

