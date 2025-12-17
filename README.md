# BendlessTech WordPress Platform

![BendlessTech Logo](assets/branding/logo.svg)

> **Technology That Adapts to Your Business—Not the Other Way Around**

## Overview

BendlessTech is a complete WordPress platform offering three core services through custom-built plugins:

1. **Custom Website Development** - Professional websites delivered in 2 weeks
2. **Complete Secure Inventory System** - Custom inventory management for Nigerian businesses
3. **StayDesk Hotel Assistant Platform** - Complete hotel management SaaS with bilingual chat widget

---

## Features

### 🎨 BendlessTech Core Plugin
- Custom post types (Services, Testimonials, FAQs)
- Lead capture forms with database storage
- WhatsApp floating button integration
- Email notifications system
- Frontend admin panel for lead management
- Complete marketing pages (Homepage, Services, About, Contact, Privacy, Terms)

### 🏨 StayDesk Platform Plugin
- Multi-tenant hotel management system
- Hotel registration with Paystack payment integration
- Comprehensive hotel dashboard
- Booking engine with availability checking
- Payment tracking and receipt generation
- Subscription management (Monthly/Yearly plans)
- 10% discount for first 10 yearly subscribers
- Room and guest management
- Revenue analytics and reports
- Refund management system

### 💬 StayDesk Chat Widget Plugin
- **Bilingual support:** English + Nigerian Pidgin
- Rule-based FAQ matching
- Automatic booking assistance
- Enquiry handling
- Refund request processing
- 50+ response templates in both languages
- Natural conversational flow
- Customizable widget appearance
- Simple embed code for hotel websites

---

## System Requirements

- WordPress 6.0+
- PHP 8.0+
- MySQL 5.7+
- SSL Certificate (for payment processing)

---

## Quick Start

### Installation

1. Clone or download this repository
2. Upload plugin folders to `wp-content/plugins/`:
   - `bendlesstech-core/`
   - `staydesk-platform/`
   - `staydesk-chat-widget/`
3. Activate plugins in WordPress admin
4. Configure Paystack API keys for StayDesk
5. Set up email SMTP for notifications

**For detailed installation instructions, see [INSTALLATION.md](documentation/INSTALLATION.md)**

### Configuration

Configure the platform for your needs:
- Update contact information (email, WhatsApp)
- Set up Paystack payment integration
- Customize branding and colors
- Configure email delivery

**For detailed configuration options, see [CONFIGURATION.md](documentation/CONFIGURATION.md)**

---

## Documentation

Comprehensive documentation is available in the `/documentation` folder:

- **[Installation Guide](documentation/INSTALLATION.md)** - Step-by-step setup instructions
- **[Configuration Guide](documentation/CONFIGURATION.md)** - Customize and configure the platform
- **[User Guide](documentation/USER-GUIDE.md)** - How to use the platform features
- **[Hotel Guide](documentation/HOTEL-GUIDE.md)** - Guide for hotels using StayDesk
- **[API Documentation](documentation/API.md)** - REST API reference

---

## Branding Assets

All branding assets are located in `/assets/branding/`:

- **Logo** (Light & Dark versions)
- **Icon Logo** (For favicons and small spaces)
- **Brand Guidelines** - Complete brand identity guide

### Color Palette

- **Primary Blue:** `#1a73e8`
- **Dark Blue:** `#0d47a1`
- **Vibrant Orange:** `#f57c00`
- **Success Green:** `#388e3c`
- **Error Red:** `#d32f2f`

### Typography

Primary Font: **Inter** (Google Fonts)

---

## Pricing

### Custom Website Development
- **Starting at:** ₦750,000
- **Delivery:** 2 weeks
- **Quote Response:** 15 minutes via WhatsApp

### Complete Secure Inventory System
- **Starting at:** ₦900,000
- **Delivery:** 4 weeks
- **Quote Response:** 15 minutes via WhatsApp

### StayDesk Hotel Platform
- **Monthly Plan:** ₦49,900/month
- **Yearly Plan:** ₦598,800/year
- **Special Offer:** 10% discount for first 10 hotels on yearly plan

---

## Contact Information

- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023
- **Website:** https://bendlesstech.com

**We respond to quote requests in 15 minutes via WhatsApp!**

---

## Technology Stack

- **WordPress** - CMS Framework
- **PHP 8.0+** - Backend Language
- **MySQL** - Database
- **JavaScript (jQuery)** - Frontend Interactivity
- **Paystack** - Payment Processing
- **REST API** - Widget Integration

---

## Plugin Structure

```
bendless-tech/
├── plugins/
│   ├── bendlesstech-core/           # Core plugin for main site
│   │   ├── includes/                # PHP classes
│   │   ├── assets/                  # CSS, JS, images
│   │   ├── templates/               # Page templates
│   │   └── admin/                   # Admin functionality
│   │
│   ├── staydesk-platform/           # Hotel management platform
│   │   ├── includes/                # Core classes
│   │   ├── assets/                  # Styles and scripts
│   │   └── templates/               # Dashboard templates
│   │
│   └── staydesk-chat-widget/        # Bilingual chat widget
│       ├── includes/                # Widget logic
│       ├── assets/                  # Widget CSS/JS
│       └── responses/               # Response templates
│
├── assets/
│   └── branding/                    # Brand assets and guidelines
│
└── documentation/                   # Complete documentation
```

---

## Security

- Nonce verification on all forms
- Data sanitization and validation
- Prepared SQL statements
- Role-based access control
- Secure Paystack integration
- SSL/HTTPS enforcement
- Regular security audits

---

## Performance

- Efficient database queries with proper indexing
- Minimal external dependencies
- Optimized assets (minified CSS/JS recommended)
- Caching-friendly architecture
- CDN-ready

---

## Support

For support, questions, or custom development:

- **Email:** reach@bendlesstech.com
- **WhatsApp:** 07120018023

Response time: 15 minutes during business hours (9 AM - 6 PM, Monday - Saturday)

---

## License

GPL v2 or later

Copyright © 2024 BendlessTech. All rights reserved.

---

## Credits

Built with ❤️ by BendlessTech Team

**Mission:** We don't make businesses bend to fit technology—we make technology bend to fit businesses.

---

*For Nigerian businesses, by people who understand the Nigerian market.*