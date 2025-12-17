<?php
/**
 * StayDesk Login Page
 */

// Check if user is already logged in
if (is_user_logged_in()) {
    wp_redirect(site_url('/staydesk/dashboard'));
    exit;
}

get_header();
?>

<div class="bendlesstech-hero" style="padding: 60px 0;">
    <div class="bendlesstech-container">
        <h1>Hotel Login</h1>
        <p>Access your StayDesk dashboard</p>
    </div>
</div>

<section style="padding: 80px 0; background: #f9f9f9;">
    <div class="bendlesstech-container">
        <div class="bendlesstech-form" style="max-width: 500px;">
            <h3>Login to Your Account</h3>
            
            <?php
            $login_url = wp_login_url(site_url('/staydesk/dashboard'));
            ?>
            
            <form method="post" action="<?php echo esc_url($login_url); ?>">
                <div class="form-group">
                    <label for="log">Username or Email</label>
                    <input type="text" name="log" id="log" required>
                </div>
                
                <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" name="pwd" id="pwd" required>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="rememberme" value="forever">
                        <span>Remember Me</span>
                    </label>
                </div>
                
                <input type="hidden" name="redirect_to" value="<?php echo site_url('/staydesk/dashboard'); ?>">
                
                <button type="submit" class="submit-btn">Login</button>
                
                <p style="text-align: center; margin-top: 20px; color: #666;">
                    <a href="<?php echo wp_lostpassword_url(); ?>">Forgot Password?</a>
                </p>
                
                <p style="text-align: center; margin-top: 10px; color: #666;">
                    Don't have an account? <a href="<?php echo site_url('/staydesk/register'); ?>">Register here</a>
                </p>
            </form>
        </div>
    </div>
</section>

<?php get_footer(); ?>
