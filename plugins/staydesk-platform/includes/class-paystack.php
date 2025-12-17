<?php
/**
 * Paystack Integration Class
 */

class StayDesk_Paystack {
    
    private $secret_key;
    private $public_key;
    
    public function __construct() {
        // Get Paystack keys from options (should be set in settings)
        $this->secret_key = get_option('staydesk_paystack_secret_key', '');
        $this->public_key = get_option('staydesk_paystack_public_key', '');
        
        add_action('wp_ajax_init_paystack_payment', array($this, 'initialize_payment'));
        add_action('wp_ajax_verify_paystack_payment', array($this, 'verify_payment'));
        add_action('wp_ajax_paystack_webhook', array($this, 'handle_webhook'));
        add_action('wp_ajax_nopriv_paystack_webhook', array($this, 'handle_webhook'));
    }
    
    public function initialize_payment() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        
        $email = sanitize_email($_POST['email']);
        $amount = floatval($_POST['amount']) * 100; // Paystack expects amount in kobo
        $reference = 'SD-PAY-' . time() . '-' . uniqid();
        
        $url = 'https://api.paystack.co/transaction/initialize';
        
        $fields = array(
            'email' => $email,
            'amount' => $amount,
            'reference' => $reference,
            'callback_url' => site_url('/staydesk/payment-callback'),
            'metadata' => array(
                'hotel_id' => intval($_POST['hotel_id'] ?? 0),
                'plan_type' => sanitize_text_field($_POST['plan_type'] ?? ''),
            ),
        );
        
        $response = $this->make_request($url, 'POST', $fields);
        
        if ($response && $response->status) {
            wp_send_json_success(array(
                'authorization_url' => $response->data->authorization_url,
                'access_code' => $response->data->access_code,
                'reference' => $response->data->reference,
            ));
        } else {
            wp_send_json_error(array('message' => 'Failed to initialize payment'));
        }
    }
    
    public function verify_payment() {
        check_ajax_referer('staydesk_nonce', 'nonce');
        
        $reference = sanitize_text_field($_POST['reference']);
        $url = "https://api.paystack.co/transaction/verify/{$reference}";
        
        $response = $this->make_request($url, 'GET');
        
        if ($response && $response->status && $response->data->status === 'success') {
            // Payment successful
            $metadata = $response->data->metadata;
            $hotel_id = $metadata->hotel_id ?? 0;
            $plan_type = $metadata->plan_type ?? '';
            
            if ($hotel_id && $plan_type) {
                // Create subscription
                $subscription = new StayDesk_Subscription();
                $subscription_id = $subscription->create_subscription($hotel_id, $plan_type, array(
                    'customer_code' => $response->data->customer->customer_code,
                ));
                
                // Record payment
                global $wpdb;
                $wpdb->insert(
                    $wpdb->prefix . 'staydesk_payments',
                    array(
                        'hotel_id' => $hotel_id,
                        'payment_reference' => $reference,
                        'amount' => $response->data->amount / 100,
                        'payment_method' => 'paystack',
                        'payment_status' => 'success',
                        'payment_type' => 'subscription',
                        'transaction_id' => $response->data->id,
                        'metadata' => json_encode($response->data),
                        'paid_at' => current_time('mysql'),
                    ),
                    array('%d', '%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s')
                );
            }
            
            wp_send_json_success(array(
                'message' => 'Payment verified successfully',
                'data' => $response->data,
            ));
        } else {
            wp_send_json_error(array('message' => 'Payment verification failed'));
        }
    }
    
    public function handle_webhook() {
        // Get the payload
        $payload = @file_get_contents('php://input');
        
        // Verify signature
        $signature = $_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] ?? '';
        
        if ($signature !== hash_hmac('sha512', $payload, $this->secret_key)) {
            http_response_code(400);
            exit();
        }
        
        $event = json_decode($payload);
        
        // Handle different event types
        switch ($event->event) {
            case 'charge.success':
                $this->handle_successful_charge($event->data);
                break;
            case 'subscription.create':
            case 'subscription.disable':
                // Handle subscription events
                break;
        }
        
        http_response_code(200);
        exit();
    }
    
    private function handle_successful_charge($data) {
        // Log or process successful charge
        // This is called by Paystack webhook
    }
    
    private function make_request($url, $method = 'GET', $data = null) {
        $args = array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->secret_key,
                'Content-Type' => 'application/json',
            ),
            'method' => $method,
            'timeout' => 30,
        );
        
        if ($data && $method === 'POST') {
            $args['body'] = json_encode($data);
        }
        
        $response = wp_remote_request($url, $args);
        
        if (is_wp_error($response)) {
            return false;
        }
        
        $body = wp_remote_retrieve_body($response);
        return json_decode($body);
    }
    
    public function get_public_key() {
        return $this->public_key;
    }
}
