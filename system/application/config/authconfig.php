<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| auth
|--------------------------------------------------------------------------
|
| 'auth' = TRUE/FALSE (boolean).  Whether the auth system is turned on.
|
| 'auth_model' = The name of the model.
|
| 'auth_user_table_name' = The name of the table that stores user information.
|
| 'auth_user_id_field' = The name of the primary key field.
| 'auth_user_name_field' = The name of the user name field.
| 'auth_user_display_name_field' = The name of the user display name field.
| 'auth_user_password_field' = The name of the password field.
| 'auth_user_password_confirm_field' = The name of the password confirmation field (not stored in database).
| 'auth_user_email_field' = The name of the email field.
| 'auth_user_autologin_field' = The name of the autlogin field (not stored in database).
| 'auth_user_security_code_field' = The name of the security code field (not stored in database).
| 'auth_user_last_visit_field' = The name of the last visited field.
| 'auth_user_created_field' = The name of the created date field.
| 'auth_user_modified_field' = The name of the modified date field.
| 'auth_user_activated_field' = The name of the is activated field.
| 'auth_user_activation_code_field' = The name of the activation code field.
| 'auth_user_forgotten_password_code_field' = The name of the forgotten password field.
| 'auth_user_country_field' = The name of the country key field.
|
| 'auth_use_country' = Whether to use country listing.
| 'auth_country_table_name' = The name of the table that stores country information.
|
| 'auth_country_id_field' = The name of the primary key field.
| 'auth_country_name_field' = The name of the country name field.
|
| 'auth_user_name_field_validation_login' = Validation rules for the login form's name field.
| 'auth_user_password_field_validation_login' = Validation rules for the login form's password field.
|
| 'auth_user_name_field_validation_register' = Validation rules for the registeration form's name field.
| 'auth_user_password_field_validation_register' = Validation rules for the registeration form's password field.
| 'auth_user_password_confirm_field_validation_register' = Validation rules for the registeration form's password confirm field.
| 'auth_user_email_field_validation_register' = Validation rules for the registeration form's email field.
| 'auth_user_security_code_field_validation_register' = Validation rules for the registeration form's security code field.
| 'auth_user_country_field_validation_register' = Validation rules for the registeration form's country field.
|
| 'auth_login_view' = The view to display the login form.
| 'auth_register_view' = The view to display the user registration form.
| 'auth_register_success_view' = The view to display the successful registration information.
| 'auth_register_activation_success_view' = The view to display the successful activation information.
| 'auth_register_activation_failed_view' = The view to display the failed activation information.
| 'auth_forgotten_password_view' = The view to display the forgotten password form.
| 'auth_forgotten_password_success_view' = The view to display the successful forgotten password request.
| 'auth_forgotten_password_reset_success_view' = The view to display the successful forgotten password reset.
| 'auth_forgotten_password_reset_failed_view' = The view to display the failed forgotten password reset.
|
| 'auth_login_success_action' = The action to execute upon successful login.
| 'auth_logout_success_action' = The action to execute upon successful logout.
| 'auth_home_action' = The action that display the homepage of the application.
|
| 'auth_error_delimiter_open' = Open tag for the validation error messages.
| 'auth_error_delimiter_close' = Close tag for the validation error messages.
|
| 'auth_activation_email' = The location of the activation email.
| 'auth_forgotten_password_email' = The location of the forgotten password email.
| 'auth_forgotten_password_reset_email' = The location of the forgotten password reset email.
|
| 'auth_user_name_min' = Minimum user name length.
| 'auth_user_name_max' = Maximum user name length.
|
| 'auth_user_password_min' = Minimum password length.
| 'auth_user_password_max' = Maximum password length.
|
| 'auth_use_security_code' = Whether to use the security code functionality.
| 'auth_security_code_min' = Minimum security code length.
| 'auth_security_code_max' = Maximum security code length.
| 'auth_security_code_font_size' = Security code font size.
| 'auth_security_code_image_font' = Location of the font for the security code.
| 'auth_security_code_image_font_size' = Font size of the security code.
| 'auth_security_code_image_font_color' = Color of the security code.
| 'auth_security_code_image_base_image'] = Base image name for the security code.
| 'auth_security_code_image_path'] = Folder to save the security code image to; should be relative to the folder in which the index.php resides.
|
| 'auth_auto_login_period' = Time (in seconds) from now that the autologin cookie remains valid.
|
*/
$config['auth'] = TRUE;

$config['smf_database'] = "admin_smf";

$config['auth_model'] = 'auth_model';

$config['auth_user_table_name'] = 'user';

