<?php
/**
 * @package Installer
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: zcwilt  Wed Sep 23 20:04:38 2015 +0100 Modified in v1.6.0 $
 */
?>
<?php require(DIR_FS_INSTALL . DIR_WS_INSTALL_TEMPLATE . 'partials/partial_modal_help.php'); ?>
<?php require(DIR_FS_INSTALL . DIR_WS_INSTALL_TEMPLATE . 'common/developer_mode_helper.php'); ?>

	<div align="center" class="alert-box success">
		<div align="center" class="showModal button warning radius" id="NGINXCONF">
			<h6><?php echo TEXT_COMPLETION_NGINX_TEXT; ?></h6>
		</div>
		<h5><font color="white">
		
<?php if ($isUpgrade) { ?>
		<?php echo TEXT_COMPLETION_UPGRADE_COMPLETE; ?>
<?php } else { ?>
		<?php echo TEXT_COMPLETION_INSTALL_COMPLETE; ?>
		
		<br>
	<?php if ($catalogLink != '#') echo TEXT_COMPLETION_INSTALL_LINKS_BELOW; ?>
<?php } ?>

		</font></h5>
<?php if (!$isUpgrade && $catalogLink != '#') { ?>

		<div align="center">
			<a class="radius button" href="<?php echo $adminLink; ?>" target="_blank" tabindex="1">
				<?php echo TEXT_COMPLETION_ADMIN_LINK_TEXT; ?>:
				
				<br><br>
				<u><?php echo $adminLink; ?></u>
			</a>
			<a class="radius button" href="<?php echo $catalogLink; ?>" target="_blank" tabindex="2">
				<?php echo TEXT_COMPLETION_CATALOG_LINK_TEXT; ?>:
				
				<br><br>
				<u><?php echo $catalogLink; ?></u>
			</a>
		</div>
<?php } ?>

<?php if ($adminDir == 'admin' && !defined('DEVELOPER_MODE')) { ?>
		<br><br>
		<div class="alert-box  secondary">
			<h6><?php echo TEXT_COMPLETION_ADMIN_DIRECTORY_WARNING; ?></h6>
		</div>
		<br>
<?php } ?>
<?php if (file_exists(DIR_FS_INSTALL) && !defined('DEVELOPER_MODE')) { ?>

		<br>
		<div class="alert-box  secondary">
			<h6><?php echo TEXT_COMPLETION_INSTALLATION_DIRECTORY_WARNING; ?></h6>
			<h6><?php echo TEXT_COMPLETION_INSTALLATION_DIRECTORY_EXPLANATION; ?></h6>
		</div>
		<br>
<?php } ?>

	</div>
	<script>
	$(function()
	{
		$('.showModal').click(function(e)
		{
			var textId = $(this).attr('id');
			$.ajax({
				type: "POST",
				timeout: 100000,
				dataType: "json",
				data: 'id='+textId,
				url: '<?php echo "ajaxGetHelpText.php"; ?>',
				success: function(data) 
				{
					$('#modal-help-title').html(data.title);
					$('#modal-help-content').html(data.text);
					$('#modal-help').foundation('reveal', 'open');
				}
			});
			e.preventDefault();
		})
	});
	</script>
