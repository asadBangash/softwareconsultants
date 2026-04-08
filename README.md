# Software Consultants — Multi-Page Website

## Overview
Professional corporate website for Software Consultants LLC, restructured as a modular multi-page site with reusable components and comprehensive on-page SEO.

## Directory Structure
```
software_consultants/
├── index.html              # Homepage with section previews
├── about.html              # Full About page
├── contact.html            # Contact page with form
├── services/
│   ├── index.html          # All services listing
│   └── [12 service pages]  # Individual service detail pages
├── industries/
│   ├── index.html          # All industries listing
│   └── [7 industry pages]  # Individual industry detail pages
├── css/styles.css          # Shared stylesheet
├── js/
│   ├── components.js       # Reusable header, footer, topbar
│   └── main.js             # Animations, slider, interactions
└── README.md
```

## SEO Features
- Unique meta descriptions per page
- Open Graph & Twitter Card tags
- JSON-LD structured data (Organization, WebSite, Service, BreadcrumbList)
- Canonical URLs
- Semantic HTML5 (<main>, <section>, <header>, <footer>, <nav>)
- Descriptive alt text on all images
- Proper heading hierarchy (h1 > h2 > h3)
- Geo meta tags for local SEO
- robots meta directives

## Key Features
- **Sticky Header**: Navigation bar stays fixed at top on scroll
- **Shared Components**: Header, footer, and top bar injected via components.js
- **Active Navigation**: Current page highlighted automatically
- **Responsive**: Fully responsive with mobile hamburger menu
- **Animations**: Scroll-triggered fade-in animations and counter animation

## How to Run
```bash
npx serve .
# or
python -m http.server 8000
```
