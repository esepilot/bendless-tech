# Shortcode Usage Guide

This guide explains how to use shortcodes to embed BendlessTech and StayDesk pages anywhere in your WordPress site.

---

## BendlessTech Core Shortcodes

### Main Shortcode

Use the main shortcode with the `type` parameter to embed any BendlessTech page:

```
[bendlesstech_page type="home"]
[bendlesstech_page type="website-service"]
[bendlesstech_page type="inventory-service"]
[bendlesstech_page type="about"]
[bendlesstech_page type="contact"]
[bendlesstech_page type="privacy"]
[bendlesstech_page type="terms"]
```

### Individual Shortcodes

For convenience, you can use individual shortcodes without parameters:

```
[bendlesstech_home]
[bendlesstech_website_service]
[bendlesstech_inventory_service]
[bendlesstech_about]
[bendlesstech_contact]
[bendlesstech_privacy]
[bendlesstech_terms]
```

### Examples

#### Embed Homepage in a Post
1. Create or edit a WordPress post
2. Add the shortcode: `[bendlesstech_home]`
3. Publish or update the post
4. The full homepage will be embedded in your post

#### Embed Service Page in a Custom Page
1. Create a new page in WordPress
2. Add the shortcode: `[bendlesstech_page type="website-service"]`
3. The Custom Website Development service page will be embedded

#### Create a Services Landing Page
Create a page and combine multiple shortcodes:
```
<h2>Our Services</h2>
<div class="services-container">
    [bendlesstech_website_service]
    [bendlesstech_inventory_service]
</div>
```

---

## StayDesk Platform Shortcodes

### Main Shortcode

Use the main shortcode with the `type` parameter to embed any StayDesk page:

```
[staydesk_page type="landing"]
[staydesk_page type="register"]
[staydesk_page type="login"]
[staydesk_page type="dashboard"]
```

### Dashboard Sections

To embed specific dashboard sections, use the `section` parameter:

```
[staydesk_page type="dashboard" section="bookings"]
[staydesk_page type="dashboard" section="rooms"]
[staydesk_page type="dashboard" section="payments"]
[staydesk_page type="dashboard" section="guests"]
[staydesk_page type="dashboard" section="reports"]
[staydesk_page type="dashboard" section="chat-widget"]
[staydesk_page type="dashboard" section="settings"]
[staydesk_page type="dashboard" section="subscription"]
```

### Individual Shortcodes

For convenience, you can use individual shortcodes:

```
[staydesk_landing]
[staydesk_register]
[staydesk_login]
[staydesk_dashboard]
[staydesk_dashboard section="bookings"]
```

### Examples

#### Embed StayDesk Landing Page
```
[staydesk_landing]
```

#### Create Custom Registration Page
1. Create a new WordPress page titled "Hotel Sign Up"
2. Add content and the shortcode:
```
<h1>Join StayDesk Today</h1>
<p>Sign up for our hotel management platform and get started in minutes!</p>
[staydesk_register]
```

#### Embed Dashboard in Member Area
```
[staydesk_dashboard]
```

**Note:** The dashboard shortcode will only display content for logged-in users. Visitors will see a login prompt.

#### Create Quick Links Page
```
<h2>Hotel Management Portal</h2>
<div class="portal-links">
    <h3>New Hotel?</h3>
    [staydesk_register]
    
    <h3>Existing Hotel?</h3>
    [staydesk_login]
</div>
```

---

## Advanced Usage

### Using Shortcodes in Widgets

1. Go to **Appearance** → **Widgets**
2. Add a **Text** or **HTML** widget
3. Paste your shortcode
4. Save the widget

Example widget content:
```
<h3>Get Started</h3>
<p>Register your hotel today!</p>
[staydesk_register]
```

### Using Shortcodes in Page Builders

Most page builders (Elementor, Divi, Beaver Builder, etc.) support shortcodes:

**Elementor:**
1. Add a **Shortcode** widget
2. Paste your shortcode
3. Style as needed

**Gutenberg:**
1. Add a **Shortcode** block
2. Paste your shortcode
3. Preview and publish

### Using Shortcodes in Template Files

If you're a developer and want to use shortcodes in your theme templates:

```php
<?php echo do_shortcode('[bendlesstech_home]'); ?>
```

Or:

```php
<?php echo do_shortcode('[staydesk_page type="dashboard" section="bookings"]'); ?>
```

### Combining with HTML/CSS

You can wrap shortcodes with custom HTML and CSS:

```html
<div class="custom-wrapper" style="background: #f5f5f5; padding: 20px;">
    <div class="container">
        [bendlesstech_contact]
    </div>
</div>
```

---

## Use Cases

### 1. Multi-Page Form Flow
Create a wizard-style form by embedding different pages on separate steps:

**Page 1: Introduction**
```
<h1>Welcome to BendlessTech</h1>
[bendlesstech_about]
<a href="/step-2">Next: Our Services →</a>
```

