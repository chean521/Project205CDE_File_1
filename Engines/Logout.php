<?php

require_once('SessionManager/SessionManager.php');

$sess = new SessionManager();

$sess->remove_session();
$sess->destruct_Session();

header('Location: ../');
exit();