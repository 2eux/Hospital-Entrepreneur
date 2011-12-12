<style type="text/css">
select { height: 22px !important; width: 208px !important; }
</style>
<?=form_open('auth/register')?>
<fieldset>
<legend>Registration</legend>
<div class="required">
	<label for="<?=$this->config->item('auth_user_name_field')?>"><?=$this->lang->line('sentry_user_name_label')?>:</label>
	<?=form_input(array('name'=>$this->config->item('auth_user_name_field'), 
	                       'id'=>$this->config->item('auth_user_name_field'),
	                       'maxlength'=>'45', 
	                       'size'=>'45',
							'style' => 'width: 200px;',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field')} : '')))?>
    <span class="reg_error"><?php /* print_r($this->validation)n if(isset($this->validation)) { print("This username already exists in our database. Please try a different one."); } else { } */ ?></span>
</div>

<div class="required">
	<label for="user_alias">Hospital Name:</label>
	<?=form_input(array('name'=>"user_alias", 
	                       'id'=>"user_alias",
	                       'maxlength'=>'45', 
	                       'size'=>'45',
							'style' => 'width: 200px;',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_name_field')} : '')))?>
</div>

<div class="required">
	<label><span><?=$this->lang->line('sentry_user_password_label')?>: </span>
	</label><?=form_password(array('name'=>$this->config->item('auth_user_password_field'), 
	                       'id'=>$this->config->item('auth_user_password_field'),
	                       'maxlength'=>'16', 
	                       'size'=>'16',
							'style' => 'width: 200px;',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field')} : '')))?>
    <span class="reg_error"><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_field').'_error'} : '')?></span>
</div>
<div class="required">
    <label><span><?=$this->lang->line('sentry_user_password_confirm_label')?>: </span>
	</label><?=form_password(array('name'=>$this->config->item('auth_user_password_confirm_field'), 
	                       'id'=>$this->config->item('auth_user_password_confirm_field'),
	                       'maxlength'=>'16', 
	                       'size'=>'16',
							'style' => 'width: 200px;',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_confirm_field')} : '')))?>
    <span class="reg_error"><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_password_confirm_field').'_error'} : '')?></span>
</div>
<div class="required">
    <label><span><?=$this->lang->line('sentry_user_email_label')?>: </span>
	</label><?=form_input(array('name'=>$this->config->item('auth_user_email_field'), 
	                       'id'=>$this->config->item('auth_user_email_field'),
	                       'maxlength'=>'120', 
	                       'size'=>'60',
							'style' => 'width: 200px;',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field')} : '')))?>
    <span class="reg_error"><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span>
</div><?php
if ($this->config->item('auth_use_country'))
{?>    

<div class="required">
    <label><span><?=$this->lang->line('sentry_user_country_label')?>: </span>
	</label><?=form_dropdown($this->config->item('auth_user_country_field'),
	                 $countries,
	                 (isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field')} : 0))?>
    <span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span>
</div>
<?php
}
$buttonSubmit = $this->lang->line('sentry_register_label');
$buttonCancel = $this->lang->line('sentry_cancel_label');
$callConfirm = '';
if ($this->lang->line('sentry_terms_of_service_message') != '')
{
    $buttonSubmit = $this->lang->line('sentry_agree_label');
    $buttonCancel = $this->lang->line('sentry_donotagree_label');
    $callConfirm = 'confirmDecline();';
?>

<div class="normal">
	<label for="referee"><span>Referee:</span><br /><span style="color: #999;">If you were refereed by a friend put his name here</span></label>
	<input type="text" name="referee" value="" id="referee" />
</div>

</fieldset>
<fieldset><legend>Terms of Use</legend>

<textarea name='rules' class='textarea' rows='8' cols='50' style="width: 600px; height: 400px; margin-left: 50px;" readonly>
<?=$this->lang->line('sentry_terms_of_service_message')?>
</textarea>

</fieldset>

<fieldset>

<?php    
}?>
    <label>
	</label><?=form_submit(array('name'=>'register', 
	                     'id'=>'register', 
						 'class' => 'inputSubmit',
	                     'value'=>$buttonSubmit))?>
    
	<label>
	</label><?=form_submit(array('type'=>'button',
	                     'name'=>'cancel', 
	                     'id'=>'cancel', 
						 'class'=>'inputSubmit',
	                     'value'=>$buttonCancel,
	                     'onclick'=>$callConfirm))?>
   </div>
</fieldset>
<?=form_close()?>
<script language="JavaScript" type="text/javascript">
<!--
function confirmDecline() 
{
    if (confirm('<?=$this->lang->line('sentry_register_cancel_confirm')?>')) 
		location = '<?=site_url('auth/login')?>';
} 
//-->
</script>

