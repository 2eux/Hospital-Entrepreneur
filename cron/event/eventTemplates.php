<?php
/* List of Event Templates */
include('eventTemplatesText.php');
include('eventTemplatesAction.php');

global $text, $action, $templates;

$templates = array();

$templates[] = array(
'type' => 'Emergency',
'icon' => 'exclamation',
'title' => 'Emergency on %RANDOM_USER_ALIAS%',
'from' => '%RANDOM_USER%',
'fromuid' => '%RANDOM_USER_ID%',
'content' => $text[1],
'action1' => $action[1][1],
'action2' => $action[1][2]
);

$templates[] = array(
'type' => 'Emergency',
'icon' => 'exclamation',
'title' => 'Emergency on %RANDOM_USER_ALIAS%',
'from' => '%RANDOM_USER%',
'fromuid' => '%RANDOM_USER_ID%',
'content' => $text[1],
'action1' => $action[1][1],
'action2' => $action[1][2]
);
$templates[] = array(
'type' => 'Emergency',
'icon' => 'exclamation',
'title' => 'Emergency on %RANDOM_USER_ALIAS%',
'from' => '%RANDOM_USER%',
'fromuid' => '%RANDOM_USER_ID%',
'content' => $text[1],
'action1' => $action[7][1],
'action2' => $action[7][2]
);
$templates[] = array(
'type' => 'Emergency',
'icon' => 'exclamation',
'title' => 'Emergency on %RANDOM_USER_ALIAS%',
'from' => '%RANDOM_USER%',
'fromuid' => '%RANDOM_USER_ID%',
'content' => $text[1],
'action1' => $action[7][1],
'action2' => $action[7][2]
);
/* Disabled for now 
$templates[] = array(
'type' => 'Payrise',
'icon' => 'user_add',
'title' => '%DOCTOR% is requesting payrise',
'from' => 'Board of Directors',
'fromuid' => '0',
'content' => $text[2]
); */

$templates[] = array(
'type' => 'VIP Visit',
'icon' => 'shield',
'title' => 'The Mayor wants to visit',
'from' => 'City Council',
'fromuid' => '0',
'content' => $text[3],
'action1' => $action[3][1],
'action2' => $action[3][2]
);
$templates[] = array(
'type' => 'VIP Visit',
'icon' => 'shield',
'title' => 'The major wants to visit',
'from' => 'City Council',
'fromuid' => '0',
'content' => $text[3],
'action1' => $action[8][1],
'action2' => $action[8][2]
);
// Positive Outcome
$templates[] = array(
'type' => 'VIP Visit',
'icon' => 'shield',
'title' => 'The National Health Service is visiting your Hospital',
'from' => 'NHS',
'fromuid' => '0',
'content' => $text[4],
'action1' => $action[4][1]
);
$templates[] = array(
'type' => 'VIP Visit',
'icon' => 'shield',
'title' => 'The National Health Service is visiting your Hospital',
'from' => 'NHS',
'fromuid' => '0',
'content' => $text[4],
'action1' => $action[4][1]
);
// Negative Outcome
$templates[] = array(
'type' => 'VIP Visit',
'icon' => 'shield',
'title' => 'The National Health Service is visiting your Hospital',
'from' => 'NHS',
'fromuid' => '0',
'content' => $text[4],
'action1' => $action[5][1]
);

$templates[] = array(
'type' => 'Patient',
'icon' => 'user_red',
'title' => 'Action required! Help to save this mans life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[5],
'action1' => $action[6][1],
'action2' => $action[6][2],
'action3' => $action[6][3]
);

$templates[] = array(
'type' => 'Patient',
'icon' => 'user_red',
'title' => 'Action required! Help to save this mans life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[5],
'action1' => $action[6][1],
'action2' => $action[6][2],
'action3' => $action[6][3]
);

$templates[] = array(
'type' => 'Patient',
'icon' => 'user_woman',
'title' => 'Action required! Help to save this womans life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[6],
'action1' => $action[9][2],
'action2' => $action[9][1],
'action3' => $action[9][3]
);
$templates[] = array(
'type' => 'Patient',
'icon' => 'user_woman',
'title' => 'Action required! Help to save this womans life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[6],
'action1' => $action[9][2],
'action2' => $action[9][1],
'action3' => $action[9][3]
);

$templates[] = array(
'type' => 'Patient',
'icon' => 'user_red',
'title' => 'Action required! Help to save this patients life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[10],
'action1' => $action[10][2],
'action2' => $action[10][1],
'action3' => $action[10][3]
);
$templates[] = array(
'type' => 'Patient',
'icon' => 'user_red',
'title' => 'Action required! Help to save this patients life!',
'from' => '%USER_ALIAS%',
'fromuid' => '%UID%',
'content' => $text[11],
'action1' => $action[11][2],
'action2' => $action[11][1],
'action3' => $action[11][3]
);
