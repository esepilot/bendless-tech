# Viewing BendlessTech Frontend Pages

## Quick Start Guide

After installing the plugins on your WordPress site, here's how to access and view all the frontend pages:

---

## BendlessTech Core Plugin Pages

### 1. Homepage
**URL:** `https://yoursite.com/` (if set as homepage)
or `https://yoursite.com/home/`

**What you'll see:**
- Hero section with BendlessTech branding
- Service overview cards for all 3 services
- Company value proposition
- CTAs to service pages

### 2. Custom Website Development Service
**URL:** `https://yoursite.com/custom-website-development/`

**Features:**
- Pain points of businesses without websites
- Benefits of online presence
- Pricing: ₦750,000 starting
- Delivery: 2 weeks
- Lead capture form

### 3. Secure Inventory System Service
**URL:** `https://yoursite.com/secure-inventory-system/`

**Features:**
- Pain points of poor inventory management
- Cost savings and ROI information
- Pricing: ₦900,000 starting
- Delivery: 4 weeks
- Lead capture form

### 4. About Us
**URL:** `https://yoursite.com/about/`

**Features:**
- Company story and mission
- "Bendless" philosophy explanation
- Core values

### 5. Contact
**URL:** `https://yoursite.com/contact/`

**Features:**
- Contact information (WhatsApp, Email)
- Contact form
- Business hours

### 6. Privacy Policy
**URL:** `https://yoursite.com/privacy-policy/`

**Features:**
- NDPR-compliant privacy terms
- Data collection and usage policies

### 7. Terms of Service
**URL:** `https://yoursite.com/terms-of-service/`

**Features:**
- Service terms
- Pricing details
- Refund policies

---

## StayDesk Platform Pages

### 8. StayDesk Landing Page
**URL:** `https://yoursite.com/staydesk/`

**Features:**
- Platform overview
- Feature showcase
- Pricing table (Monthly ₦49,900 / Yearly ₦598,800)
- 10% discount highlight for first 10 yearly subscribers
- Sign-up CTA

### 9. Hotel Registration
**URL:** `https://yoursite.com/staydesk/register`

**Query Parameters:**
- `?plan=monthly` - Pre-select monthly plan
- `?plan=yearly` - Pre-select yearly plan

**Features:**
- Account creation form
- Hotel information input
- Plan selection
- Paystack payment integration

### 10. Hotel Login
**URL:** `https://yoursite.com/staydesk/login`

**Features:**
- Standard WordPress login
- Redirects to hotel dashboard after login

### 11. Hotel Dashboard (Requires Login)
**Base URL:** `https://yoursite.com/staydesk/dashboard`

**Dashboard Sections:**
- `/staydesk/dashboard` - Main overview with stats
- `/staydesk/dashboard/bookings` - Booking management
- `/staydesk/dashboard/rooms` - Room management
- `/staydesk/dashboard/payments` - Payment tracking
- `/staydesk/dashboard/guests` - Guest management
- `/staydesk/dashboard/reports` - Analytics and reports
- `/staydesk/dashboard/chat-widget` - Widget configuration
- `/staydesk/dashboard/settings` - Hotel settings
- `/staydesk/dashboard/subscription` - Subscription management

---

## Special Features

### WhatsApp Floating Button
- **Appears on:** All pages
- **Location:** Bottom-right corner
- **Action:** Opens WhatsApp chat with 07120018023

### Chat Widget (For Hotels)
- **Embed on hotel website** using code from dashboard
- **Features:** Bilingual (English + Nigerian Pidgin)
- **Test URL:** Add widget to any page using embed code

---

## Setting Pages as Homepage

To set the BendlessTech homepage as your site's main page:

1. Go to WordPress Admin → **Settings** → **Reading**
2. Select **A static page** for homepage
3. Choose **Home** from the dropdown
4. Click **Save Changes**

---

## Creating Custom Menu

To add pages to your navigation menu:

1. Go to WordPress Admin → **Appearance** → **Menus**
2. Create a new menu (e.g., "Main Menu")
3. Add pages:
   - Home
   - Custom Website Development
   - Secure Inventory System
   - StayDesk
   - About
   - Contact
4. Assign to **Primary Menu** location
5. Click **Save Menu**

---

## Testing the Platform

### Test Lead Forms:
1. Visit any service page
2. Fill out the lead capture form
3. Submit
4. Check email at reach@bendlesstech.com for notification

### Test WhatsApp Button:
1. Visit any page
2. Click floating WhatsApp button (bottom-right)
3. Should open WhatsApp chat

### Test StayDesk Registration:
1. Visit `/staydesk/register`
2. Fill registration form
3. Complete payment via Paystack (test mode)
4. Login and access dashboard

### Test Chat Widget:
1. Register a hotel
2. Get embed code from dashboard
3. Add to a test page
4. Interact with widget in English and Pidgin

---

## Viewing Without WordPress Installation

If you want to preview the pages without a full WordPress installation:

### Option 1: View Template Files
Templates are located in:
- `plugins/bendlesstech-core/templates/`
- `plugins/staydesk-platform/templates/`

You can open these PHP files in a code editor to see the HTML structure.

### Option 2: Local WordPress Installation
1. Install local WordPress (XAMPP, Local by Flywheel, or Docker)
2. Upload and activate the plugins
3. Access pages via localhost

### Option 3: Staging Site
1. Set up a staging WordPress site
2. Install the plugins from zip files
3. Access all pages online

---

## URL Structure Summary

```
Main Site:
├── / (Homepage)
├── /custom-website-development/
├── /secure-inventory-system/
├── /about/
├── /contact/
├── /privacy-policy/
└── /terms-of-service/

StayDesk Platform:
├── /staydesk/ (Landing)
├── /staydesk/register
├── /staydesk/login
└── /staydesk/dashboard/
    ├── /dashboard (Main)
    ├── /dashboard/bookings
    ├── /dashboard/rooms
    ├── /dashboard/payments
    ├── /dashboard/guests
    ├── /dashboard/reports
    ├── /dashboard/chat-widget
    ├── /dashboard/settings
    └── /dashboard/subscription
```

---

## Troubleshooting

**404 Errors on pages?**
→ Go to Settings → Permalinks → Click "Save Changes" (flushes rewrite rules)

**Pages not showing?**
→ Check that plugins are activated
→ Verify page slugs match expected URLs

**WhatsApp button not appearing?**
→ Clear browser cache
→ Check JavaScript console for errors

**Dashboard not accessible?**
→ Ensure you're logged in
→ Verify user has proper permissions

---

## Need Help?

- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023

See `documentation/INSTALLATION.md` for detailed setup instructions.
