<?php
/**
 * Template Name: BendlessTech Homepage
 */

get_header();
?>

<div class="bendlesstech-hero">
    <div class="bendlesstech-container">
        <h1>Technology that bends to your business.</h1>
        <p>Custom solutions built for Nigerian businesses. Fast delivery. Fair pricing.</p>
        <p class="subtext">From ₦750,000 | 2-week delivery</p>
        <a href="#services" class="cta-button">View our services</a>
    </div>
</div>

<section id="services" class="bendlesstech-services">
    <div class="bendlesstech-wide-container">
        <h2>Three ways we can help.</h2>
        <p class="section-subtitle">Professional solutions for modern Nigerian businesses.</p>
        <div class="services-grid">
            
            <div class="service-card">
                <div class="service-card-image">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="8" y="12" width="48" height="36" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M8 20h48M16 16h2M22 16h2" stroke="currentColor" stroke-width="2"/>
                        <rect x="14" y="26" width="36" height="2" fill="currentColor"/>
                        <rect x="14" y="32" width="28" height="2" fill="currentColor"/>
                        <rect x="14" y="38" width="32" height="2" fill="currentColor"/>
                    </svg>
                </div>
                <h3>Custom Website Development</h3>
                <p class="price">From ₦750,000</p>
                <p class="delivery">2-week delivery • 15-min quote response</p>
                <p>Professional websites that put your business online and attract customers 24/7. Mobile-responsive, SEO-optimized, and built for the Nigerian market.</p>
                <ul>
                    <li>Modern, professional design</li>
                    <li>Mobile-responsive layout</li>
                    <li>Search engine optimized</li>
                    <li>Advanced online visibility</li>
                    <li>2-week delivery guarantee</li>
                </ul>
                <a href="<?php echo site_url('/custom-website-development'); ?>" class="learn-more">Learn more</a>
            </div>
            
            <div class="service-card">
                <div class="service-card-image">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="12" y="16" width="40" height="32" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M18 24h12M18 30h16M18 36h10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="42" cy="30" r="6" stroke="currentColor" stroke-width="2"/>
                        <path d="M42 27v6M39 30h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3>Secure Inventory System</h3>
                <p class="price">From ₦900,000</p>
                <p class="delivery">4-week delivery • 15-min quote response</p>
                <p>Stop losing money to manual tracking. Custom inventory systems built to match your business structure—not the other way around.</p>
                <ul>
                    <li>Custom-built to your workflow</li>
                    <li>Real-time stock tracking</li>
                    <li>Multi-user access control</li>
                    <li>Detailed analytics & reports</li>
                    <li>4-week delivery guarantee</li>
                </ul>
                <a href="<?php echo site_url('/secure-inventory-system'); ?>" class="learn-more">Learn more</a>
            </div>
            
            <div class="service-card">
                <div class="service-card-image">
                    <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="16" y="12" width="32" height="40" rx="2" stroke="currentColor" stroke-width="2"/>
                        <circle cx="32" cy="28" r="6" stroke="currentColor" stroke-width="2"/>
                        <path d="M24 40c0-4.4 3.6-8 8-8s8 3.6 8 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <rect x="20" y="16" width="24" height="2" fill="currentColor"/>
                    </svg>
                </div>
                <h3>StayDesk Hotel Assistant</h3>
                <p class="price">₦49,900/month</p>
                <p class="delivery">Yearly: ₦598,800 • 10% off for first 10 hotels</p>
                <p>Complete hotel management with booking engine, payment tracking, and bilingual chat widget. English and Nigerian Pidgin supported.</p>
                <ul>
                    <li>Manage bookings & payments</li>
                    <li>Real-time availability tracking</li>
                    <li>Automated customer chat</li>
                    <li>Revenue analytics & reports</li>
                    <li>Start today</li>
                </ul>
                <a href="<?php echo site_url('/staydesk'); ?>" class="learn-more">Learn more</a>
            </div>
            
        </div>
    </div>
</section>

<section class="bendlesstech-value">
    <div class="bendlesstech-container">
        <h2>Why Bendless?</h2>
        <div style="max-width: 700px; margin: 0 auto;">
            <p>
                <strong>We're called "Bendless" for a reason.</strong> Most companies build one-size-fits-all solutions that force you to change how you work. We don't do that.
            </p>
            <p>
                At BendlessTech, we build custom solutions that adapt to your business structure, your workflow, and your needs. Technology should bend to fit your business—not the other way around.
            </p>
            <p>
                <strong>Fast response. Faster delivery.</strong> We respond to quotes in 15 minutes via WhatsApp. We deliver websites in 2 weeks and inventory systems in 4 weeks.
            </p>
            <p>
                <strong>Built for Nigerian businesses.</strong> We understand the Nigerian market and what you need to succeed. Every solution is designed with Nigerian businesses in mind.
            </p>
        </div>
    </div>
</section>

<section class="bendlesstech-cta">
    <div class="bendlesstech-container">
        <h2>Ready to get started?</h2>
        <p>Get a quote in 15 minutes. Contact us via WhatsApp or email.</p>
        <div class="button-group">
            <a href="https://wa.me/2347120018023" class="btn btn-primary">
                WhatsApp: 07120018023
            </a>
            <a href="<?php echo site_url('/contact'); ?>" class="btn btn-secondary">
                Contact us
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
