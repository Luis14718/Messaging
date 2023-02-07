<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Tablemessaging {

    public static function init() {
        add_action( 'admin_menu', array( 'Tablemessaging', 'add_submenu_page' ) );
    }

    public static function add_submenu_page() {
        add_submenu_page(
            'text-message',
            'Entries',
            'Entries',
            'manage_options',
            'program-test-entries',
            array( 'Tablemessaging', 'display_entries' )
        );
    }

    public static function display_entries() {
        global $wpdb;

        $entries = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}messaging");
        ?>
        <div class="messaging">
            <div class="row">
                <div class="col-12">
                    <h1>Entries</h1>
                </div>
            </div>
        <table>
            <thead>
                <tr>
                    <th>ID  
                    <span class="sort-up">&#x25B2;</span>
                    <span class="sort-down">&#x25BC;</span></th>
                    <th>Phone
                    <span class="sort-up">&#x25B2;</span>
                        <span class="sort-down">&#x25BC;</span>
                    </th>
                    <th>Message
                    <span class="sort-up">&#x25B2;</span>
                     <span class="sort-down">&#x25BC;</span>
                    </th>
                    <th>Submitted
                    <span class="sort-up">&#x25B2;</span>
                     <span class="sort-down">&#x25BC;</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $entries as $entry ) : ?>
                <tr>
                    <td><?php echo $entry->id; ?></td>
                    <td><?php echo $entry->phone; ?></td>
                    <td><?php echo $entry->message; ?></td>
                    <td><?php echo $entry->timestamp; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                </div>
        <?php
    }
}
?>