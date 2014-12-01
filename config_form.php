<div class="field">
    <div class="two columns alpha">
        <label for="css"><?php echo __('CSS'); ?></label>    
    </div>    
    <div class="inputs five columns omega">
        <p class="explanation"><?php echo __('The custom CSS you would like to add.'); ?></p>
        <div class="input-block">
            <?php echo get_view()->formTextarea('css', get_option('css_editor_css'), array('rows' => 25, 'cols' => 50)); ?>
        </div>
    </div>
</div>
