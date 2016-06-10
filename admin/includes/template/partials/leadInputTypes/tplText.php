<?php
/**
 * Admin Lead Template  - text partial
 *
 * @package templateSystem
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:   New in v1.6.0 $
 */
//print_r($tplVars['leadDefinition']['fields'][$field]);
?>
<div class="form-group">
    <?php require('includes/template/partials/' . $tplVars['leadDefinition']['inputLabelTemplate']); ?>
    <div class="input-group col-sm-6 <?php if (isset($tplVars['validationErrors'][$tplVars['leadDefinition']['fields'][$field]['field']])) { echo ' has-error ';}; ?>">
    <input id="<?php echo $tplVars['leadDefinition']['fields'][$field]['field']; ?>"
           class="form-control <?php echo $tplVars['leadDefinition']['action']; ?>LeadFilterInput <?php if ($tplVars['leadDefinition']['fields'][$field]['autocomplete']) echo 'autocomplete'; ?> "
           type="text"
           name="<?php echo $tplVars['leadDefinition']['fields'][$field]['field']; ?>"
           value="<?php echo htmlspecialchars($tplVars['leadDefinition']['fields'][$field]['value']); ?>" size="<?php echo $tplVars['leadDefinition']['fields'][$field]['layout']['size']; ?>"
           <?php if ($tplVars['leadDefinition']['fields'][$field]['validations']['pattern'] !="") echo ' pattern="' . $tplVars['leadDefinition']['fields'][$field]['validations']['pattern'] . '"'; ?>
           <?php echo ($tplVars['leadDefinition']['fields'][$field]['validations']['required']) ? ' required ' : ''; ?>
           >
        <?php require('includes/template/partials/' . $tplVars['leadDefinition']['errorTemplate']); ?>
        <?php require('includes/template/partials/' . $tplVars['leadDefinition']['autoCompleteTemplate']); ?>
    </div>
</div>
