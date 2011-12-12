<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
$hook['display_override'][] = array('class'    => 'Yield',
                                    'function' => 'doYield',
                                    'filename' => 'Yield.php',
                                    'filepath' => 'hooks'
                                   ); 
$hook['pre_controller'][] = array(
                                'class'    => 'Auth_filter',
                                'function' => 'before',
                                'filename' => 'Auth.php',
                                'filepath' => 'hooks'
                                );
/*
$hook['post_controller'] = array(
								'class'    => 'resourceHandler',
								'function' => 'parse',
								'filename' => 'resourceHandler.php',
								'filepath' => 'hooks'
);
*/
/* End of file hooks.php */
/* Location: ./system/application/config/hooks.php */
