<?php
/**
 * Admin Lead Template  - select partial
 *
 * @package templateSystem
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id:   New in v1.6.0 $
 */
?>


<div class="form-group">

    <?php require('includes/template/partials/' . $tplVars['leadDefinition']['inputLabelTemplate']); ?>
    <div
        class="input-group col-sm-6 <?php if (isset($tplVars['validationErrors'][$tplVars['leadDefinition']['fields'][$field]['field']])) {
            echo ' has-error ';
        }; ?>">
        <select
            value="<?php echo htmlspecialchars($tplVars['leadDefinition']['fields'][$field]['value']); ?>"
            class="form-control <?php echo $tplVars['leadDefinition']['action']; ?>LeadFilterInput"
            name="<?php echo $tplVars['leadDefinition']['fields'][$field]['field']; ?>">
            <?php foreach ($tplVars['leadDefinition']['fields'][$field]['layout']['options'] as $option) { ?>
                <option
                    value="<?php echo zen_output_string_protected($option['id']); ?>"
                    <?php if ($tplVars['leadDefinition']['fields'][$field]['value'] == $option['id']) {
                        echo ' selected="selected" ';
                    } ?>>
                    <?php echo zen_output_string_protected($option['text']); ?>
                </option>
            <?php } ?>

        </select>
    </div>
</div>
