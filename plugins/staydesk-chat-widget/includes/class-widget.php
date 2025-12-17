<?php
/**
 * Widget Handler Class
 */

class StayDesk_Widget {
    
    private $responses;
    private $language_handler;
    private $booking_handler;
    
    public function __construct() {
        $this->responses = new StayDesk_Widget_Responses();
        $this->language_handler = new StayDesk_Widget_Language();
        $this->booking_handler = new StayDesk_Widget_Booking_Handler();
    }
    
    public function process_message($hotel_id, $message, $language = 'english', $session_id = '') {
        // Normalize message
        $message = strtolower(trim($message));
        
        // Detect language if not specified
        if ($language === 'auto') {
            $language = $this->language_handler->detect_language($message);
        }
        
        // Generate session ID if not provided
        if (empty($session_id)) {
            $session_id = 'session_' . time() . '_' . rand(1000, 9999);
        }
        
        // Save conversation
        $this->save_conversation($hotel_id, $session_id, $message, 'user');
        
        // Determine intent and generate response
        $intent = $this->detect_intent($message);
        $response = $this->generate_response($hotel_id, $intent, $message, $language);
        
        // Save bot response
        $this->save_conversation($hotel_id, $session_id, $response['message'], 'bot');
        
        return array(
            'session_id' => $session_id,
            'message' => $response['message'],
            'intent' => $intent,
            'language' => $language,
            'actions' => $response['actions'] ?? array(),
        );
    }
    
    private function detect_intent($message) {
        $intents = array(
            'greeting' => array('hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening', 'wetin dey', 'abeg', 'omo'),
            'booking' => array('book', 'reserve', 'reservation', 'available', 'room', 'stay', 'check', 'wan book'),
            'pricing' => array('price', 'cost', 'how much', 'rate', 'fee', 'charge', 'na how much'),
            'amenities' => array('amenities', 'facilities', 'feature', 'service', 'pool', 'wifi', 'gym', 'wetin una get'),
            'check_in_out' => array('check in', 'check out', 'arrival', 'departure', 'check-in time', 'check-out time'),
            'cancellation' => array('cancel', 'cancellation', 'cancel booking', 'wan cancel'),
            'refund' => array('refund', 'money back', 'return', 'refund policy', 'wan collect money back'),
            'contact' => array('contact', 'phone', 'email', 'reach', 'call', 'address', 'location', 'how i fit reach una'),
            'payment' => array('payment', 'pay', 'card', 'transfer', 'cash', 'how to pay', 'wetin be payment method'),
            'policy' => array('policy', 'rule', 'terms', 'condition', 'regulation'),
            'thanks' => array('thank', 'thanks', 'appreciate', 'tenks', 'tank you'),
            'farewell' => array('bye', 'goodbye', 'see you', 'later', 'adios'),
        );
        
        foreach ($intents as $intent => $keywords) {
            foreach ($keywords as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $intent;
                }
            }
        }
        
        return 'general';
    }
    
    private function generate_response($hotel_id, $intent, $message, $language) {
        global $wpdb;
        
        // Get hotel data
        $hotel = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_hotels WHERE id = %d",
            $hotel_id
        ));
        
        if (!$hotel) {
            return array('message' => 'Hotel information not available.');
        }
        
        $response_text = '';
        $actions = array();
        
        switch ($intent) {
            case 'greeting':
                $response_text = $this->responses->get_greeting($language, $hotel->hotel_name);
                break;
                
            case 'booking':
                $response_text = $this->responses->get_booking_info($language);
                $actions[] = array('type' => 'show_rooms', 'hotel_id' => $hotel_id);
                break;
                
            case 'pricing':
                $rooms = $wpdb->get_results($wpdb->prepare(
                    "SELECT room_type, price_per_night FROM {$wpdb->prefix}staydesk_rooms WHERE hotel_id = %d AND status = 'active'",
                    $hotel_id
                ));
                $response_text = $this->responses->get_pricing_info($language, $rooms);
                break;
                
            case 'amenities':
                $amenities = json_decode($hotel->amenities, true);
                $response_text = $this->responses->get_amenities_info($language, $amenities);
                break;
                
            case 'check_in_out':
                $response_text = $this->responses->get_check_in_out_info($language, $hotel->check_in_time, $hotel->check_out_time);
                break;
                
            case 'cancellation':
                $response_text = $this->responses->get_cancellation_policy($language, $hotel->cancellation_policy);
                break;
                
            case 'refund':
                $response_text = $this->responses->get_refund_policy($language, $hotel->refund_policy);
                $actions[] = array('type' => 'refund_form');
                break;
                
            case 'contact':
                $response_text = $this->responses->get_contact_info($language, $hotel->phone, $hotel->email, $hotel->address);
                break;
                
            case 'payment':
                $payment_methods = json_decode($hotel->payment_methods, true);
                $response_text = $this->responses->get_payment_methods($language, $payment_methods);
                break;
                
            case 'policy':
                $policies = json_decode($hotel->policies, true);
                $response_text = $this->responses->get_policies($language, $policies);
                break;
                
            case 'thanks':
                $response_text = $this->responses->get_thanks_response($language);
                break;
                
            case 'farewell':
                $response_text = $this->responses->get_farewell($language, $hotel->hotel_name);
                break;
                
            default:
                // Try to match with FAQs
                $faqs = json_decode($hotel->faqs, true);
                $response_text = $this->match_faq($message, $faqs, $language);
                
                if (empty($response_text)) {
                    $response_text = $this->responses->get_default_response($language, $hotel->phone);
                }
                break;
        }
        
        return array(
            'message' => $response_text,
            'actions' => $actions,
        );
    }
    
    private function match_faq($message, $faqs, $language) {
        if (empty($faqs)) {
            return '';
        }
        
        foreach ($faqs as $faq) {
            $question = strtolower($faq['question'] ?? '');
            $answer = $faq['answer'] ?? '';
            
            // Simple keyword matching
            $words = explode(' ', $message);
            $matches = 0;
            foreach ($words as $word) {
                if (strlen($word) > 3 && strpos($question, $word) !== false) {
                    $matches++;
                }
            }
            
            if ($matches >= 2) {
                return $answer;
            }
        }
        
        return '';
    }
    
    private function save_conversation($hotel_id, $session_id, $message, $sender) {
        global $wpdb;
        
        $conversation = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}staydesk_conversations WHERE hotel_id = %d AND session_id = %s",
            $hotel_id, $session_id
        ));
        
        $messages = array();
        if ($conversation) {
            $messages = json_decode($conversation->messages, true) ?? array();
        }
        
        $messages[] = array(
            'sender' => $sender,
            'message' => $message,
            'timestamp' => current_time('mysql'),
        );
        
        if ($conversation) {
            $wpdb->update(
                $wpdb->prefix . 'staydesk_conversations',
                array('messages' => json_encode($messages)),
                array('id' => $conversation->id),
                array('%s'),
                array('%d')
            );
        } else {
            $wpdb->insert(
                $wpdb->prefix . 'staydesk_conversations',
                array(
                    'hotel_id' => $hotel_id,
                    'session_id' => $session_id,
                    'messages' => json_encode($messages),
                    'status' => 'active',
                ),
                array('%d', '%s', '%s', '%s')
            );
        }
    }
}
