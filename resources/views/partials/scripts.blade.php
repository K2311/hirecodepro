<script>
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = themeToggle.querySelector('i');

    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');

        if (document.body.classList.contains('dark-mode')) {
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            localStorage.setItem('theme', 'dark');
        } else {
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
            localStorage.setItem('theme', 'light');
        }
    });

    // Check for saved theme preference
    if (localStorage.getItem('theme') === 'dark') {
        document.body.classList.add('dark-mode');
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
    });

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                // Close mobile menu if open
                mobileMenu.classList.remove('active');
            }
        });
    });

    // Product Filter
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            // Filter products
            productCards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-category') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // Product Modal
    const productModal = document.getElementById('productModal');
    const modalClose = document.getElementById('modalClose');
    const modalContent = document.getElementById('modalContent');
    const viewProductButtons = document.querySelectorAll('.view-product');

    // Product data
    const products = {
        1: {
            title: "Analytics Dashboard SaaS",
            price: "$349",
            description: "A complete analytics dashboard template built with Next.js, Node.js, and PostgreSQL. Includes user management, Stripe payments, data visualization, and an admin dashboard.",
            features: [
                "User authentication & authorization",
                "Stripe integration for payments & subscriptions",
                "Interactive charts with Chart.js",
                "Admin dashboard with user management",
                "RESTful API with comprehensive documentation",
                "Responsive design for all devices",
                "Docker configuration for easy deployment",
                "Email notifications with SendGrid"
            ],
            tech: ["Next.js", "Node.js", "PostgreSQL", "Stripe", "Chart.js", "Tailwind CSS", "Docker"],
            downloads: 142,
            rating: 4.8,
            license: "Extended License (SaaS allowed)",
            includes: "Full source code, documentation, 6 months support"
        },
        2: {
            title: "Stripe-like Payment API",
            price: "$249",
            description: "A complete payment processing API built with Node.js and MongoDB. Handle payments, subscriptions, invoices, and webhooks similar to Stripe's API.",
            features: [
                "Payment processing with multiple gateways",
                "Subscription management with trial periods",
                "Invoice generation & automated billing",
                "Webhook support for real-time events",
                "Comprehensive API documentation",
                "Rate limiting & security best practices",
                "Admin dashboard for transaction management",
                "Dockerized for easy deployment"
            ],
            tech: ["Node.js", "Express", "MongoDB", "JWT", "Stripe API", "Docker", "Swagger"],
            downloads: 89,
            rating: 4.9,
            license: "Single Project License",
            includes: "Full source code, API documentation, 6 months support"
        },
        3: {
            title: "Advanced Form Builder Plugin",
            price: "$129",
            description: "A powerful WordPress form builder plugin with drag & drop interface, conditional logic, and 20+ field types. Perfect for creating complex forms without code.",
            features: [
                "Drag & drop form builder interface",
                "Conditional logic for smart forms",
                "20+ field types including file upload",
                "Form submissions management",
                "Email notifications & autoresponders",
                "Integration with popular email services",
                "Spam protection with reCAPTCHA",
                "Export submissions to CSV/Excel"
            ],
            tech: ["PHP", "WordPress", "JavaScript", "AJAX", "MySQL"],
            downloads: 217,
            rating: 4.7,
            license: "Single Site License",
            includes: "Plugin files, documentation, 1 year updates"
        }
    };

    // Open modal when clicking view product button
    viewProductButtons.forEach(button => {
        button.addEventListener('click', () => {
            const productId = button.getAttribute('data-product');
            const product = products[productId];

            if (product) {
                modalContent.innerHTML = `
                    <div style="padding: 40px;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
                            <div>
                                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 15px;">${product.title}</h2>
                                <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin-bottom: 20px;">${product.price}</div>
                                <p style="color: var(--text-secondary); margin-bottom: 30px;">${product.description}</p>
                                
                                <div style="margin-bottom: 30px;">
                                    <h3 style="font-size: 1.25rem; margin-bottom: 15px;">Features</h3>
                                    <ul style="list-style: none;">
                                        ${product.features.map(feature => `
                                            <li style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                                                <i class="fas fa-check" style="color: var(--success-color);"></i> ${feature}
                                            </li>
                                        `).join('')}
                                    </ul>
                                </div>
                            </div>
                            
                            <div>
                                <div style="background-color: var(--bg-tertiary); height: 300px; border-radius: var(--radius); display: flex; align-items: center; justify-content: center; color: var(--text-tertiary); font-size: 3rem; margin-bottom: 30px;">
                                    <i class="fas fa-code"></i>
                                </div>
                                
                                <div style="margin-bottom: 30px;">
                                    <h3 style="font-size: 1.25rem; margin-bottom: 15px;">Tech Stack</h3>
                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        ${product.tech.map(tech => `
                                            <span style="background-color: var(--bg-tertiary); color: var(--text-primary); padding: 8px 15px; border-radius: 20px; font-size: 14px;">${tech}</span>
                                        `).join('')}
                                    </div>
                                </div>
                                
                                <div style="background-color: var(--bg-secondary); border-radius: var(--radius); padding: 20px; margin-bottom: 30px;">
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                        <div>
                                            <div style="font-size: 0.875rem; color: var(--text-tertiary);">Downloads</div>
                                            <div style="font-size: 1.5rem; font-weight: 700;">${product.downloads}</div>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.875rem; color: var(--text-tertiary);">Rating</div>
                                            <div style="font-size: 1.5rem; font-weight: 700;">${product.rating}/5</div>
                                        </div>
                                        <div>
                                            <div style="font-size: 0.875rem; color: var(--text-tertiary);">License</div>
                                            <div style="font-size: 1rem; font-weight: 600;">${product.license}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div style="border-top: 1px solid var(--border-color); padding-top: 30px;">
                            <h3 style="font-size: 1.25rem; margin-bottom: 15px;">What's Included</h3>
                            <p style="color: var(--text-secondary); margin-bottom: 30px;">${product.includes}</p>
                            
                            <div style="display: flex; gap: 20px;">
                                <a href="#contact" class="btn btn-primary btn-large">Purchase Now</a>
                                <button class="btn btn-outline btn-large" id="closeModalBtn">Close</button>
                            </div>
                        </div>
                    </div>
                `;

                productModal.classList.add('active');
                document.body.style.overflow = 'hidden';

                // Add event listener to close button inside modal
                document.getElementById('closeModalBtn').addEventListener('click', () => {
                    productModal.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            }
        });
    });

    // Close modal
    if (modalClose) {
        modalClose.addEventListener('click', () => {
            productModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        });
    }

    // Close modal when clicking outside
    if (productModal) {
        productModal.addEventListener('click', (e) => {
            if (e.target === productModal) {
                productModal.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    }
</script>