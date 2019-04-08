<?php
/**
 * @package admin
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2010 Kuroi Web Design
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Zen4All Sun Mar 18 10:12:14 2018 +0100 Modified in v1.5.6 $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

$var = zen_get_languages();
$jsLanguageLookupArray = "var lang = new Array;\n";
foreach ($var as $key)
{
  $jsLanguageLookupArray .= "  lang[" . $key['id'] . "] = '" . $key['code'] . "';\n";
}
?>
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"><\/script>');</script>
<script>window.jQuery || document.write('<script src="includes/javascript/jquery-3.3.1.min.js"><\/script>');</script>
<script type="text/javascript" src="../<?php echo DIR_WS_EDITORS; ?>ckeditor/ckeditor.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  <?php echo $jsLanguageLookupArray ?>
  $('textarea').each(function() {
    if ($(this).hasClass('editorHook') || ($(this).attr('name') != 'message' && ! $(this).hasClass('noEditor')))
    {
      index = $(this).attr('name').match(/\d+/);
      if (index == null) index = <?php echo $_SESSION['languages_id'] ?>;
      CKEDITOR.replace($(this).attr('name'),
        {
          coreStyles_underline : { element : 'u' },
          width : '100%',
          language: lang[index]
        });
    }
  });
});
</script>
