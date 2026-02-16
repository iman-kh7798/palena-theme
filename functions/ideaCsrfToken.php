<?php

if (!function_exists('idea_csrf_create')){
	function idea_csrf_create(){
		$newIdeaCsrfToken=ideaCreateNewCsrfToken();
		$_SESSION['idea_csrf'] = $newIdeaCsrfToken;
		return $newIdeaCsrfToken;
	}
}
if (!function_exists('idea_csrf_create2')){
	function idea_csrf_create2(){
		$newIdeaCsrfToken=ideaCreateNewCsrfToken2();
		$_SESSION['idea_csrf2'] = $newIdeaCsrfToken;
		return $newIdeaCsrfToken;
	}
}
if (!function_exists('idea_session_start')){
	function idea_session_start() {
		if(!session_id()) {
			session_start();
		}
	}
	add_action('init', 'idea_session_start', 1);
}
if (!function_exists('idea_session_start2')){
	function idea_session_start2() {
		if(!session_id()) {
			session_start();
		}
	}
	add_action('init', 'idea_session_start2', 1);
}


if (!function_exists('ideaCreateNewCsrfToken')){
	function ideaCreateNewCsrfToken($len=100){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < $len; $i++) {
			$randstring.= $characters[rand(0, strlen($characters)-1)];
		}
		return $randstring;
	}
}
if (!function_exists('ideaCreateNewCsrfToken2')){
	function ideaCreateNewCsrfToken2($len=100){
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < $len; $i++) {
			$randstring.= $characters[rand(0, strlen($characters)-1)];
		}
		return $randstring;
	}
}

if (!function_exists('getIdeaCsrfToken')){
	function getIdeaCsrfToken(){
		if (isset($_SESSION['idea_csrf']) && !empty($_SESSION['idea_csrf']) && $_SESSION['idea_csrf'] != null){
			return $_SESSION['idea_csrf'];
		}else{
			return idea_csrf_create();
		}
	}
}
if (!function_exists('getIdeaCsrfToken2')){
	function getIdeaCsrfToken2(){
		if (isset($_SESSION['idea_csrf2']) && !empty($_SESSION['idea_csrf2']) && $_SESSION['idea_csrf2'] != null){
			return $_SESSION['idea_csrf2'];
		}else{
			return idea_csrf_create2();
		}
	}
}

if(!function_exists('theIdeaCsrfField')){
	function theIdeaCsrfField(){
		echo "<input type='hidden' autocomplete='off' name='ideaCsrfField' value='".getIdeaCsrfToken()."'>";
	}
}
if(!function_exists('theIdeaCsrfField2')){
	function theIdeaCsrfField2(){
		echo "<input type='hidden' autocomplete='off' name='ideaCsrfField2' value='".getIdeaCsrfToken2()."'>";
	}
}

if(!function_exists('ideaCsrfField')){
	function ideaCsrfField(){
		return "<input type='hidden' autocomplete='off' name='ideaCsrfField' value='".getIdeaCsrfToken()."'>";
	}
}
if(!function_exists('ideaCsrfField2')){
	function ideaCsrfField2(){
		return "<input type='hidden' autocomplete='off' name='ideaCsrfField2' value='".getIdeaCsrfToken2()."'>";
	}
}

if (!function_exists('verifyIdeaCsrf')){
	function verifyIdeaCsrf(){
		if (isset($_REQUEST['ideaCsrfField']) && !empty($_REQUEST['ideaCsrfField']) && $_REQUEST['ideaCsrfField']==getIdeaCsrfToken()){
			return true;
		}
		return false;
	}
}
if (!function_exists('verifyIdeaCsrf2')){
	function verifyIdeaCsrf2(){
		if (isset($_REQUEST['ideaCsrfField2']) && !empty($_REQUEST['ideaCsrfField2']) && $_REQUEST['ideaCsrfField2']==getIdeaCsrfToken2()){
			return true;
		}
		return false;
	}
}

