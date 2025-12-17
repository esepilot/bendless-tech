<?php
/**
 * StayDesk Landing/Sales Page
 */

get_header();
?>

<div class="bendlesstech-hero">
    <div class="bendlesstech-container">
        <h1>StayDesk - Complete Hotel Management Platform</h1>
        <p>Manage bookings, payments, guests, and more—all in one place</p>
        <p style="font-size: 18px; margin-top: 20px;">🎉 Special Offer: 10% OFF Yearly Plans for the First 10 Hotels!</p>
    </div>
</div>

<section style="padding: 80px 0; background: white;">
    <div class="bendlesstech-container">
        <h2 style="text-align: center; font-size: 36px; margin-bottom: 50px;">Why Choose StayDesk?</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">📅</div>
                <h3 style="margin-bottom: 15px;">Booking Management</h3>
                <p style="color: #666;">Easily manage all your bookings, cancellations, and modifications in one dashboard.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">💳</div>
                <h3 style="margin-bottom: 15px;">Payment Tracking</h3>
                <p style="color: #666;">Track all payments, generate receipts, and manage refunds seamlessly.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">🏨</div>
                <h3 style="margin-bottom: 15px;">Room Management</h3>
                <p style="color: #666;">Manage room types, pricing, availability, and amenities effortlessly.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">👥</div>
                <h3 style="margin-bottom: 15px;">Guest Management</h3>
                <p style="color: #666;">Keep track of all guests, their preferences, and booking history.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">📊</div>
                <h3 style="margin-bottom: 15px;">Analytics & Reports</h3>
                <p style="color: #666;">Get insights on revenue, occupancy rates, and business performance.</p>
            </div>
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 20px;">💬</div>
                <h3 style="margin-bottom: 15px;">Intelligent Chat Widget</h3>
                <p style="color: #666;">Automated chat widget that answers customer questions in English and Nigerian Pidgin!</p>
            </div>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: #f9f9f9;">
    <div class="bendlesstech-container">
        <h2 style="text-align: center; font-size: 36px; margin-bottom: 20px;">Simple, Transparent Pricing</h2>
        <p style="text-align: center; font-size: 18px; color: #666; margin-bottom: 50px;">Choose the plan that works for you. No hidden fees.</p>
        
        <div class="pricing-table">
            <div class="pricing-card">
                <h3>Monthly Plan</h3>
                <div class="price">₦49,900</div>
                <div class="period">/month</div>
                <ul>
                    <li>Complete booking management</li>
                    <li>Payment tracking & receipts</li>
                    <li>Room & guest management</li>
                    <li>Revenue analytics</li>
                    <li>Chat widget (English + Pidgin)</li>
                    <li>Email support</li>
                    <li>Cancel anytime</li>
                </ul>
                <a href="<?php echo site_url('/staydesk/register?plan=monthly'); ?>" class="btn btn-primary" style="width: 100%;">
                    Start Monthly Plan
                </a>
            </div>
            
            <div class="pricing-card featured">
                <div class="discount-badge">10% OFF for First 10!</div>
                <h3>Yearly Plan</h3>
                <div class="price">₦598,800</div>
                <div class="period">/year (Save ₦59,880 with discount!)</div>
                <ul>
                    <li>Everything in Monthly Plan</li>
                    <li>2 months FREE</li>
                    <li>Priority support</li>
                    <li>Advanced analytics</li>
                    <li>Custom branding options</li>
                    <li>Dedicated account manager</li>
                    <li><strong>10% discount for first 10 hotels!</strong></li>
                </ul>
                <a href="<?php echo site_url('/staydesk/register?plan=yearly'); ?>" class="btn btn-success" style="width: 100%;">
                    Start Yearly Plan
                </a>
            </div>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: white;">
    <div class="bendlesstech-container">
        <h2 style="text-align: center; font-size: 36px; margin-bottom: 50px;">How It Works</h2>
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="display: flex; gap: 30px; margin-bottom: 40px; align-items: start;">
                <div style="background: #1a73e8; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; flex-shrink: 0;">1</div>
                <div>
                    <h3 style="margin-bottom: 10px;">Sign Up & Set Up Your Hotel</h3>
                    <p style="color: #666;">Create your account, enter your hotel details, and add your room types and pricing.</p>
                </div>
            </div>
            <div style="display: flex; gap: 30px; margin-bottom: 40px; align-items: start;">
                <div style="background: #1a73e8; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; flex-shrink: 0;">2</div>
                <div>
                    <h3 style="margin-bottom: 10px;">Customize Your Dashboard</h3>
                    <p style="color: #666;">Add your FAQs, policies, and amenities. Customize your chat widget to match your brand.</p>
                </div>
            </div>
            <div style="display: flex; gap: 30px; margin-bottom: 40px; align-items: start;">
                <div style="background: #1a73e8; color: white; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; flex-shrink: 0;">3</div>
                <div>
                    <h3 style="margin-bottom: 10px;">Start Managing Bookings</h3>
                    <p style="color: #666;">Accept bookings, track payments, manage guests, and let the chat widget handle customer questions automatically.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: #1a73e8; color: white; text-align: center;">
    <div class="bendlesstech-container">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Transform Your Hotel Management?</h2>
        <p style="font-size: 20px; margin-bottom: 30px; opacity: 0.95;">Join StayDesk today and start managing your hotel efficiently.</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="<?php echo site_url('/staydesk/register'); ?>" style="display: inline-block; padding: 16px 40px; background: white; color: #1a73e8; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                Get Started Free
            </a>
            <a href="<?php echo site_url('/contact'); ?>" style="display: inline-block; padding: 16px 40px; background: transparent; color: white; border: 2px solid white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                Contact Sales
            </a>
        </div>
        <p style="margin-top: 30px; font-size: 14px; opacity: 0.8;">No credit card required • Cancel anytime • 10% discount for first 10 yearly subscribers</p>
    </div>
</section>

<?php get_footer(); ?>
