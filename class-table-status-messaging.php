<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class TableStatusmessaging {

    public static function init() {
        add_action( 'admin_menu', array( 'TableStatusmessaging', 'add_submenu_page' ) );
    }

    public static function add_submenu_page() {
        add_submenu_page(
            'text-message',
            'Status',
            'Status',
            'manage_options',
            'message-status',
            array( 'TableStatusmessaging', 'display_entries' )
        );
    }

    public static function display_entries() {
        global $wpdb;

        $entries = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}messaging_status");
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
                    <th>Status 
                    <span class="sort-up">&#x25B2;</span>
                        <span class="sort-down">&#x25BC;</span>
                    </th>
                    <th>ID API
                    <span class="sort-up">&#x25B2;</span>
                     <span class="sort-down">&#x25BC;</span>
                    </th>
                    <th>Message
                    <span class="sort-up">&#x25B2;</span>
                     <span class="sort-down">&#x25BC;</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $entries as $entry ) : ?>
                <tr>
                    <td><?php echo $entry->id_message; ?></td>
                    <td><?php echo $entry->status_message; 
                     switch ($entry->status_message) {
                        case 'queued':
                            echo '<span class="yellow"> ●</span>';
                            break;
                        case 'failed':
                            echo '<span class="red"> ●</span>';
                            break;
                        case 'sent':
                            echo '<span class="green"> ●</span>';
                            break;
                        case 'delivered':
                            echo '<span class="green"> ●</span>';
                            break;
                        case 'undelivered':
                            echo '<span class="gray"> ●</span>';
                            break;
                    }
                     ?> </td>
                    <td><?php echo $entry->id_api_message; ?></td>
                    <td><?php echo $entry->message; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                </div>
        <?php
    }
}
?>