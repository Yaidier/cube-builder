<?php 

/**
 * 
 * 
 * 
 */

?>

<?php if( !defined( 'CB_EDITOR_LOADED' ) ) : ?>
    <div class="cb-editor wn_editor_unique_name cb_display_none cb_silde_from_left">
    </div>

    <?php 
    define( 'CB_EDITOR_LOADED', true );
endif; ?>

<div editor-content-for="<?php echo esc_attr( $instance_id ); ?>" class="cb-editor_content">
    <h3><?php echo esc_attr( $widget_name ); ?></h3>
    <ul class="cb-editor_main_tabs" >
        <?php foreach( $sections as $section_name => $section_args ) : ?>
            <li section-name="<?php echo esc_attr( $section_name ); ?>" >
                <?php echo esc_attr( $section_args['section_info']['label'] ); ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php foreach( $sections as $section_name => $section_args ) : ?>
        <div class="cb-editor_main_tab_contents cb_display_none" id="cb-editor_main_tab_content-<?php echo esc_attr( $section_name ); ?>"  >
            <?php if( isset( $section_args['section_controls'] ) ) {
                foreach( $section_args['section_controls'] as $control_name => $control_data ) {
                    echo $control_name;
                }
            }; ?>
        </div>
    <?php endforeach; ?>
</div>
