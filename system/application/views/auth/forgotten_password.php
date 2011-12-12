<div style="width: 500px; margin-left: auto; margin-right: auto;">
<h2>Forgotten Password</h2>
<?=form_open('auth/forgotten_password')?>
	<p><label><span><?=$this->lang->line('sentry_user_email_label')?>: </span>
	<?=form_input(array('name'=>$this->config->item('auth_user_email_field'), 
	                       'id'=>$this->config->item('auth_user_email_field'),
	                       'maxlength'=>'100', 
	                       'size'=>'60',
	                       'value'=>(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field')} : '')))?>
    </label><span><?=(isset($this->validation) ? $this->validation->{$this->config->item('auth_user_email_field').'_error'} : '')?></span></p>
    <p><label>
	<div align="center">
	<?=form_submit(array('name'=>'forgotten_password', 
	                     'id'=>'forgotten_password', 
	                     'value'=>$this->lang->line('sentry_submit_label'), "class" => "inputSubmit"))?>
    </label></p>
	</div>
<?=form_close()?>
</div>
