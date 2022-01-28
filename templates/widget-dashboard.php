<?php

namespace CubeBuilder;

/**
 * 
 * 
 * 
 */

?>

<div id="wpwrap">
    <h1>Widget Dashboard</h1>
    <table>
        <tr>
            <th>Shortcode</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($widget_instances as $widget_instance) : ?>
            <tr>
                <td><?php echo esc_attr($widget_instance['id']); ?></td>
                <td>Edit</td>
                <td>
                    <button form="edit_widget" name="remove_instance" value="<?php echo esc_attr($widget_instance['id']); ?>" type="submit">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <form id="edit_widget" action="" method="post">
        <input type="submit" name="add_new_instance" value="add new instance">
    </form>
</div>