<?php
/**
 * Email notification handler
 */

class BendlessTech_Email {
    
    private $to = 'reach@bendlesstech.com';
    
    public function send_website_lead_notification($data) {
        $subject = 'New Website Development Lead - ' . $data['business_name'];
        
        $message = $this->get_email_header();
        $message .= '<h2 style="color: #1a73e8; margin-bottom: 20px;">New Website Development Lead</h2>';
        $message .= '<table style="width: 100%; border-collapse: collapse;">';
        $message .= $this->email_row('Business Name', $data['business_name']);
        $message .= $this->email_row('Contact Person', $data['contact_name']);
        $message .= $this->email_row('WhatsApp', $data['whatsapp']);
        $message .= $this->email_row('Email', $data['email']);
        $message .= $this->email_row('Industry', $data['industry']);
        $message .= $this->email_row('Website Type', $data['website_type']);
        $message .= $this->email_row('Features Required', nl2br($data['features']));
        $message .= $this->email_row('Budget Range', $data['budget_range']);
        $message .= $this->email_row('Additional Notes', nl2br($data['notes']));
        $message .= '</table>';
        $message .= $this->get_email_footer();
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($this->to, $subject, $message, $headers);
    }
    
    public function send_inventory_lead_notification($data) {
        $subject = 'New Inventory System Lead - ' . $data['business_name'];
        
        $message = $this->get_email_header();
        $message .= '<h2 style="color: #1a73e8; margin-bottom: 20px;">New Inventory System Lead</h2>';
        $message .= '<table style="width: 100%; border-collapse: collapse;">';
        $message .= $this->email_row('Business Name', $data['business_name']);
        $message .= $this->email_row('Contact Person', $data['contact_name']);
        $message .= $this->email_row('WhatsApp', $data['whatsapp']);
        $message .= $this->email_row('Email', $data['email']);
        $message .= $this->email_row('Industry', $data['industry']);
        $message .= $this->email_row('Inventory Size', $data['inventory_size']);
        $message .= $this->email_row('Number of Products/SKUs', $data['num_products']);
        $message .= $this->email_row('Number of Users', $data['num_users']);
        $message .= $this->email_row('Features Required', nl2br($data['features']));
        $message .= $this->email_row('Current Challenges', nl2br($data['challenges']));
        $message .= $this->email_row('Additional Notes', nl2br($data['notes']));
        $message .= '</table>';
        $message .= $this->get_email_footer();
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($this->to, $subject, $message, $headers);
    }
    
    public function send_contact_notification($data) {
        $subject = 'New Contact Form Submission - ' . $data['name'];
        
        $message = $this->get_email_header();
        $message .= '<h2 style="color: #1a73e8; margin-bottom: 20px;">New Contact Message</h2>';
        $message .= '<table style="width: 100%; border-collapse: collapse;">';
        $message .= $this->email_row('Name', $data['name']);
        $message .= $this->email_row('Email', $data['email']);
        $message .= $this->email_row('WhatsApp', $data['whatsapp']);
        $message .= $this->email_row('Message', nl2br($data['message']));
        $message .= '</table>';
        $message .= $this->get_email_footer();
        
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        wp_mail($this->to, $subject, $message, $headers);
    }
    
    private function email_row($label, $value) {
        return '<tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; width: 30%;">' . esc_html($label) . '</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">' . $value . '</td>
        </tr>';
    }
    
    private function get_email_header() {
        return '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background: #1a73e8; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
                <h1 style="margin: 0; font-size: 24px;">BendlessTech</h1>
            </div>
            <div style="background: #f9f9f9; padding: 30px; border-radius: 0 0 5px 5px;">';
    }
    
    private function get_email_footer() {
        return '
                <p style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #666; font-size: 14px;">
                    <strong>Contact the lead via WhatsApp:</strong><br>
                    WhatsApp: 07120018023<br>
                    Email: reach@bendlesstech.com
                </p>
            </div>
        </body>
        </html>';
    }
}
