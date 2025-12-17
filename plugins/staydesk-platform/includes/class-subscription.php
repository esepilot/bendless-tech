<?php
/**
 * Subscription Management Class
 */

class StayDesk_Subscription {
    
    public function __construct() {
        add_action('wp_ajax_create_subscription', array($this, 'create_subscription'));
        add_action('wp_ajax_cancel_subscription', array($this, 'cancel_subscription'));
        add_action('wp_ajax_get_subscription', array($this, 'get_subscription'));
    }
    
    public function create_subscription($hotel_id, $plan_type, $paystack_data = array()) {
        global $wpdb;
        
        // Calculate dates
        $start_date = current_time('Y-m-d');
        $end_date = ($plan_type === 'monthly') 
            ? date('Y-m-d', strtotime('+1 month'))
            : date('Y-m-d', strtotime('+1 year'));
        
        // Calculate amount and discount
        $amount = ($plan_type === 'monthly') ? STAYDESK_MONTHLY_PRICE : STAYDESK_YEARLY_PRICE;
        $discount = 0;
        $is_first_10 = false;
        
        // Check if eligible for first 10 yearly discount
        if ($plan_type === 'yearly') {
            $count = $wpdb->get_var(
                "SELECT COUNT(*) FROM {$wpdb->prefix}staydesk_subscriptions 
                WHERE is_first_10_yearly = 1"
            );
            
            if ($count < 10) {
                $discount = $amount * STAYDESK_YEARLY_DISCOUNT;
                $amount = $amount - $discount;
                $is_first_10 = true;
            }
        }
        
        $result = $wpdb->insert(
            $wpdb->prefix . 'staydesk_subscriptions',
            array(
                'hotel_id' => $hotel_id,
                'plan_type' => $plan_type,
                'amount' => $amount,
                'discount_applied' => $discount,
                'status' => 'active',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'next_billing_date' => $end_date,
                'paystack_subscription_code' => $paystack_data['subscription_code'] ?? '',
                'paystack_customer_code' => $paystack_data['customer_code'] ?? '',
                'auto_renew' => 1,
                'is_first_10_yearly' => $is_first_10,
            ),
            array('%d', '%s', '%f', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d')
        );
        
        return ($result !== false) ? $wpdb->insert_id : false;
    }
    
    public function get_subscription() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = new StayDesk_Hotel();
        $hotel_data = $hotel->get_hotel_by_user($user_id);
        
        if (!$hotel_data) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $subscription = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_subscriptions 
            WHERE hotel_id = %d 
            AND status = 'active' 
            ORDER BY created_at DESC 
            LIMIT 1",
            $hotel_data->id
        ));
        
        if ($subscription) {
            wp_send_json_success($subscription);
        } else {
            wp_send_json_error(array('message' => 'No active subscription found'));
        }
    }
    
    public function cancel_subscription() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        global $wpdb;
        
        $user_id = get_current_user_id();
        $hotel = new StayDesk_Hotel();
        $hotel_data = $hotel->get_hotel_by_user($user_id);
        
        if (!$hotel_data) {
            wp_send_json_error(array('message' => 'Hotel not found'));
        }
        
        $result = $wpdb->update(
            $wpdb->prefix . 'staydesk_subscriptions',
            array(
                'status' => 'cancelled',
                'auto_renew' => 0,
            ),
            array(
                'hotel_id' => $hotel_data->id,
                'status' => 'active',
            ),
            array('%s', '%d'),
            array('%d', '%s')
        );
        
        if ($result !== false) {
            wp_send_json_success(array('message' => 'Subscription cancelled successfully'));
        }
        
        wp_send_json_error(array('message' => 'Failed to cancel subscription'));
    }
    
    public function check_subscription_status($hotel_id) {
        global $wpdb;
        
        $subscription = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_subscriptions 
            WHERE hotel_id = %d 
            AND status = 'active' 
            AND end_date >= CURDATE() 
            ORDER BY created_at DESC 
            LIMIT 1",
            $hotel_id
        ));
        
        return ($subscription !== null);
    }
}