**Page 2: Services**
```
[bendlesstech_website_service]
[bendlesstech_inventory_service]
```

### 2. Embedded Dashboard for Members
Create a members-only page:

```
<!-- Only logged-in users see this -->
[staydesk_dashboard]
```

### 3. Landing Page Builder
Create a custom landing page combining multiple sections:

```
<!-- Hero Section -->
<div class="hero">
    <h1>Transform Your Hotel Business</h1>
</div>

<!-- Features -->
[staydesk_landing]

<!-- Call to Action -->
<div class="cta">
    <h2>Ready to Get Started?</h2>
    [staydesk_register]
</div>
```

### 4. Service Comparison Page
```
<div class="services-grid">
    <div class="service-col">
        [bendlesstech_website_service]
    </div>
    <div class="service-col">
        [bendlesstech_inventory_service]
    </div>
</div>
```

### 5. Quick Contact in Sidebar
Add to sidebar widget:
```
<h3>Get in Touch</h3>
[bendlesstech_contact]
```

---

## Shortcode Parameters Reference

### BendlessTech Core

| Shortcode | Parameters | Example |
|-----------|------------|---------|
| `[bendlesstech_page]` | `type` | `[bendlesstech_page type="home"]` |
| `[bendlesstech_home]` | None | `[bendlesstech_home]` |
| `[bendlesstech_website_service]` | None | `[bendlesstech_website_service]` |
| `[bendlesstech_inventory_service]` | None | `[bendlesstech_inventory_service]` |
| `[bendlesstech_about]` | None | `[bendlesstech_about]` |
| `[bendlesstech_contact]` | None | `[bendlesstech_contact]` |
| `[bendlesstech_privacy]` | None | `[bendlesstech_privacy]` |
| `[bendlesstech_terms]` | None | `[bendlesstech_terms]` |

**Valid `type` values:** `home`, `website-service`, `inventory-service`, `about`, `contact`, `privacy`, `terms`

### StayDesk Platform

| Shortcode | Parameters | Example |
|-----------|------------|---------|
| `[staydesk_page]` | `type`, `section` | `[staydesk_page type="dashboard" section="bookings"]` |
| `[staydesk_landing]` | None | `[staydesk_landing]` |
| `[staydesk_register]` | None | `[staydesk_register]` |
| `[staydesk_login]` | None | `[staydesk_login]` |
| `[staydesk_dashboard]` | `section` | `[staydesk_dashboard section="rooms"]` |

**Valid `type` values:** `landing`, `register`, `login`, `dashboard`

**Valid `section` values (for dashboard):** `bookings`, `rooms`, `payments`, `guests`, `reports`, `chat-widget`, `settings`, `subscription`

---

## Troubleshooting

### Shortcode Shows as Plain Text
**Problem:** The shortcode displays as `[bendlesstech_home]` instead of rendering the page.

**Solutions:**
1. Ensure the plugin is activated
2. Clear your cache (if using a caching plugin)
3. Verify you're using the correct shortcode syntax

### Styles Not Loading
**Problem:** The embedded page doesn't look right or is missing styles.

**Solutions:**
1. Clear browser cache
2. Check if CSS files are loaded (view page source)
3. Ensure no theme conflicts with plugin styles

### Dashboard Shortcode Not Working
**Problem:** Dashboard shortcode shows "Please log in" even when logged in.

**Solutions:**
1. Clear cookies and log in again
2. Check if you have the correct permissions
3. Verify the user account is properly linked to a hotel

### Form Submissions Not Working
**Problem:** Forms embedded via shortcode don't submit properly.

**Solutions:**
1. Check browser console for JavaScript errors
2. Ensure AJAX is working correctly
3. Verify nonce values are being generated

---

## Best Practices

1. **Use Individual Shortcodes:** They're cleaner and easier to remember
   - ✅ `[bendlesstech_home]`
   - ❌ `[bendlesstech_page type="home"]`

2. **Don't Nest Shortcodes:** Avoid putting shortcodes inside other shortcodes
   - ❌ `[bendlesstech_page type="[something]"]`

3. **Test Before Publishing:** Always preview pages before publishing

4. **Keep Pages Simple:** Don't embed too many full pages in one post

5. **Use for Specific Sections:** Shortcodes work best for targeted content placement

---

## Support

Need help with shortcodes?

- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023
- **Documentation:** See `/documentation` folder for more guides

---

## Quick Reference Card

**Print this section for quick reference:**

```
BendlessTech Pages:
[bendlesstech_home]
[bendlesstech_website_service]
[bendlesstech_inventory_service]
[bendlesstech_about]
[bendlesstech_contact]
[bendlesstech_privacy]
[bendlesstech_terms]

StayDesk Pages:
[staydesk_landing]
[staydesk_register]
[staydesk_login]
[staydesk_dashboard]
[staydesk_dashboard section="bookings"]
[staydesk_dashboard section="rooms"]
[staydesk_dashboard section="payments"]
```
