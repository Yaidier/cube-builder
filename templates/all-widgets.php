<?php
namespace CubeBuilder;

$all_widgets = CubeBuilder::instance()->widgets_manager->get_all_widgets();


?>

<div id="wpwrap">
    <h1>All Widgets listed here</h1>

    <table>
    <tr>
        <th>Widget Name</th>
        <th>Edit</th>
    </tr>
        <?php foreach( $all_widgets as $widget ) { ?>
            <tr>
                <td>
                    <?php echo $widget->get_title(); ?>
                </td>
                <td> 
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=cb_widget_dashboard&widget-prefix=' . $widget->get_instance_prefix() ) ); ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

