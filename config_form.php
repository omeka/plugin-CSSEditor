<div class="field">
    <div class="two columns alpha">
        <label for="css"><?php echo __('CSS'); ?></label>    
    </div>    
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('The custom CSS you would like to add.'); ?></p>
        <div class="input-block">        
        <textarea rows="25" cols="50" name="css" id="css" /><?php echo get_option('css_editor_css'); ?></textarea>      
        </div>
    </div>
</div>