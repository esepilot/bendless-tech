<?php
/**
 * StayDesk Registration Page
 */

// Check if user is already logged in
if (is_user_logged_in()) {
    wp_redirect(site_url('/staydesk/dashboard'));
    exit;
}

get_header();

$plan = isset($_GET['plan']) ? sanitize_text_field($_GET['plan']) : 'monthly';
?>

<div class="bendlesstech-hero" style="padding: 60px 0;">
    <div class="bendlesstech-container">
        <h1>Register Your Hotel</h1>
        <p>Join StayDesk and start managing your hotel efficiently</p>
    </div>
</div>

<section style="padding: 80px 0; background: #f9f9f9;">
    <div class="bendlesstech-container">
        <div class="bendlesstech-form" style="max-width: 600px;">
            <h3>Hotel Registration</h3>
            <p style="color: #666; margin-bottom: 30px;">Fill in your details to get started with StayDesk.</p>
            
            <form id="hotel-registration-form" method="post">
                <input type="hidden" name="plan_type" value="<?php echo esc_attr($plan); ?>">
                
                <h4 style="margin-bottom: 20px; color: #1a73e8;">Account Information</h4>
                
                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" name="username" id="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" name="email" id="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" name="password" id="password" required minlength="8">
                    <span class="helper-text">Minimum 8 characters</span>
                </div>
                
                <h4 style="margin: 30px 0 20px; color: #1a73e8;">Hotel Information</h4>
                
                <div class="form-group">
                    <label for="hotel_name">Hotel Name *</label>
                    <input type="text" name="hotel_name" id="hotel_name" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" name="phone" id="phone" required>
                </div>
                
                <div class="form-group">
                    <label for="address">Address *</label>
                    <textarea name="address" id="address" required rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="city">City *</label>
                    <input type="text" name="city" id="city" required>
                </div>
                
                <div class="form-group">
                    <label for="state">State *</label>
                    <input type="text" name="state" id="state" required>
                </div>
                
                <div style="background: #e3f2fd; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
                    <h4 style="margin-bottom: 10px; color: #1a73e8;">Selected Plan: <?php echo ucfirst($plan); ?></h4>
                    <p style="font-size: 18px; font-weight: bold; color: #333; margin-bottom: 10px;">
                        <?php if ($plan === 'monthly'): ?>
                            ₦49,900/month
                        <?php else: ?>
                            ₦598,800/year (10% OFF for first 10 hotels!)
                        <?php endif; ?>
                    </p>
                    <p style="font-size: 14px; color: #666;">
                        You'll be redirected to payment after registration.
                    </p>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: start; gap: 10px;">
                        <input type="checkbox" name="agree_terms" required>
                        <span style="font-size: 14px; color: #666;">
                            I agree to the <a href="<?php echo site_url('/terms-of-service'); ?>" target="_blank">Terms of Service</a> 
                            and <a href="<?php echo site_url('/privacy-policy'); ?>" target="_blank">Privacy Policy</a>
                        </span>
                    </label>
                </div>
                
                <button type="submit" class="submit-btn">Complete Registration & Proceed to Payment</button>
                
                <p style="text-align: center; margin-top: 20px; color: #666;">
                    Already have an account? <a href="<?php echo site_url('/staydesk/login'); ?>">Login here</a>
                </p>
            </form>
        </div>
    </div>
</section>

<script>
jQuery(document).ready(function($) {
    $('#hotel-registration-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $button = $form.find('.submit-btn');
        var formData = {};
        
        $form.serializeArray().forEach(function(item) {
            formData[item.name] = item.value;
        });
        
        $button.prop('disabled', true).text('Processing...');
        
        // First, create WordPress user
        $.post('<?php echo admin_url('admin-ajax.php'); ?>', {
            action: 'staydesk_register_user',
            nonce: '<?php echo wp_create_nonce('staydesk_register'); ?>',
            data: formData
        }, function(response) {
            if (response.success) {
                // Redirect to payment
                var planType = formData.plan_type;
                var amount = planType === 'monthly' ? 49900 : 598800;
                initPaystackPayment(formData.email, amount, planType, response.data.hotel_id);
            } else {
                alert(response.data.message);
                $button.prop('disabled', false).text('Complete Registration & Proceed to Payment');
            }
        });
    });
});
</script>

<?php get_footer(); ?>
