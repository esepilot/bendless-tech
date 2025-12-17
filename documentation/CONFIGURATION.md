# BendlessTech Platform Configuration Guide

## Overview
This guide covers configuration options for all BendlessTech plugins after installation.

---

## BendlessTech Core Plugin Configuration

### Contact Information

Update contact details in `plugins/bendlesstech-core/includes/class-email.php`:

```php
private $to = 'reach@bendlesstech.com';  // Change to your email
```

Update WhatsApp number in `plugins/bendlesstech-core/includes/class-whatsapp.php`:

```php
private $phone = '2347120018023';  // Your WhatsApp number in international format
```

### Lead Management

Access lead dashboard at: `yourdomain.com?bendlesstech_admin=dashboard`

**Note:** Only users with Administrator role can access this dashboard.

### Custom Post Types

The plugin creates these custom post types:
- **Services** (bt_service)
- **Testimonials** (bt_testimonial)
- **FAQs** (bt_faq)

Add content via WordPress admin: **Posts** → **Services/Testimonials/FAQs**

---

## StayDesk Platform Configuration

### Paystack API Keys

**Option 1: WordPress Admin (Recommended)**
If settings page exists, configure via admin panel.

**Option 2: wp-config.php**
Add these lines to `wp-config.php`:

```php
// Paystack Configuration
define('STAYDESK_PAYSTACK_PUBLIC_KEY', 'pk_test_xxxxxxxxxxxxx'); // Test key
define('STAYDESK_PAYSTACK_SECRET_KEY', 'sk_test_xxxxxxxxxxxxx'); // Test key

// For production, use live keys:
// define('STAYDESK_PAYSTACK_PUBLIC_KEY', 'pk_live_xxxxxxxxxxxxx');
// define('STAYDESK_PAYSTACK_SECRET_KEY', 'sk_live_xxxxxxxxxxxxx');
```

### Subscription Pricing

Pricing is defined in `plugins/staydesk-platform/staydesk-platform.php`:

```php
define('STAYDESK_MONTHLY_PRICE', 49900);  // ₦49,900
define('STAYDESK_YEARLY_PRICE', 598800);  // ₦598,800
define('STAYDESK_YEARLY_DISCOUNT', 0.10); // 10% discount
```

To change pricing:
1. Update these constants
2. Deactivate and reactivate the plugin
3. Clear any caches

### Hotel Registration

Hotels can register at: `yourdomain.com/staydesk/register`

Registration requires:
- Hotel information
- Contact details
- Plan selection (Monthly/Yearly)
- Payment via Paystack

### Dashboard Access

Hotels access their dashboard at: `yourdomain.com/staydesk/dashboard`

Dashboard sections:
- `/staydesk/dashboard` - Overview
- `/staydesk/dashboard/bookings` - Manage bookings
- `/staydesk/dashboard/rooms` - Room management
- `/staydesk/dashboard/payments` - Payment tracking
- `/staydesk/dashboard/guests` - Guest management
- `/staydesk/dashboard/reports` - Analytics
- `/staydesk/dashboard/chat-widget` - Widget setup
- `/staydesk/dashboard/settings` - Hotel settings
- `/staydesk/dashboard/subscription` - Subscription management

---

## StayDesk Chat Widget Configuration

### Generating Embed Code

Hotels get their unique embed code from the dashboard:
`/staydesk/dashboard/chat-widget`

**Embed code format:**
```html
<script src="https://yourdomain.com/wp-content/plugins/staydesk-chat-widget/assets/js/widget-embed.js" 
        data-hotel-id="123"></script>
```

### Widget Customization

**Colors:**
Modify widget colors in `plugins/staydesk-chat-widget/assets/css/widget.css`:

```css
.staydesk-widget-button {
    background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
}

.staydesk-widget-header {
    background: linear-gradient(135deg, #1a73e8 0%, #0d47a1 100%);
}
```

**Language:**
The widget automatically detects language (English/Pidgin) or allows manual switching.

### Response Templates

Add custom responses in `plugins/staydesk-chat-widget/includes/class-responses.php`

Example:
```php
public function get_custom_response($language) {
    if ($language === 'pidgin') {
        return "Your Pidgin response here";
    } else {
        return "Your English response here";
    }
}
```

---

## Email Configuration

### SMTP Setup (Recommended)

Install and configure WP Mail SMTP plugin:

1. Install **WP Mail SMTP** plugin
2. Go to **WP Mail SMTP** → **Settings**
3. Configure with your SMTP provider:

**Gmail Example:**
- SMTP Host: `smtp.gmail.com`
- Encryption: SSL
- SMTP Port: 465
- SMTP Username: `your-email@gmail.com`
- SMTP Password: `your-app-password`

**Popular SMTP Services:**
- Gmail (Google Workspace)
- SendGrid
- Mailgun
- Amazon SES
- Sendinblue

### Email Templates

Email templates are defined in:
- `plugins/bendlesstech-core/includes/class-email.php` (Core plugin)
- `plugins/staydesk-platform/includes/class-booking.php` (Booking confirmations)

Customize HTML email templates in these files.

---

## Security Configuration

### API Key Security

Never commit API keys to version control. Store in:
1. `wp-config.php` (recommended)
2. Environment variables
3. WordPress options (encrypted)

### User Roles & Permissions

**BendlessTech Admin:**
- Role: Administrator
- Can access lead dashboard
- Can manage all settings

**Hotel Owners:**
- Role: Subscriber (with custom capabilities)
- Can access hotel dashboard only
- Cannot access WordPress admin

### CORS Configuration

If widget needs to work on external domains, configure CORS headers.

---

## Performance Configuration

### Caching

**Recommended Caching Plugin:**
- WP Super Cache
- W3 Total Cache
- WP Rocket (premium)

**Cache Exclusions:**
Add these to cache exclusions:
- `/staydesk/dashboard/*`
- `/staydesk/register`
- `/staydesk/login`
- Admin-ajax calls

### Database Optimization

Run these queries periodically to optimize:

```sql
-- Clean old conversations (older than 90 days)
DELETE FROM wp_staydesk_conversations 
WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Optimize tables
OPTIMIZE TABLE wp_bt_leads;
OPTIMIZE TABLE wp_staydesk_hotels;
OPTIMIZE TABLE wp_staydesk_bookings;
OPTIMIZE TABLE wp_staydesk_payments;
```

### Asset Optimization

1. Minify CSS and JavaScript in production
2. Enable gzip compression
3. Use CDN for assets if needed
4. Optimize images

---

## Backup Configuration

### Recommended Backup Solutions

**Plugins:**
- UpdraftPlus
- BackWPup
- Duplicator

**What to Backup:**
- WordPress database (all tables)
- wp-content/plugins/
- wp-content/uploads/
- wp-config.php

**Backup Schedule:**
- Daily: Database
- Weekly: Full site
- Before: Major updates

---

## Monitoring & Logging

### Enable WordPress Debug

For development only, add to `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

Debug log location: `wp-content/debug.log`

### Monitor Key Metrics

- Server uptime
- Page load times
- Database query performance
- Error logs
- Payment success rates
- Email delivery rates

---

## Maintenance Mode

Use maintenance plugin during updates:
- WP Maintenance Mode
- Coming Soon & Maintenance Mode

Display custom message:
"We're updating BendlessTech. We'll be back shortly!"

---

## Multi-Site Configuration

If running WordPress Multisite:

1. Network activate plugins
2. Configure per-site settings
3. Ensure database prefixes are correct
4. Test thoroughly on each site

---

## Support

For configuration assistance:
- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023

---

*Last Updated: December 2024*
