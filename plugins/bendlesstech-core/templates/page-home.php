<?php
/**
 * Template Name: BendlessTech Homepage
 */

get_header();
?>

<div class="bendlesstech-hero">
    <div class="bendlesstech-container">
        <h1>Transform Your Business with Custom Tech Solutions</h1>
        <p>We build websites and inventory systems that don't make your business bend to fit the software—the software bends to fit your business.</p>
        <a href="#services" class="cta-button">Explore Our Services</a>
    </div>
</div>

<section id="services" class="bendlesstech-services">
    <div class="bendlesstech-container">
        <h2>Our Services</h2>
        <div class="services-grid">
            
            <div class="service-card">
                <h3>Custom Website Development</h3>
                <p class="price">From ₦750,000</p>
                <p class="delivery">⚡ 2-Week Delivery | 15-Minute Quote Response</p>
                <p>Get a professional website that puts your business online and attracts customers 24/7. In today's Nigeria, businesses without websites are losing customers to competitors every single day.</p>
                <ul style="margin: 20px 0; padding-left: 20px;">
                    <li>Professional, modern design</li>
                    <li>Mobile-responsive</li>
                    <li>SEO optimized</li>
                    <li>Advanced Online Visibility</li>
                    <li>2-week delivery guarantee</li>
                </ul>
                <a href="<?php echo site_url('/custom-website-development'); ?>" class="learn-more">Learn More & Get Quote</a>
            </div>
            
            <div class="service-card">
                <h3>Complete Secure Inventory System</h3>
                <p class="price">From ₦900,000</p>
                <p class="delivery">⚡ 4-Week Delivery | 15-Minute Quote Response</p>
                <p>Stop losing money to manual inventory management. Nigerian businesses lose millions yearly to stock discrepancies, theft, and poor tracking. Our custom inventory system saves you money from day one.</p>
                <ul style="margin: 20px 0; padding-left: 20px;">
                    <li>Custom-built to YOUR structure</li>
                    <li>Real-time stock tracking</li>
                    <li>Multi-user access control</li>
                    <li>Detailed reporting & analytics</li>
                    <li>4-week delivery guarantee</li>
                </ul>
                <a href="<?php echo site_url('/secure-inventory-system'); ?>" class="learn-more">Learn More & Get Quote</a>
            </div>
            
            <div class="service-card">
                <h3>StayDesk Hotel Assistant</h3>
                <p class="price">₦49,900/month</p>
                <p class="delivery">🎉 10% Off Yearly Plan for First 10 Hotels!</p>
                <p>Complete hotel management platform with booking engine, payment tracking, and an intelligent chat widget that answers customer questions in English and Nigerian Pidgin—automatically!</p>
                <ul style="margin: 20px 0; padding-left: 20px;">
                    <li>Manage bookings & payments</li>
                    <li>Track room availability</li>
                    <li>Automated customer chat</li>
                    <li>Revenue analytics & reports</li>
                    <li>Yearly plan: ₦598,800 (Save 10%!)</li>
                </ul>
                <a href="<?php echo site_url('/staydesk'); ?>" class="learn-more">Learn More</a>
            </div>
            
        </div>
    </div>
</section>

<section class="bendlesstech-value" style="padding: 80px 0; background: white;">
    <div class="bendlesstech-container">
        <h2 style="text-align: center; font-size: 36px; margin-bottom: 30px;">Why Choose BendlessTech?</h2>
        <div style="max-width: 800px; margin: 0 auto; font-size: 18px; line-height: 1.8; color: #666;">
            <p style="margin-bottom: 20px;">
                <strong style="color: #1a73e8;">We're called "Bendless" for a reason.</strong> Most software companies build one-size-fits-all solutions that force businesses to change their processes to match the software. We don't do that.
            </p>
            <p style="margin-bottom: 20px;">
                At BendlessTech, we build custom solutions that adapt to YOUR business structure, YOUR workflow, and YOUR needs. You shouldn't have to bend your business to fit technology—technology should bend to fit your business.
            </p>
            <p style="margin-bottom: 20px;">
                <strong style="color: #1a73e8;">Fast Response, Faster Delivery:</strong> We respond to quotes in 15 minutes via WhatsApp. We deliver websites in 2 weeks and inventory systems in 4 weeks. No delays, no excuses.
            </p>
            <p>
                <strong style="color: #1a73e8;">Built for Nigerian Businesses:</strong> We understand the Nigerian market, the challenges you face, and what you need to succeed. Every solution we build is designed with Nigerian businesses in mind.
            </p>
        </div>
    </div>
</section>

<section style="padding: 60px 0; background: #1a73e8; color: white; text-align: center;">
    <div class="bendlesstech-container">
        <h2 style="font-size: 36px; margin-bottom: 20px;">Ready to Transform Your Business?</h2>
        <p style="font-size: 20px; margin-bottom: 30px; opacity: 0.95;">Get a quote in 15 minutes. Contact us via WhatsApp or email.</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="https://wa.me/2347120018023" style="display: inline-block; padding: 16px 40px; background: #25d366; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                WhatsApp: 07120018023
            </a>
            <a href="<?php echo site_url('/contact'); ?>" style="display: inline-block; padding: 16px 40px; background: white; color: #1a73e8; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                Contact Us
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
