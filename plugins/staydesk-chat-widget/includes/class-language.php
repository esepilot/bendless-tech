<?php
/**
 * Language Detection Class
 */

class StayDesk_Widget_Language {
    
    private $pidgin_keywords = array(
        'wetin', 'abeg', 'dey', 'na', 'fit', 'wan', 'una', 'omo', 'guy',
        'no', 'e', 'am', 'make', 'go', 'don', 'yarn', 'shey', 'abi',
        'dem', 'wey', 'dis', 'dat', 'tenks', 'tank you', 'how far',
        'no wahala', 'i sabi', 'chai', 'oya', 'comot', 'chop'
    );
    
    public function detect_language($message) {
        $message = strtolower($message);
        
        // Count pidgin keywords
        $pidgin_count = 0;
        foreach ($this->pidgin_keywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                $pidgin_count++;
            }
        }
        
        // If message contains 2+ pidgin keywords, assume pidgin
        if ($pidgin_count >= 2) {
            return 'pidgin';
        }
        
        // Check for single strong pidgin indicators
        $strong_indicators = array('wetin', 'abeg', 'una', 'no wahala', 'how far');
        foreach ($strong_indicators as $indicator) {
            if (strpos($message, $indicator) !== false) {
                return 'pidgin';
            }
        }
        
        // Default to English
        return 'english';
    }
    
    public function translate_to_pidgin($english_text) {
        // Basic translation mapping (could be expanded)
        $translations = array(
            'Hello' => 'Hello',
            'How can I help you' => 'How I fit help you',
            'Thank you' => 'Tank you',
            'You are welcome' => 'You are welcome',
            'Good morning' => 'Good morning',
            'Good afternoon' => 'Good afternoon',
            'Good evening' => 'Good evening',
            'Please' => 'Abeg',
            'What' => 'Wetin',
            'Do you have' => 'You get',
            'I want' => 'I wan',
            'How much' => 'Na how much',
            'Is it available' => 'E dey available',
            'Yes' => 'Yes',
            'No' => 'No',
            'Okay' => 'Okay',
            'Sorry' => 'Sorry o',
        );
        
        $text = $english_text;
        foreach ($translations as $eng => $pidgin) {
            $text = str_ireplace($eng, $pidgin, $text);
        }
        
        return $text;
    }
}
