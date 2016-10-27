<div class="field">
    <label for="css"><?php echo __('CSS'); ?></label>    
        <p class="explanation"><?php echo __('The custom CSS you would like to add.'); ?></p>
        <div class="input-block">
            <?php echo get_view()->formTextarea('css', get_option('css_editor_css'), array('rows' => 25, 'cols' => 50)); ?>
        </div>

        <label for="filter"><?php echo __('Filter CSS'); ?></label> 
        <?php echo get_view()->formCheckbox('filter', null, array('checked' => get_option('css_editor_filter'))); ?>
</div>
