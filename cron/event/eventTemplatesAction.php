<?php

$action = array();

// All Arguments Here
$action[1][1] = array(
'Title' => 'Accept Request',
'Icon' => 'accept',
'Event' => 'addPatient(%PATIENT%, \'%MONEY%\')',
'Text' => 'The Patient was cured successfully.');
$action[1][2] = array(
'Title' => 'Ignore Request',
'Icon' => 'delete',
'Event' => 'doNothing()',
'Text' => 'You\'ve ignored the request.');

$action[2][1] = array();
$action[2][2] = array();

$action[3][1] = array(
'Title' => 'Accept Request',
'Icon' => 'accept',
'Event' => 'addMoney(%MONEY%, \'15\')',
'Text' => 'The mayor enjoyed the visit. Thank you for letting him see your awesome hospital!');
$action[3][2] = array(
'Title' => 'Ignore Request',
'Icon' => 'delete',
'Event' => 'doNothing()',
'Text' => 'You\'ve ignored the request.');

$action[4][1] = array(
'Title' => 'See Report',
'Icon' => 'report',
'Event' => 'doNothing()',
'Text' => 'The report concluded that your Hospital was in <u>Perfect</u> Condition.');

$action[5][1] = array(
'Title' => 'See Report',
'Icon' => 'report',
'Event' => 'addMoney(50000, \'15\')',
'Text' => 'The report concluded that your Hospital was in <u>Horrible</u> Condition. To help you get back on your feet here is some money. Please expand your Hospital!');

$action[6][1] = array(
'Title' => 'Slack tongue Clinic',
'Icon' => 'building_go',
'Event' => 'addPatient(1, \'%MONEY%\')',
'Text' => 'The Patient was cured! Well done!');
$action[6][2] = array(
'Title' => 'Psychiatric',
'Icon' => 'building_go',
'Event' => 'doNothing()',
'Text' => 'Sorry! Thats wrong.');
$action[6][3] = array(
'Title' => 'DNA Changer',
'Icon' => 'building_go',
'Event' => 'doNothing()',
'Text' => 'Sorry! Thats wrong.');



$action[7][1] = array(
'Title' => 'Accept Request',
'Icon' => 'accept',
'Event' => 'removeMoney(%MONEY%, \'14\')',
"Random" => array(
	"From" => 	"0",
	"To" => 	"100",
	"LessThan" => 	"64",
	"MoreThan" => 	"1",
	"PositiveEvent" => "addPatient(1, '%MONEY%)",
	"NegativeEvent" => "removeMoney(%MONEY%, '14')",
	"PositiveMessage" => "You succeeded and earned %MONEY%",
	"NegativeMessage" => "The Patient was cured..sort of...he started to grow a third arm...You\'ve got to pay to get that removed!"
),
'Text' => '');
$action[7][2] = array(
'Title' => 'Ignore Request',
'Icon' => 'delete',
'Event' => 'doNothing()',
'Text' => 'You\'ve ignored the request.');

$action[8][1] = array(
'Title' => 'Accept Request',
'Icon' => 'accept',
'Event' => 'removeMoney(%MONEY%, \'15\')',
'Text' => 'The mayor thought your Hospital was horrible. You better watch out or he might get it closed!');
$action[8][2] = array(
'Title' => 'Ignore Request',
'Icon' => 'delete',
'Event' => 'doNothing()',
'Text' => 'You\'ve ignored the request.');


$action[9][1] = array(
'Title' => 'Psychiatric',
'Icon' => 'building_go',
'Event' => 'addPatient(1, \'%MONEY%\')',
'Text' => 'The Patient was cured! Well done!');
$action[9][2] = array(
'Title' => 'Ward',
'Icon' => 'building_go',
'Event' => 'doNothing()',
'Text' => 'Sorry! Thats wrong.');
$action[9][3] = array(
'Title' => 'DNA Changer',
'Icon' => 'building_go',
'Event' => 'doNothing()',
'Text' => 'Sorry! Thats wrong.');


$action[10][1] = array(
'Title' => "Try to cure him!", 
"Icon" => "patient_red", 
"Event" => "random",
"Text" => "",
"Random" => array(
	"From" => 	"0",
	"To" => 	"100",
	"LessThan" => 	"43",
	"MoreThan" => 	"1",
	"PositiveEvent" => "addPatient(1, '%MONEY%')",
	"NegativeEvent" => "removeMoney(%MONEY%, '14')",
	"PositiveMessage" => "You succeeded and earned %MONEY%",
	"NegativeMessage" => "You failed and had to pay %MONEY% in pentaly"
)
);
$action[10][2] = array(
"Title" => "Skip the challenge",
"Icon" => "delete",
"Event" => "removeMoney(10000, '14')",
"Text" => "You skipped the challenge"
);

$action[11][1] = array(
'Title' => "Try to cure him!", 
"Icon" => "patient_red", 
"Event" => "random",
"Text" => "",
"Random" => array(
	"From" => 	"0",
	"To" => 	"100",
	"LessThan" => 	"22",
	"MoreThan" => 	"1",
	"PositiveEvent" => "addPatient(1, '%MONEY%')",
	"NegativeEvent" => "removeMoney(10000, '14')",
	"PositiveMessage" => "You succeeded and earned %MONEY%",
	"NegativeMessage" => "You failed and had to pay 10 000 in pentaly"
)
);

$action[11][2] = array(
"Title" => "Skip the challenge",
"Icon" => "delete",
"Event" => "removeMoney(10000, '14')",
"Text" => "You skipped the challenge"
);
