# BendlessTech Platform Installation Guide

## Overview
This guide will help you install and set up the complete BendlessTech WordPress platform, including all three custom plugins.

---

## System Requirements

### Server Requirements
- **WordPress:** Version 6.0 or higher
- **PHP:** Version 8.0 or higher
- **MySQL:** Version 5.7 or higher (or MariaDB 10.2+)
- **HTTPS:** SSL certificate (required for payment processing)

### Recommended Server Specifications
- **Memory:** 256MB minimum, 512MB+ recommended
- **Disk Space:** 100MB+ for plugins
- **PHP Extensions:**
  - mysqli
  - json
  - curl
  - mbstring
  - openssl

---

## Installation Steps

### Step 1: Prepare WordPress Installation

1. Ensure you have a fresh or existing WordPress installation
2. Verify your WordPress meets the system requirements
3. Backup your database and files before proceeding

### Step 2: Upload Plugins

Upload the three plugin folders to your WordPress `wp-content/plugins/` directory:

```
wp-content/plugins/
├── bendlesstech-core/
├── staydesk-platform/
└── staydesk-chat-widget/
```

**Methods to upload:**
- FTP/SFTP client (FileZilla, Cyberduck)
- cPanel File Manager
- SSH/command line
- WordPress plugin uploader (if zipped)

### Step 3: Activate Plugins

1. Log in to WordPress admin dashboard
2. Navigate to **Plugins** → **Installed Plugins**
3. Activate plugins in this order:
   - **BendlessTech Core** (activate first)
   - **StayDesk Hotel Platform**
   - **StayDesk Chat Widget**

**Note:** The activation order is important as some plugins depend on database tables created by others.

### Step 4: Verify Database Tables

After activation, verify that database tables were created successfully. You should see these new tables in your database:

**BendlessTech Core:**
- `wp_bt_leads`

**StayDesk Platform:**
- `wp_staydesk_hotels`
- `wp_staydesk_rooms`
- `wp_staydesk_bookings`
- `wp_staydesk_guests`
- `wp_staydesk_payments`
- `wp_staydesk_subscriptions`
- `wp_staydesk_refunds`
- `wp_staydesk_conversations`

### Step 5: Configure Permalinks

1. Go to **Settings** → **Permalinks**
2. Select **Post name** or **Custom Structure**
3. Click **Save Changes**
4. This ensures custom URLs work correctly (e.g., `/staydesk/dashboard`)

### Step 6: Create Required Pages

The plugins automatically create some pages, but verify these exist:

**Core Plugin Pages:**
- Home (slug: `home`)
- Custom Website Development (slug: `custom-website-development`)
- Secure Inventory System (slug: `secure-inventory-system`)
- About (slug: `about`)
- Contact (slug: `contact`)
- Privacy Policy (slug: `privacy-policy`)
- Terms of Service (slug: `terms-of-service`)

**StayDesk Pages:**
- StayDesk (slug: `staydesk`)

### Step 7: Configure Paystack (For StayDesk)

1. Sign up for a Paystack account at https://paystack.com
2. Get your API keys (Test and Live) from Paystack Dashboard
3. In WordPress admin, go to **Settings** → **StayDesk Settings** (if available)
4. Or add these to `wp-config.php`:
   ```php
   define('STAYDESK_PAYSTACK_PUBLIC_KEY', 'your_public_key');
   define('STAYDESK_PAYSTACK_SECRET_KEY', 'your_secret_key');
   ```

### Step 8: Configure Email Settings

1. Go to **Settings** → **General**
2. Set your **Site Title** (BendlessTech)
3. Set your **Administration Email Address** (reach@bendlesstech.com)
4. Consider installing an SMTP plugin for reliable email delivery:
   - WP Mail SMTP (recommended)
   - Post SMTP
   - Easy WP SMTP

### Step 9: Set Homepage

1. Go to **Settings** → **Reading**
2. Select **A static page** for homepage
3. Choose the "Home" page as your homepage
4. Save changes

### Step 10: Test Functionality

**Test BendlessTech Core:**
- Visit homepage
- Test lead capture forms
- Verify WhatsApp button appears (bottom-right)
- Submit a test form and check email reception

**Test StayDesk Platform:**
- Visit `/staydesk`
- Test registration flow
- Log in to dashboard
- Add a test hotel and room

**Test Chat Widget:**
- Get embed code from dashboard
- Test widget on a page
- Try both English and Pidgin responses

---

## Post-Installation Configuration

### 1. WordPress Settings

**General Settings:**
- Set timezone to Africa/Lagos
- Choose appropriate date/time format

**Discussion Settings:**
- Configure comment settings as needed

**Media Settings:**
- Set appropriate image sizes

### 2. Create Admin User

Create a dedicated admin user for BendlessTech staff:
1. Go to **Users** → **Add New**
2. Username: `bendlesstech_admin`
3. Role: Administrator
4. Email: reach@bendlesstech.com

### 3. Security Hardening

- Install security plugin (Wordfence, Sucuri, etc.)
- Enable two-factor authentication
- Limit login attempts
- Keep WordPress, plugins, and themes updated
- Use strong passwords
- Regular backups

### 4. Performance Optimization

- Install caching plugin (WP Super Cache, W3 Total Cache)
- Enable gzip compression
- Optimize images
- Use CDN if needed
- Minify CSS and JavaScript

### 5. SSL Certificate

- Ensure SSL certificate is installed and active
- Update WordPress and site URLs to use https://
- Force SSL for admin area

---

## Troubleshooting

### Database Tables Not Created

1. Check file permissions
2. Verify MySQL user has CREATE TABLE privileges
3. Deactivate and reactivate plugins
4. Check WordPress debug log

### Rewrite Rules Not Working

1. Go to **Settings** → **Permalinks**
2. Click **Save Changes** without making changes
3. Verify `.htaccess` is writable (if using Apache)
4. Check if mod_rewrite is enabled

### Email Not Sending

1. Install SMTP plugin
2. Configure with valid SMTP credentials
3. Test email sending
4. Check spam folder

### CSS/JS Not Loading

1. Clear browser cache
2. Clear WordPress cache (if caching plugin installed)
3. Check file permissions
4. Verify file paths in browser developer tools

### Paystack Integration Issues

1. Verify API keys are correct
2. Check if you're using test/live keys appropriately
3. Ensure SSL is enabled (required by Paystack)
4. Check Paystack dashboard for error logs

---

## Support

For installation support:
- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023

---

## Next Steps

After installation, proceed to:
- [Configuration Guide](CONFIGURATION.md)
- [User Guide](USER-GUIDE.md)
- [Hotel Guide](HOTEL-GUIDE.md) (for StayDesk hotels)

---

*Last Updated: December 2024*
