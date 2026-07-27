
// Shared Components - Software Consultants
(function () {
    const isFileProtocol = location.protocol === 'file:';
    const depth = document.body.dataset.depth === '1' ? '../' : '';

    function pageUrl(cleanPath) {
        if (isFileProtocol) {
            if (!cleanPath) return depth + 'index.html';
            if (cleanPath === 'services' || cleanPath === 'industries') {
                return depth + cleanPath + '/index.html';
            }
            return depth + cleanPath + '.html';
        }
        return cleanPath ? '/' + cleanPath : '/';
    }

    const homeUrl = pageUrl('');
    const LOGO_BLACK = (isFileProtocol ? depth : '/') + 'images/software-consultants-logo-black.png';

    function getTopBar() {
        return `<div class="top-bar"><div class="container"><div class="top-bar-left"><a href="mailto:info@softwaresconsultants.com">✉ info@softwaresconsultants.com</a><a href="tel:+13366152689">☎ +1 (336) 615-2689</a></div><div class="top-bar-right"><a href="https://www.linkedin.com/company/90810275/admin/dashboard/" target="_blank" title="LinkedIn">in</a><a href="https://www.facebook.com/softwaresconsultants" target="_blank" title="Facebook">f</a></div></div></div>`;
    }

    function getHeader() {
        const page = document.body.dataset.page || 'home';
        const services = [
            { name: 'Web Development', slug: 'web-development' }, { name: 'Mobile App Development', slug: 'mobile-app-development' }, { name: 'Custom Software', slug: 'custom-software-development' }, { name: 'Shopify Development', slug: 'shopify-development' }, { name: 'WooCommerce Development', slug: 'woocommerce-development' }, { name: 'UI/UX Design', slug: 'ui-ux-design' }, { name: 'DevOps & Cloud', slug: 'devops-cloud' }, { name: 'QA & Testing', slug: 'qa-testing' }, { name: 'API Development', slug: 'api-development' }, { name: 'ERP/CRM Solutions', slug: 'erp-crm-solutions' }, { name: 'Database Design', slug: 'database-design' }, { name: 'IT Consulting', slug: 'it-consulting' }
        ];
        const industries = [
            { name: 'Healthcare', slug: 'healthcare' }, { name: 'Finance & Banking', slug: 'finance-banking' }, { name: 'E-commerce', slug: 'e-commerce' }, { name: 'Logistics & Transportation', slug: 'logistics-transportation' }, { name: 'Education', slug: 'education' }, { name: 'Real Estate', slug: 'real-estate' }, { name: 'Manufacturing', slug: 'manufacturing' }
        ];
        const svcDropdown = services.map(s => `<li><a href="${pageUrl('services/' + s.slug)}">${s.name}</a></li>`).join('');
        const indDropdown = industries.map(i => `<li><a href="${pageUrl('industries/' + i.slug)}">${i.name}</a></li>`).join('');
        return `<header class="site-header" id="siteHeader"><div class="container navbar-wrapper"><div class="logo"><a href="${homeUrl}"><img src="${LOGO_BLACK}" alt="Software Consultants"></a></div><nav class="nav-right" id="navRight"><ul class="nav-list"><li><a href="${homeUrl}" class="${page === 'home' ? 'active' : ''}">Home</a></li><li class="nav-dropdown"><a href="${pageUrl('services')}" class="${page === 'services' ? 'active' : ''}">Services ▾</a><ul class="dropdown-menu">${svcDropdown}</ul></li><li class="nav-dropdown"><a href="${pageUrl('industries')}" class="${page === 'industries' ? 'active' : ''}">Industries ▾</a><ul class="dropdown-menu">${indDropdown}</ul></li><li><a href="${pageUrl('about')}" class="${page === 'about' ? 'active' : ''}">About</a></li><li><a href="${pageUrl('contact')}" class="${page === 'contact' ? 'active' : ''}">Contact</a></li><li><a href="${pageUrl('contact')}" class="btn-accent" style="padding:8px 20px;font-size:13px">Get a Quote</a></li></ul></nav><button class="menu-toggle" id="menuToggle" aria-label="Menu"><span></span><span></span><span></span></button></div></header>`;
    }

    function getWhatsAppWidget() {
        return `<div class="whatsapp-widget"><a href="https://wa.me/923171448616?text=Hi%20Software%20Consultants" target="_blank" title="Chat with us on WhatsApp" class="whatsapp-btn"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" width="24" height="24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.411-2.391-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.967 1.523 9.876 9.876 0 0012.754 14.75 9.865 9.865 0 00-4.922-13.033 9.866 9.866 0 00-2.861-.24zm0-2.452c1.498 0 2.97.285 4.347.835a11.882 11.882 0 013.527 2.285 11.87 11.87 0 012.926 3.517 11.865 11.865 0 01.926 4.323 11.87 11.87 0 01-1.89 7.38 11.857 11.857 0 01-3.05 2.876 11.876 11.876 0 01-4.2 1.54 11.867 11.867 0 01-3.803-.673 11.868 11.868 0 01-3.217-2.121 11.873 11.873 0 01-2.416-3.268 11.868 11.868 0 01-1.43-4.157 11.865 11.865 0 011.467-4.147 11.87 11.87 0 013.206-3.283 11.866 11.866 0 014.217-1.537 11.87 11.87 0 013.27-.485z"/></svg></a><span class="whatsapp-tooltip">Chat with us</span></div>`;
    }

    function getFooter() {
        return `<footer><div class="container"><div class="footer-grid"><div class="footer-col"><h4 class="footer-brand"><a href="${homeUrl}">Software Consultants</a></h4><p>Turning Concepts Into Reality. We deliver custom software solutions, IT consulting, and digital transformation services for businesses worldwide.</p></div><div class="footer-col"><h4>Quick Links</h4><ul><li><a href="${homeUrl}">Home</a></li><li><a href="${pageUrl('about')}">About Us</a></li><li><a href="${pageUrl('services')}">Services</a></li><li><a href="${pageUrl('industries')}">Industries</a></li><li><a href="${pageUrl('contact')}">Contact Us</a></li></ul></div><div class="footer-col"><h4>Our Services</h4><ul><li><a href="${pageUrl('services/web-development')}">Web Development</a></li><li><a href="${pageUrl('services/mobile-app-development')}">Mobile Apps</a></li><li><a href="${pageUrl('services/custom-software-development')}">Custom Software</a></li><li><a href="${pageUrl('services/shopify-development')}">Shopify Development</a></li><li><a href="${pageUrl('services/devops-cloud')}">DevOps & Cloud</a></li><li><a href="${pageUrl('services/ui-ux-design')}">UI/UX Design</a></li></ul></div><div class="footer-col"><h4>Contact Us</h4><ul class="footer-contact"><li>6829 Keeneland Dr, Whitsett, NC 27377</li><li><a href="tel:+13366152689">+1 (336) 615-2689</a></li><li><a href="https://wa.me/923171448616" target="_blank" rel="noopener">WhatsApp</a></li><li><a href="mailto:info@softwaresconsultants.com">info@softwaresconsultants.com</a></li><li>Mon–Fri: 9:00 AM – 6:00 PM</li></ul></div></div><div class="footer-bottom"><span>&copy; ${new Date().getFullYear()} Software Consultants LLC. All rights reserved.</span><div class="footer-bottom-links"><a href="#">Privacy Policy</a><a href="#">Terms of Service</a><a href="#">Sitemap</a></div></div></div></footer>`;
    }

    function fixFileProtocolLinks() {
        if (!isFileProtocol) return;
        document.querySelectorAll('a[href^="/"]').forEach(function (a) {
            var href = a.getAttribute('href');
            if (href === '/') {
                a.setAttribute('href', depth + 'index.html');
            } else if (href === '/services' || href === '/industries') {
                a.setAttribute('href', depth + href.slice(1) + '/index.html');
            } else {
                a.setAttribute('href', depth + href.slice(1) + '.html');
            }
        });
    }

    window.fixFileProtocolLinks = fixFileProtocolLinks;

    const topbarEl = document.getElementById('topbar-placeholder');
    const headerEl = document.getElementById('header-placeholder');
    const footerEl = document.getElementById('footer-placeholder');
    if (topbarEl) topbarEl.innerHTML = getTopBar();
    if (headerEl) headerEl.innerHTML = getHeader();
    if (footerEl) footerEl.innerHTML = getFooter();
    fixFileProtocolLinks();

    const body = document.body;
    const whatsappWidget = document.createElement('div');
    whatsappWidget.innerHTML = getWhatsAppWidget();
    body.appendChild(whatsappWidget.firstElementChild);

    setTimeout(function () {
        const toggle = document.getElementById('menuToggle');
        const nav = document.getElementById('navRight');
        if (toggle && nav) {
            toggle.addEventListener('click', function () { nav.classList.toggle('open'); });
        }
    }, 100);
})();
