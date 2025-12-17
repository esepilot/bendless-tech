<?php
/**
 * Widget Responses Class - Bilingual (English + Nigerian Pidgin)
 */

class StayDesk_Widget_Responses {
    
    public function get_greeting($language, $hotel_name) {
        if ($language === 'pidgin') {
            $greetings = array(
                "Abeg welcome to {$hotel_name}! How I fit help you today? 😊",
                "Hello! Welcome to {$hotel_name}. Wetin you wan know? 🏨",
                "Hey! Na we be {$hotel_name}. How we fit take help you? 💫",
            );
        } else {
            $greetings = array(
                "Hello! Welcome to {$hotel_name}. How can I help you today? 😊",
                "Hi there! Welcome to {$hotel_name}. What can I do for you? 🏨",
                "Good day! Welcome to {$hotel_name}. How may I assist you? 💫",
            );
        }
        return $greetings[array_rand($greetings)];
    }
    
    public function get_booking_info($language) {
        if ($language === 'pidgin') {
            return "I fit help you book room! Just tell me:\n\n✓ When you wan check-in\n✓ When you wan check-out\n✓ How many people go stay\n\nOr you fit click here make I show you the rooms wey dey available. 🏨";
        } else {
            return "I can help you book a room! Just let me know:\n\n✓ Your check-in date\n✓ Your check-out date\n✓ Number of guests\n\nOr click here to view our available rooms. 🏨";
        }
    }
    
    public function get_pricing_info($language, $rooms) {
        if (empty($rooms)) {
            if ($language === 'pidgin') {
                return "Sorry o, we never add rooms for the system yet. Abeg call us make we fit help you.";
            } else {
                return "Sorry, room information is not available yet. Please contact us directly for pricing.";
            }
        }
        
        if ($language === 'pidgin') {
            $response = "Na dis be our room prices per night:\n\n";
            foreach ($rooms as $room) {
                $response .= "🏨 {$room->room_type}: ₦" . number_format($room->price_per_night, 2) . " per night\n";
            }
            $response .= "\nYou fit book now now! 😊";
        } else {
            $response = "Here are our room rates per night:\n\n";
            foreach ($rooms as $room) {
                $response .= "🏨 {$room->room_type}: ₦" . number_format($room->price_per_night, 2) . " per night\n";
            }
            $response .= "\nReady to book? 😊";
        }
        
        return $response;
    }
    
    public function get_amenities_info($language, $amenities) {
        if (empty($amenities)) {
            if ($language === 'pidgin') {
                return "Abeg we never add the amenities for system. Call us make we yarn you wetin we get.";
            } else {
                return "Amenities information is not available. Please contact us for details.";
            }
        }
        
        if ($language === 'pidgin') {
            $response = "Na dis things we get for the hotel:\n\n";
            foreach ($amenities as $amenity) {
                $response .= "✓ {$amenity}\n";
            }
            $response .= "\nYou go enjoy your stay well well! 🌟";
        } else {
            $response = "Our hotel amenities include:\n\n";
            foreach ($amenities as $amenity) {
                $response .= "✓ {$amenity}\n";
            }
            $response .= "\nWe hope you enjoy your stay! 🌟";
        }
        
        return $response;
    }
    
    public function get_check_in_out_info($language, $check_in, $check_out) {
        if ($language === 'pidgin') {
            return "Check-in time: {$check_in}\nCheck-out time: {$check_out}\n\nIf you wan come early or go late, just call us make we arrange am for you. 🕐";
        } else {
            return "Check-in time: {$check_in}\nCheck-out time: {$check_out}\n\nFor early check-in or late check-out, please contact us to make arrangements. 🕐";
        }
    }
    
    public function get_cancellation_policy($language, $policy) {
        if (empty($policy)) {
            if ($language === 'pidgin') {
                return "Abeg call us if you wan cancel your booking make we talk am. 📞";
            } else {
                return "Please contact us directly regarding cancellations. 📞";
            }
        }
        
        if ($language === 'pidgin') {
            return "Na dis be our cancellation policy:\n\n{$policy}\n\nIf you get any question, abeg ask me o! 😊";
        } else {
            return "Our cancellation policy:\n\n{$policy}\n\nIf you have any questions, feel free to ask! 😊";
        }
    }
    
