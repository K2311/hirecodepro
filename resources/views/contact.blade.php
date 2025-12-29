@extends('layouts.app')

@section('title', 'Contact | CodeCraft Studio')

@section('content')
    <!-- Contact Hero -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>Get In Touch</h1>
                <p>Ready to start your project? Let's discuss how we can bring your ideas to life.</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-section">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Info -->
                <div class="contact-info">
                    <h2>Let's Start a Conversation</h2>
                    <p>I'm always interested in hearing about new projects and opportunities. Whether you need a full-stack
                        application, API development, or consulting services, I'd love to help.</p>

                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Email</h4>
                                <p>{{ \App\Models\SiteSetting::get('support_email', 'support@codecraftstudio.com') }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Phone</h4>
                                <p>{{ \App\Models\SiteSetting::get('phone_number', '+91 0000000000') }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Response Time</h4>
                                <p>Within 24 hours</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Location</h4>
                                <p>{{ \App\Models\SiteSetting::get('business_address', '123 Tech Blvd, San Francisco, CA 94105') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="contact-form-container">
                    <div id="form-messages"></div>

                    <form id="contactForm" class="contact-form">
                        @csrf
                        <input type="hidden" name="source_page" value="{{ url()->previous() }}">

                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name" name="name" required>
                                <div class="error-message" data-field="name"></div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" name="email" required>
                                <div class="error-message" data-field="email"></div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="company">Company</label>
                                <input type="text" id="company" name="company">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inquiry_type">Inquiry Type *</label>
                            <select id="inquiry_type" name="inquiry_type" required>
                                <option value="">Select inquiry type</option>
                                <option value="general">General Inquiry</option>
                                <option value="service">Service Request</option>
                                <option value="support">Technical Support</option>
                                <option value="partnership">Partnership</option>
                            </select>
                            <div class="error-message" data-field="inquiry_type"></div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <input type="text" id="subject" name="subject" required>
                            <div class="error-message" data-field="subject"></div>
                        </div>

                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="6" required
                                placeholder="Tell me about your project..."></textarea>
                            <div class="error-message" data-field="message"></div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-large" id="submitBtn">
                            <span id="btnText">Send Message</span>
                            <span id="btnLoader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Sending...
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .contact-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2563eb 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .contact-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .contact-hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-section {
            padding: 80px 0;
            background-color: var(--bg-secondary);
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        .contact-info h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .contact-info>p {
            font-size: 1.125rem;
            line-height: 1.6;
            margin-bottom: 2rem;
            color: var(--text-secondary);
        }

        .contact-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .contact-text h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
        }

        .contact-text p {
            margin: 0;
            color: var(--text-secondary);
        }

        .contact-form-container {
            background: var(--bg-primary);
            padding: 2.5rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
        }

        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: border-color 0.3s ease;
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.875rem;
            min-height: 1.25rem;
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.125rem;
            font-weight: 600;
        }

        #form-messages {
            margin-bottom: 1.5rem;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--danger-color);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero {
                padding: 60px 0;
            }

            .contact-hero h1 {
                font-size: 2.5rem;
            }

            .contact-section {
                padding: 60px 0;
            }

            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .contact-info h2 {
                font-size: 2rem;
            }

            .contact-form-container {
                padding: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .contact-details {
                gap: 1rem;
            }

            .contact-item {
                gap: 0.75rem;
            }

            .contact-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactForm = document.getElementById('contactForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const formMessages = document.getElementById('form-messages');

            contactForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Clear previous messages and errors
                clearMessages();
                clearErrors();

                // Show loading state
                setLoading(true);

                try {
                    const formData = new FormData(contactForm);
                    const response = await fetch('/contact', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showMessage('success', data.message);
                        contactForm.reset();
                        // Optional: redirect to success page
                        // window.location.href = '/contact/success';
                    } else {
                        if (data.errors) {
                            showErrors(data.errors);
                        } else {
                            showMessage('error', data.message || 'An error occurred. Please try again.');
                        }
                    }
                } catch (error) {
                    showMessage('error', 'Network error. Please check your connection and try again.');
                } finally {
                    setLoading(false);
                }
            });

            function setLoading(loading) {
                submitBtn.disabled = loading;
                btnText.style.display = loading ? 'none' : 'inline';
                btnLoader.style.display = loading ? 'inline' : 'none';
            }

            function showMessage(type, message) {
                const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
                formMessages.innerHTML = `<div class="alert ${alertClass}">${message}</div>`;
                formMessages.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            function showErrors(errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const errorElement = document.querySelector(`.error-message[data-field="${field}"]`);
                    if (errorElement) {
                        errorElement.textContent = messages[0];
                    }
                }
            }

            function clearMessages() {
                formMessages.innerHTML = '';
            }

            function clearErrors() {
                document.querySelectorAll('.error-message').forEach(el => {
                    el.textContent = '';
                });
            }
        });
    </script>
@endpush