<?php
$CI =& get_instance();

$uid = $CI->authlib->getUserId();
if($uid != "") {
?>
				<ul class="menu_top">
					<li><a href="/index.php">Home</a></li>
					<li><a href="/index.php/user/profile/<?=$uid?>">My Profile</a></li>
					<?php /*<li><a href="/forum">Forum</a></li> */ ?>
					<li><a href="/index.php/info/faq">Help & Support</a></li>
					<li><a href="/index.php/info/contactus">Contact us</a></li>
				</ul>
<?php
} else {
?>
				<ul class="menu_top">
					<li><a href="/index.php">Home</a></li>
					<li><a href="/index.php/auth/register">Sign up</a></li>
					<li><a href="/index.php/auth">Login</a></li>
					<li><a href="/index.php/info/faq">Help & Support</a></li>
					<li><a href="/index.php/info/contactus">Contact us</a></li>
				</ul>
<?php
}
?>