    public function get_refund_policy($language, $policy) {
        if (empty($policy)) {
            if ($language === 'pidgin') {
                return "For refund matter, abeg call us directly make we talk am well well. We go sort you out. 💰";
            } else {
                return "For refund requests, please contact us directly. We'll be happy to assist you. 💰";
            }
        }
        
        if ($language === 'pidgin') {
            return "Na dis be our refund policy:\n\n{$policy}\n\nIf you wan request refund, just tell me your booking reference. 💰";
        } else {
            return "Our refund policy:\n\n{$policy}\n\nTo request a refund, please provide your booking reference. 💰";
        }
    }
    
    public function get_contact_info($language, $phone, $email, $address) {
        if ($language === 'pidgin') {
            return "Na so you fit reach us:\n\n📞 Phone: {$phone}\n📧 Email: {$email}\n📍 Address: {$address}\n\nWe dey wait for your call o! 😊";
        } else {
            return "Here's how to reach us:\n\n📞 Phone: {$phone}\n📧 Email: {$email}\n📍 Address: {$address}\n\nWe look forward to hearing from you! 😊";
        }
    }
    
    public function get_payment_methods($language, $methods) {
        if (empty($methods)) {
            if ($language === 'pidgin') {
                return "We dey accept cash, card and bank transfer. Call us make we give you better details. 💳";
            } else {
                return "We accept cash, cards, and bank transfers. Contact us for details. 💳";
            }
        }
        
        if ($language === 'pidgin') {
            $response = "Na dis payment methods we dey accept:\n\n";
            foreach ($methods as $method) {
                $response .= "✓ {$method}\n";
            }
            $response .= "\nYou fit pay as e dey sweet you! 💳";
        } else {
            $response = "We accept the following payment methods:\n\n";
            foreach ($methods as $method) {
                $response .= "✓ {$method}\n";
            }
            $response .= "\nPay however is most convenient for you! 💳";
        }
        
        return $response;
    }
    
    public function get_policies($language, $policies) {
        if (empty($policies)) {
            if ($language === 'pidgin') {
                return "Abeg call us make we tell you about our hotel policies. 📋";
            } else {
                return "Please contact us for information about our hotel policies. 📋";
            }
        }
        
        if ($language === 'pidgin') {
            return "Na dis be some of our hotel policies:\n\n" . implode("\n", $policies) . "\n\nAny question? Just ask me o! 😊";
        } else {
            return "Here are some of our hotel policies:\n\n" . implode("\n", $policies) . "\n\nAny questions? Feel free to ask! 😊";
        }
    }
    
    public function get_thanks_response($language) {
        if ($language === 'pidgin') {
            $responses = array(
                "You're welcome o! I dey here anytime you need help. 😊",
                "No wahala! Na my job be that. Happy to help! 💫",
                "E no be anything! Anytime you need me, just call. 🙌",
            );
        } else {
            $responses = array(
                "You're very welcome! I'm here anytime you need help. 😊",
                "No problem at all! Happy to help! 💫",
                "My pleasure! Feel free to reach out anytime. 🙌",
            );
        }
        return $responses[array_rand($responses)];
    }
    
    public function get_farewell($language, $hotel_name) {
        if ($language === 'pidgin') {
            $farewells = array(
                "See you later o! Thank you for chatting with {$hotel_name}. 👋",
                "Bye bye! We dey wait to see you soon. Stay blessed! 🌟",
                "Alright! Make you take care of yourself. See you soon! 😊",
            );
        } else {
            $farewells = array(
                "Goodbye! Thank you for chatting with {$hotel_name}. 👋",
                "See you soon! We look forward to welcoming you. 🌟",
                "Take care! Feel free to reach out anytime. 😊",
            );
        }
        return $farewells[array_rand($farewells)];
    }
    
    public function get_default_response($language, $phone) {
        if ($language === 'pidgin') {
            return "Sorry o, I no really understand wetin you talk. But no worry, you fit:\n\n✓ Ask me another question\n✓ Call us for {$phone}\n\nI go try my best to help you! 😊";
        } else {
            return "I'm sorry, I didn't quite understand that. But you can:\n\n✓ Try asking in a different way\n✓ Call us at {$phone}\n\nI'm here to help! 😊";
        }
    }
}
