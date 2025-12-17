<?php
/**
 * Frontend admin panel for BendlessTech staff
 */

class BendlessTech_Admin {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('init', array($this, 'handle_frontend_admin'));
        add_action('wp_ajax_update_lead_status', array($this, 'update_lead_status'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'BendlessTech Leads',
            'BT Leads',
            'manage_options',
            'bendlesstech-leads',
            array($this, 'render_admin_page'),
            'dashicons-chart-line',
            30
        );
    }
    
    public function handle_frontend_admin() {
        // Check if we're on the frontend admin URL
        if (isset($_GET['bendlesstech_admin']) && $_GET['bendlesstech_admin'] === 'dashboard') {
            if (!is_user_logged_in() || !current_user_can('manage_options')) {
                wp_redirect(wp_login_url($_SERVER['REQUEST_URI']));
                exit;
            }
            
            $this->render_frontend_admin();
            exit;
        }
    }
    
    public function render_admin_page() {
        ?>
        <div class="wrap">
            <h1>Lead Management</h1>
            <?php $this->render_leads_table(); ?>
        </div>
        <?php
    }
    
    public function render_frontend_admin() {
        ?>
        <!DOCTYPE html>
        <html <?php language_attributes(); ?>>
        <head>
            <meta charset="<?php bloginfo('charset'); ?>">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>BendlessTech Admin Dashboard</title>
            <style>
                * { margin: 0; padding: 0; box-sizing: border-box; }
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f5f5f5; }
                .admin-header { background: #1a73e8; color: white; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .admin-header h1 { font-size: 24px; font-weight: 600; }
                .admin-container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
                .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px; }
                .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .stat-card h3 { font-size: 14px; color: #666; margin-bottom: 10px; text-transform: uppercase; }
                .stat-card .value { font-size: 32px; font-weight: bold; color: #1a73e8; }
                .leads-section { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .leads-section h2 { margin-bottom: 20px; color: #333; }
                .filter-tabs { display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #eee; }
                .filter-tab { padding: 10px 20px; cursor: pointer; background: none; border: none; font-size: 14px; color: #666; border-bottom: 2px solid transparent; margin-bottom: -2px; }
                .filter-tab.active { color: #1a73e8; border-bottom-color: #1a73e8; font-weight: 600; }
                .leads-table { width: 100%; border-collapse: collapse; }
                .leads-table th { text-align: left; padding: 12px; background: #f9f9f9; font-weight: 600; color: #333; border-bottom: 2px solid #eee; }
                .leads-table td { padding: 12px; border-bottom: 1px solid #eee; }
                .status-badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; }
                .status-new { background: #e3f2fd; color: #1976d2; }
                .status-contacted { background: #fff3e0; color: #f57c00; }
                .status-quoted { background: #f3e5f5; color: #7b1fa2; }
                .status-converted { background: #e8f5e9; color: #388e3c; }
                .status-closed { background: #fce4ec; color: #c2185b; }
                .view-btn { padding: 6px 16px; background: #1a73e8; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
                .view-btn:hover { background: #1557b0; }
            </style>
        </head>
        <body>
            <div class="admin-header">
                <h1>BendlessTech Admin Dashboard</h1>
            </div>
            <div class="admin-container">
                <?php $this->render_stats(); ?>
                <div class="leads-section">
                    <h2>Leads Management</h2>
                    <?php $this->render_leads_table(); ?>
                </div>
            </div>
        </body>
        </html>
        <?php
    }
    
    private function render_stats() {
        global $wpdb;
        $table = $wpdb->prefix . 'bt_leads';
        
        $total = $wpdb->get_var("SELECT COUNT(*) FROM $table");
        $new = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'new'");
        $contacted = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'contacted'");
        $converted = $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE status = 'converted'");
        
        ?>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Leads</h3>
                <div class="value"><?php echo esc_html($total); ?></div>
            </div>
            <div class="stat-card">
                <h3>New Leads</h3>
                <div class="value"><?php echo esc_html($new); ?></div>
            </div>
            <div class="stat-card">
                <h3>Contacted</h3>
                <div class="value"><?php echo esc_html($contacted); ?></div>
            </div>
            <div class="stat-card">
                <h3>Converted</h3>
                <div class="value"><?php echo esc_html($converted); ?></div>
            </div>
        </div>
        <?php
    }
    
    private function render_leads_table() {
        global $wpdb;
        $table = $wpdb->prefix . 'bt_leads';
        
        $leads = $wpdb->get_results("SELECT * FROM $table ORDER BY created_at DESC LIMIT 100");
        
        ?>
        <div class="filter-tabs">
            <button class="filter-tab active">All</button>
            <button class="filter-tab">Website Development</button>
            <button class="filter-tab">Inventory System</button>
            <button class="filter-tab">New</button>
            <button class="filter-tab">Contacted</button>
        </div>
        <table class="leads-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Business Name</th>
                    <th>Contact</th>
                    <th>WhatsApp</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leads)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px; color: #999;">No leads yet</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($leads as $lead): ?>
                        <tr>
                            <td><?php echo esc_html(date('M d, Y', strtotime($lead->created_at))); ?></td>
                            <td><?php echo esc_html(ucwords(str_replace('_', ' ', $lead->type))); ?></td>
                            <td><?php echo esc_html($lead->business_name); ?></td>
                            <td><?php echo esc_html($lead->contact_name); ?></td>
                            <td><?php echo esc_html($lead->whatsapp); ?></td>
                            <td><?php echo esc_html($lead->email); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo esc_attr($lead->status); ?>">
                                    <?php echo esc_html(ucfirst($lead->status)); ?>
                                </span>
                            </td>
                            <td>
                                <button class="view-btn" onclick="viewLead(<?php echo esc_attr($lead->id); ?>)">View Details</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <?php
    }
    
    public function update_lead_status() {
        check_ajax_referer('bendlesstech_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error(array('message' => 'Unauthorized'));
        }
        
        $lead_id = intval($_POST['lead_id']);
        $status = sanitize_text_field($_POST['status']);
        
        global $wpdb;
        $table = $wpdb->prefix . 'bt_leads';
        
        $result = $wpdb->update(
            $table,
            array('status' => $status),
            array('id' => $lead_id),
            array('%s'),
            array('%d')
        );
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'Status updated successfully'));
        } else {
            wp_send_json_error(array('message' => 'Failed to update status'));
        }
    }
}