$config['auth_user_id_field'] = 'id';
$config['auth_user_name_field'] = 'user_name';
$config['auth_user_display_name_field'] = 'user_name';
$config['auth_user_password_field'] = 'password';
$config['auth_user_password_confirm_field'] = 'password_confirm';
$config['auth_user_email_field'] = 'email';
$config['auth_user_autologin_field'] = 'auto_login';
$config['auth_user_security_code_field'] = 'security';
$config['auth_user_last_visit_field'] = 'last_visit';
$config['auth_user_created_field'] = 'create';
$config['auth_user_modified_field'] = 'modified';
$config['auth_user_activated_field'] = 'activated';
$config['auth_user_activation_code_field'] = 'activation_code';
$config['auth_user_forgotten_password_code_field'] = 'forgotten_password_code';
$config['auth_user_country_field'] = 'country_id';
$config['auth_user_security_role_field'] = 'security_role_id';

$config['auth_use_country'] = TRUE;
$config['auth_country_table_name'] = 'country';

$config['auth_country_id_field'] = 'id';
$config['auth_country_name_field'] = 'name';

$config['auth_security_roles'] = TRUE;
$config['auth_security_role_table_name'] = 'security_role';
$config['auth_security_permission_table_name'] = 'security_permission';
$config['auth_security_role_permission_table_name'] = 'security_role_permission';

$config['auth_security_role_id_field'] = 'id';
$config['auth_security_role_name_field'] = 'name';

$config['auth_security_permission_id_field'] = 'id';
$config['auth_security_permission_name_field'] = 'name';

$config['auth_security_role_permission_id_field'] = 'id';
$config['auth_security_role_permission_role_id_field'] = 'security_role_id';
$config['auth_security_role_permission_permission_id_field'] = 'security_permission_id';

$config['auth_dropdown_validation'] = 'trim|required|xss_clean';
$config['auth_email_validation'] = 'trim|required|valid_email|xss_clean';
$config['auth_password_validation'] = 'trim|xss_clean|callback_password_check';
$config['auth_password_confirm_validation'] = 'trim|xss_clean|matches[%s]';
$config['auth_password_required_validation'] = 'trim|required|xss_clean|callback_password_check';
$config['auth_password_required_confirm_validation'] = 'trim|required|xss_clean';
$config['auth_text_validation'] = 'trim|xss_clean';
$config['auth_text_required_validation'] = 'trim|required|xss_clean';
$config['auth_user_name_validation'] = 'trim|required|xss_clean|callback_username_check';
$config['auth_user_name_duplicate_validation'] = $config['auth_user_name_validation'].'|callback_username_duplicate_check';

$config['auth_user_name_field_validation_login'] = $config['auth_text_required_validation'];
$config['auth_user_password_field_validation_login'] = $config['auth_password_required_validation'];

$config['auth_user_name_field_validation_register'] = $config['auth_user_name_duplicate_validation'];
$config['auth_user_password_field_validation_register'] = $config['auth_password_required_validation'];
$config['auth_user_password_confirm_field_validation_register'] = $config['auth_password_required_confirm_validation'];
$config['auth_user_email_field_validation_register'] = $config['auth_email_validation'];
$config['auth_user_security_code_field_validation_register'] = 'trim|required|xss_clean|callback_securitycode_check';
$config['auth_user_country_field_validation_register'] = $config['auth_dropdown_validation'];

$config['auth_user_email_field_validation_forgotten_password'] = $config['auth_password_required_validation'];

$config['auth_login_view'] = 'auth/login';
$config['auth_register_view'] = 'auth/register';
$config['auth_register_success_view'] = 'auth/register_success';
$config['auth_register_activation_success_view'] = 'auth/activation_success';
$config['auth_register_activation_failed_view'] = 'auth/activation_failed';
$config['auth_forgotten_password_view'] = 'auth/forgotten_password';
$config['auth_forgotten_password_success_view'] = 'auth/forgotten_password_success';
$config['auth_forgotten_password_reset_success_view'] = 'auth/forgotten_password_reset_success';
$config['auth_forgotten_password_reset_failed_view'] = 'auth/forgotten_password_reset_failed';

$config['auth_login_success_action'] = 'overview';
$config['auth_logout_success_action'] = 'front';
$config['auth_home_action'] = '';

$config['auth_error_delimiter_open'] = '<div class="error_message">';
$config['auth_error_delimiter_close'] = '</div>';

$config['auth_activation_email'] = 'auth/activation_email';
$config['auth_forgotten_password_email'] = 'auth/forgotten_password_email';
$config['auth_forgotten_password_reset_email'] = 'auth/forgotten_password_reset_email';

$config['auth_user_name_min'] = 4;
$config['auth_user_name_max'] = 16;

$config['auth_user_password_min'] = 6;
$config['auth_user_password_max'] = 16;

$config['auth_use_security_code'] = FALSE;
$config['auth_security_code_min'] = 5;
$config['auth_security_code_max'] = 5;
$config['auth_security_code_image_font'] = 'C:/WINDOWS/Fonts/tahoma.ttf';
$config['auth_security_code_image_font_size'] = 32;
$config['auth_security_code_image_font_color'] = 'AAAAAA';
$config['auth_security_code_image_base_image'] = 'security.jpg';
$config['auth_security_code_image_path'] = 'media';

$config['auth_auto_login_period'] = '1209600';

?>
