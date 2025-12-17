# BendlessTech WordPress Platform - Installation Package

## Package Contents

This release contains three WordPress plugins:

1. **bendlesstech-core.zip** - Core plugin for BendlessTech website
2. **staydesk-platform.zip** - Hotel management platform
3. **staydesk-chat-widget.zip** - Bilingual chat widget

## Quick Installation

### Option 1: Individual Plugin Installation (Recommended)

1. Log in to your WordPress admin dashboard
2. Go to **Plugins** → **Add New** → **Upload Plugin**
3. Upload each zip file one at a time:
   - First: `bendlesstech-core.zip`
   - Second: `staydesk-platform.zip`
   - Third: `staydesk-chat-widget.zip`
4. Click **Install Now** for each
5. Activate each plugin after installation

### Option 2: Manual Installation via FTP

1. Extract each zip file
2. Upload the extracted folders to `wp-content/plugins/`:
   - `bendlesstech-core/`
   - `staydesk-platform/`
   - `staydesk-chat-widget/`
3. Go to WordPress admin → **Plugins**
4. Activate all three plugins

## System Requirements

- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+
- SSL Certificate (required for payments)

## Post-Installation Steps

1. **Configure Contact Information:**
   - Update email in `bendlesstech-core/includes/class-email.php`
   - Update WhatsApp in `bendlesstech-core/includes/class-whatsapp.php`

2. **Set Up Paystack (for StayDesk):**
   - Get API keys from https://paystack.com
   - Add to `wp-config.php`:
     ```php
     define('STAYDESK_PAYSTACK_PUBLIC_KEY', 'your_public_key');
     define('STAYDESK_PAYSTACK_SECRET_KEY', 'your_secret_key');
     ```

3. **Configure Permalinks:**
   - Go to **Settings** → **Permalinks**
   - Select **Post name**
   - Click **Save Changes**

4. **Set Up Email:**
   - Install WP Mail SMTP plugin
   - Configure SMTP settings for reliable email delivery

## Plugin Features

### BendlessTech Core
- Lead capture forms
- WhatsApp floating button
- Email notifications
- Marketing pages (Homepage, Services, About, Contact, Privacy, Terms)
- Frontend admin dashboard
- **Shortcode support** - Embed pages anywhere: `[bendlesstech_home]`, `[bendlesstech_contact]`, etc.

### StayDesk Platform
- Multi-tenant hotel management
- Booking engine
- Payment processing via Paystack
- Hotel dashboard with 9 sections
- Monthly plan: ₦49,900
- Yearly plan: ₦598,800 (10% off for first 10)
- **Shortcode support** - Embed registration, dashboard: `[staydesk_register]`, `[staydesk_dashboard]`, etc.

### StayDesk Chat Widget
- Bilingual: English + Nigerian Pidgin
- 50+ response templates
- Automatic booking assistance
- FAQ matching
- Embeddable on any website

## Support

- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023

## Documentation

For detailed documentation, see:
- `INSTALLATION.md` - Full installation guide
- `CONFIGURATION.md` - Configuration options
- `VIEWING-PAGES.md` - How to access frontend pages
- `SHORTCODES.md` - Complete shortcode reference
- `IMPLEMENTATION-SUMMARY.md` - Complete feature overview

## Version

Version: 1.0.0
Release Date: December 2024

---

**Built for Nigerian businesses with ❤️ by BendlessTech**
