<?php
/**
 * @package Installer
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: 
 */
?>

<?php require(DIR_FS_INSTALL . DIR_WS_INSTALL_TEMPLATE . 'partials/partial_modal_help.php'); ?>

<form class="form-horizontal" id="admin_setup" name="db_setup" method="post" action="index.php?main_page=completion">
  <input type="hidden" name="action" value="process" >
  <?php foreach ($_POST as $key=>$value) {  ?>
    <?php if ($key != 'action') { ?>
    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>" >
    <?php }?>
  <?php }?>
  <fieldset>
    <legend><?php echo TEXT_ADMIN_SETUP_USER_SETTINGS; ?></legend>
    <div class="row">
      <div class="three columns">
        <label class="inline" for="admin_user"><a href="#" class="hasHelpText" id="ADMINUSER"><?php echo TEXT_ADMIN_SETUP_USER_NAME; ?></a></label>
      </div>
      <div class="six columns end">
        <input type="text" name="admin_user" id="admin_user" value="" >
      </div>
    </div>
    <div class="row">
      <div class="three columns">
        <label class="inline" for="admin_email"><a href="#" class="hasHelpText" id="ADMINEMAIL"><?php echo TEXT_ADMIN_SETUP_USER_EMAIL; ?></a></label>
      </div>
      <div class="six columns end">
        <input type="text" name="admin_email" id="admin_email" value="" >
      </div>
    </div>
    <div class="row">
      <div class="three columns">
        <label class="inline" for="admin_password"><a href="#" class="hasHelpText" id="ADMINPASSWORD"><?php echo TEXT_ADMIN_SETUP_USER_PASSWORD; ?></a></label>
      </div>
      <div class="six columns end">
        <input type="text" name="admin_password" id="admin_password" value="<?php echo $admin_password; ?>" readonly="readonly">
      </div>
    </div>
    <div class="row">
      <div class="alert-box"><?php echo TEXT_ADMIN_SETUP_USER_PASSWORD_HELP; ?></div>
    </div>
    <div class="row">
      <div class="three columns">
        <label class="inline" for="admin_directory"><a href="#" class="hasHelpText" id="ADMINDIRECTORY"><?php echo TEXT_ADMIN_SETUP_ADMIN_DIRECTORY; ?></a></label>
      </div>
      <div class="six columns end">
        <input type="text" name="admin_directory" id="admin_directory" value="<?php echo $adminNewDir; ?>" readonly="readonly">
      </div>
    </div>
    <div class="row">
      <?php if ($adminNewDir == $adminDir && $adminDir != 'admin') { ?>
      <div class="alert-box alert"><?php echo TEXT_ADMIN_SETUP_ADMIN_DIRECTORY_HELP_NOT_ADMIN_CHANGED; ?></div>
      <?php } elseif ($adminNewDir == $adminDir) { ?>
      <div class="alert-box alert"><?php echo TEXT_ADMIN_SETUP_ADMIN_DIRECTORY_HELP_DEFAULT; ?></div>
      <?php } else { ?>
      <div class="alert-box "><?php echo TEXT_ADMIN_SETUP_ADMIN_DIRECTORY_HELP_CHANGED; ?></div>
      <?php }?>
    </div>
  </fieldset>
  <input class="radius button" type="submit" id="btnsubmit" name="btnsubmit" value="<?php echo TEXT_CONTINUE; ?>">
</form>

<script>
$().ready(function() {
  $("#admin_setup").validate({
    submitHandler: function(form) {
      form.submit();
    },
    rules: {
      admin_user: "required",
      admin_email: "required",	      
    },
    messages: {
    }
  }); 
});
$(function() 
		{
		  $('.hasNoHelpText').click(function(e) 
		  {   
			  e.preventDefault(); 
		  })
		  $('.hasHelpText').click(function(e) 
			{
			  var textId = $(this).attr('id');
		    $.ajax({
		    	type: "POST",
		     	timeout: 100000,
			    dataType: "json",
			    data: 'id='+textId,
		      url: '<?php echo "ajaxGetHelpText.php"; ?>',
			   	success: function(data) {
		     	  $('#modal-help-title').html(data.title);
			     	$('#modal-help-content').html(data.text);
			       $('#modal-help').reveal();
		      }
		    });
			  e.preventDefault(); 
		  })  
		});
</script>