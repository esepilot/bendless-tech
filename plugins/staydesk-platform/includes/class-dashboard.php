<?php
/**
 * Dashboard Handler Class
 */

class StayDesk_Dashboard {
    
    public function __construct() {
        // Ensure user is logged in for dashboard access
        if (!is_user_logged_in()) {
            wp_redirect(site_url('/staydesk/login'));
            exit;
        }
    }
    
    public function get_dashboard_stats($hotel_id) {
        global $wpdb;
        
        $stats = array();
        
        // Total bookings
        $stats['total_bookings'] = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_bookings WHERE hotel_id = %d",
            $hotel_id
        ));
        
        // Pending bookings
        $stats['pending_bookings'] = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_bookings 
            WHERE hotel_id = %d AND booking_status = 'pending'",
            $hotel_id
        ));
        
        // Total revenue
        $stats['total_revenue'] = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(amount) FROM {$wpdb->prefix}staydesk_payments 
            WHERE hotel_id = %d AND payment_status = 'success'",
            $hotel_id
        )) ?? 0;
        
        // Revenue this month
        $stats['monthly_revenue'] = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(amount) FROM {$wpdb->prefix}staydesk_payments 
            WHERE hotel_id = %d 
            AND payment_status = 'success'
            AND MONTH(paid_at) = MONTH(CURRENT_DATE())
            AND YEAR(paid_at) = YEAR(CURRENT_DATE())",
            $hotel_id
        )) ?? 0;
        
        // Total rooms
        $stats['total_rooms'] = $wpdb->get_var($wpdb->prepare(
            "SELECT SUM(total_rooms) FROM {$wpdb->prefix}staydesk_rooms WHERE hotel_id = %d",
            $hotel_id
        )) ?? 0;
        
        // Occupancy rate (current bookings / total rooms)
        $current_bookings = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_bookings 
            WHERE hotel_id = %d 
            AND booking_status IN ('confirmed', 'checked_in')
            AND CURDATE() BETWEEN check_in_date AND check_out_date",
            $hotel_id
        ));
        
        $stats['occupancy_rate'] = $stats['total_rooms'] > 0 
            ? round(($current_bookings / $stats['total_rooms']) * 100, 2) 
            : 0;
        
        return $stats;
    }
}
