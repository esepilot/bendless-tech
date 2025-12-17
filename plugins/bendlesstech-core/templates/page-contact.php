<?php
/**
 * Template Name: Contact Page
 */

get_header();
?>

<div class="bendlesstech-hero" style="padding: 80px 0;">
    <div class="bendlesstech-container">
        <h1>Contact Us</h1>
        <p>We're here to help. Reach out via WhatsApp or email.</p>
    </div>
</div>

<section style="padding: 80px 0; background: #f9f9f9;">
    <div class="bendlesstech-container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px; max-width: 1000px; margin: 0 auto 60px;">
            <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 80px; height: 80px; background: #25d366; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                    📱
                </div>
                <h3 style="margin-bottom: 15px; color: #333;">WhatsApp</h3>
                <p style="color: #666; margin-bottom: 20px;">Fastest way to reach us</p>
                <a href="https://wa.me/2347120018023" style="display: inline-block; padding: 12px 30px; background: #25d366; color: white; text-decoration: none; border-radius: 6px; font-weight: 600;">
                    07120018023
                </a>
            </div>
            
            <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center;">
                <div style="width: 80px; height: 80px; background: #1a73e8; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 36px;">
                    ✉️
                </div>
                <h3 style="margin-bottom: 15px; color: #333;">Email</h3>
                <p style="color: #666; margin-bottom: 20px;">For detailed inquiries</p>
                <a href="mailto:reach@bendlesstech.com" style="display: inline-block; padding: 12px 30px; background: #1a73e8; color: white; text-decoration: none; border-radius: 6px; font-weight: 600;">
                    reach@bendlesstech.com
                </a>
            </div>
        </div>
        
        <div class="bendlesstech-form">
            <h3>Send Us a Message</h3>
            <p style="color: #666; margin-bottom: 30px;">Fill out this form and we'll get back to you as soon as possible.</p>
            
            <form id="contact-form">
                <div class="form-group">
                    <label for="name">Your Name *</label>
                    <input type="text" name="name" id="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" name="email" id="email" required>
                </div>
                
                <div class="form-group">
                    <label for="whatsapp">WhatsApp Number</label>
                    <input type="tel" name="whatsapp" id="whatsapp" placeholder="e.g., 08012345678">
                    <span class="helper-text">Optional - if you prefer WhatsApp contact</span>
                </div>
                
                <div class="form-group">
                    <label for="message">Your Message *</label>
                    <textarea name="message" id="message" required placeholder="Tell us how we can help you..."></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</section>

<section style="padding: 80px 0; background: white;">
    <div class="bendlesstech-container" style="text-align: center;">
        <h2 style="font-size: 32px; margin-bottom: 30px; color: #333;">Business Hours</h2>
        <p style="font-size: 18px; color: #666; max-width: 600px; margin: 0 auto;">
            We typically respond within 15 minutes during business hours (9 AM - 6 PM, Monday - Saturday). 
            For urgent matters, WhatsApp is the fastest way to reach us.
        </p>
    </div>
</section>

<?php get_footer(); ?>
