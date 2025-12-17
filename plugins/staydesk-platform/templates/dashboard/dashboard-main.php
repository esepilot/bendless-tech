<?php
/**
 * Main Dashboard Page
 */

// Get hotel data
$user_id = get_current_user_id();
$hotel_mgr = new StayDesk_Hotel();
$hotel = $hotel_mgr->get_hotel_by_user($user_id);

if (!$hotel) {
    echo '<p>No hotel found. Please complete your hotel setup.</p>';
    exit;
}

$dashboard = new StayDesk_Dashboard();
$stats = $dashboard->get_dashboard_stats($hotel->id);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - StayDesk</title>
    <?php wp_head(); ?>
</head>
<body class="staydesk-page">
    <div class="staydesk-dashboard">
        <div class="dashboard-sidebar">
            <div class="logo">
                <h2 style="color: white; margin: 0;">StayDesk</h2>
                <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin: 5px 0 0;">
                    <?php echo esc_html($hotel->hotel_name); ?>
                </p>
            </div>
            <nav>
                <a href="<?php echo site_url('/staydesk/dashboard'); ?>" class="active">
                    📊 Dashboard
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/bookings'); ?>">
                    📅 Bookings
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/rooms'); ?>">
                    🏨 Rooms
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/payments'); ?>">
                    💳 Payments
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/guests'); ?>">
                    👥 Guests
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/reports'); ?>">
                    📊 Reports
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/chat-widget'); ?>">
                    💬 Chat Widget
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/settings'); ?>">
                    ⚙️ Settings
                </a>
                <a href="<?php echo site_url('/staydesk/dashboard/subscription'); ?>">
                    💎 Subscription
                </a>
                <a href="<?php echo wp_logout_url(site_url('/staydesk/login')); ?>">
                    🚪 Logout
                </a>
            </nav>
        </div>
        
        <div class="dashboard-main">
            <div class="dashboard-header">
                <h1>Dashboard Overview</h1>
                <div>
                    <?php echo date('l, F j, Y'); ?>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Bookings</h3>
                    <div class="value"><?php echo number_format($stats['total_bookings']); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Pending Bookings</h3>
                    <div class="value"><?php echo number_format($stats['pending_bookings']); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Monthly Revenue</h3>
                    <div class="value">₦<?php echo number_format($stats['monthly_revenue'], 2); ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Occupancy Rate</h3>
                    <div class="value"><?php echo $stats['occupancy_rate']; ?>%</div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Recent Bookings</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Booking Ref</th>
                            <th>Guest</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $wpdb;
                        $recent_bookings = $wpdb->get_results($wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}staydesk_bookings 
                            WHERE hotel_id = %d 
                            ORDER BY created_at DESC 
                            LIMIT 10",
                            $hotel->id
                        ));
                        
                        if (empty($recent_bookings)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                                    No bookings yet. Start accepting bookings today!
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_bookings as $booking): ?>
                                <tr>
                                    <td><?php echo esc_html($booking->booking_reference); ?></td>
                                    <td><?php echo esc_html($booking->guest_name); ?></td>
                                    <td><?php echo esc_html($booking->check_in_date); ?></td>
                                    <td><?php echo esc_html($booking->check_out_date); ?></td>
                                    <td>₦<?php echo number_format($booking->total_amount, 2); ?></td>
                                    <td>
                                        <span class="status-badge status-<?php echo esc_attr($booking->booking_status); ?>">
                                            <?php echo esc_html(ucfirst($booking->booking_status)); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Quick Actions</h2>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <a href="<?php echo site_url('/staydesk/dashboard/bookings'); ?>" class="btn btn-primary">
                        New Booking
                    </a>
                    <a href="<?php echo site_url('/staydesk/dashboard/rooms'); ?>" class="btn btn-primary">
                        Add Room
                    </a>
                    <a href="<?php echo site_url('/staydesk/dashboard/chat-widget'); ?>" class="btn btn-success">
                        Get Widget Code
                    </a>
                    <a href="<?php echo site_url('/staydesk/dashboard/reports'); ?>" class="btn btn-primary">
                        View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>
