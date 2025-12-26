@extends('layouts.app')

@section('title', 'Get a Quote | Project Details')

@section('content')
    <!-- Quote Hero -->
    <section class="quote-hero-v3">
        <div class="hero-bg-accent"></div>
        <div class="container">
            <div class="hero-content-v3">
                <span class="premium-badge">Project Discovery</span>
                <h1>Tell Us About <br><span class="accent-text">Your Vision</span></h1>
                <p>Follow our simple step-by-step guide to get a precise quote for your next digital masterpiece.</p>
            </div>
        </div>
    </section>

    <!-- Wizard Section -->
    <section class="wizard-section">
        <div class="container">
            <div class="wizard-wrapper">
                <!-- Progress Stepper -->
                <div class="wizard-progress-container">
                    <div class="wizard-progress-bar" id="progressBar"></div>
                    <div class="wizard-steps-indicator">
                        <div class="step-indicator active" data-step="1">
                            <div class="step-icon"><i class="fas fa-user-circle"></i></div>
                            <span>Identity</span>
                        </div>
                        <div class="step-indicator" data-step="2">
                            <div class="step-icon"><i class="fas fa-laptop-code"></i></div>
                            <span>Project</span>
                        </div>
                        <div class="step-indicator" data-step="3">
                            <div class="step-icon"><i class="fas fa-pencil-ruler"></i></div>
                            <span>Details</span>
                        </div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="wizard-card">
                    <div id="form-messages"></div>

                    <form id="quoteForm" class="wizard-form">
                        @csrf

                        <!-- Step 1: Personal Info -->
                        <div class="wizard-step active" id="step1">
                            <div class="step-content-header">
                                <h2>Let's start with the basics</h2>
                                <p>Who should we contact to discuss this project?</p>
                            </div>

                            <div class="form-grid">
                                <div class="form-group-v3">
                                    <label>Full Name *</label>
                                    <input type="text" name="name" required placeholder="Ex: John Doe">
                                    <div class="error-message" data-field="name"></div>
                                </div>
                                <div class="form-group-v3">
                                    <label>Email Address *</label>
                                    <input type="email" name="email" required placeholder="Ex: john@brand.com">
                                    <div class="error-message" data-field="email"></div>
                                </div>
                            </div>

                            <div class="form-group-v3">
                                <label>Company / Organization (Optional)</label>
                                <input type="text" name="company" placeholder="Ex: FutureTech Solutions">
                            </div>

                            <div class="wizard-actions">
                                <div></div> <!-- Empty div for spacing -->
                                <button type="button" class="btn-wizard next-step" data-next="2">
                                    Next: Project Scope <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Project Scope -->
                        <div class="wizard-step" id="step2">
                            <div class="step-content-header">
                                <h2>Project Foundations</h2>
                                <p>Help us understand the scale and nature of your project.</p>
                            </div>

                            <div class="form-group-v3">
                                <label>Primary Project Category *</label>
                                <select name="project_type" required>
                                    <option value="">Choose a category...</option>
                                    <option value="Web Application">SaaS / Web Application</option>
                                    <option value="Mobile App">Mobile Application</option>
                                    <option value="E-commerce">E-commerce Solution</option>
                                    <option value="API Development">API / Backend System</option>
                                    <option value="Other">Other Custom Solution</option>
                                </select>
                                <div class="error-message" data-field="project_type"></div>
                            </div>

                            <div class="form-group-v3">
                                <label>Specific Services Needed</label>
                                <div class="services-toggle-grid">
                                    @foreach(['UI/UX Design', 'Frontend', 'Backend', 'Mobile', 'DevOps', 'AI/ML'] as $svc)
                                        <label class="toggle-pill">
                                            <input type="checkbox" name="services_needed[]" value="{{ $svc }}">
                                            <span>{{ $svc }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-group-v3">
                                    <label>Budget Range</label>
                                    <select name="budget_range">
                                        <option value="">Select range...</option>
                                        <option value="<$5k">Under $5k</option>
                                        <option value="$5k-$15k">$5k - $15k</option>
                                        <option value="$15k-$50k">$15k - $50k</option>
                                        <option value="$50k+">$50k+</option>
                                    </select>
                                </div>
                                <div class="form-group-v3">
                                    <label>Target Timeline</label>
                                    <select name="timeline">
                                        <option value="">Select timeline...</option>
                                        <option value="ASAP">ASAP / Urgent</option>
                                        <option value="1-3 Months">1-3 Months</option>
                                        <option value="3-6 Months">3-6 Months</option>
                                        <option value="Flexible">Flexible</option>
                                    </select>
                                </div>
                            </div>

                            <div class="wizard-actions">
                                <button type="button" class="btn-wizard-outline prev-step" data-prev="1">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="button" class="btn-wizard next-step" data-next="3">
                                    Next: Detailed Brief <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Brief -->
                        <div class="wizard-step" id="step3">
                            <div class="step-content-header">
                                <h2>The Final Details</h2>
                                <p>Describe your vision in your own words.</p>
                            </div>

                            <div class="form-group-v3">
                                <label>Project Description *</label>
                                <textarea name="description" rows="6" required
                                    placeholder="Tell us about the features, target audience, and main goals..."></textarea>
                                <div class="error-message" data-field="description"></div>
                            </div>

                            <div class="wizard-actions">
                                <button type="button" class="btn-wizard-outline prev-step" data-prev="2">
                                    <i class="fas fa-arrow-left"></i> Back
                                </button>
                                <button type="submit" class="btn-wizard submit-btn" id="submitBtn">
                                    <span id="btnText">Get My Free Quote <i class="fas fa-paper-plane"></i></span>
                                    <div class="loader-v3" id="btnLoader" style="display: none;"></div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Simple Info Cards below -->
                <div class="wizard-footer-info">
                    <div class="footer-info-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <h4>100% Confidential</h4>
                            <p>Your ideas are safe with us under NDA.</p>
                        </div>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-bolt"></i>
                        <div>
                            <h4>Fast Response</h4>
                            <p>Analysis delivered within 24 hours.</p>
                        </div>
                    </div>
                    <div class="footer-info-item">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <h4>Zero Obligation</h4>
                            <p>Free consultation for every inquiry.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        :root {
            --wizard-primary: var(--primary-color);
            --wizard-bg: var(--bg-primary);
            --wizard-text: var(--text-primary);
            --wizard-border: var(--border-color);
        }

        .quote-hero-v3 {
            padding: 80px 0 60px;
            background: var(--bg-primary);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg-accent {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(var(--primary-color-rgb, 99, 102, 241), 0.05), transparent 70%);
            z-index: 0;
        }

        .hero-content-v3 {
            position: relative;
            z-index: 1;
        }

        .hero-content-v3 h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            letter-spacing: -1.5px;
            color: var(--text-primary);
        }

        .hero-content-v3 .accent-text {
            color: var(--primary-color);
        }

        .hero-content-v3 p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Wizard Wrapper */
        .wizard-section {
            padding-bottom: 100px;
            background: var(--bg-secondary);
        }

        .wizard-wrapper {
            max-width: 800px;
            margin: -40px auto 0;
            position: relative;
            z-index: 10;
        }

        /* Progress Stepper */
        .wizard-progress-container {
            margin-bottom: 30px;
            position: relative;
            padding: 0 40px;
        }

        .wizard-progress-bar {
            position: absolute;
            top: 25px;
            left: 80px;
            right: 80px;
            height: 4px;
            background: var(--border-color);
            z-index: 1;
        }

        .wizard-progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 0%;
            background: var(--primary-color);
            transition: width 0.4s ease;
            box-shadow: 0 0 10px rgba(var(--primary-color-rgb, 99, 102, 241), 0.5);
        }

        .wizard-steps-indicator {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .step-indicator {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: var(--text-tertiary);
            transition: all 0.3s;
        }

        .step-indicator .step-icon {
            width: 50px;
            height: 50px;
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .step-indicator span {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .step-indicator.active {
            color: var(--primary-color);
        }

        .step-indicator.active .step-icon {
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(var(--primary-color-rgb, 99, 102, 241), 0.3);
        }

        .step-indicator.completed .step-icon {
            background: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }

        /* Wizard Card */
        .wizard-card {
            background: var(--bg-primary);
            padding: 50px;
            border-radius: 24px;
            box-shadow: var(--card-shadow-hover);
            border: 1px solid var(--border-color);
        }

        .wizard-step {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .wizard-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .step-content-header {
            margin-bottom: 40px;
            text-align: center;
        }

        .step-content-header h2 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .step-content-header p {
            color: var(--text-secondary);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group-v3 {
            margin-bottom: 25px;
        }

        .form-group-v3 label {
            display: block;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        .form-group-v3 input, 
        .form-group-v3 select, 
        .form-group-v3 textarea {
            width: 100%;
            padding: 15px 20px;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 1rem;
            color: var(--text-primary);
            transition: all 0.3s;
        }

        .form-group-v3 input:focus, 
        .form-group-v3 select:focus, 
        .form-group-v3 textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            background: var(--bg-primary);
            box-shadow: 0 0 0 5px rgba(var(--primary-color-rgb, 99, 102, 241), 0.1);
        }

        /* Services Pills */
        .services-toggle-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .toggle-pill {
            cursor: pointer;
        }

        .toggle-pill input {
            display: none;
        }

        .toggle-pill span {
            display: block;
            padding: 10px 20px;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 100px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.2s;
        }

        .toggle-pill input:checked + span {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(var(--primary-color-rgb, 99, 102, 241), 0.2);
        }

        /* Actions */
        .wizard-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border-color);
        }

        .btn-wizard, .btn-wizard-outline {
            padding: 16px 30px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-wizard {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-wizard:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(var(--primary-color-rgb, 99, 102, 241), 0.3);
        }

        .btn-wizard-outline {
            background: var(--bg-primary);
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .btn-wizard-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        /* Footer Info */
        .wizard-footer-info {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 60px;
        }

        .footer-info-item {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .footer-info-item i {
            font-size: 24px;
            color: var(--primary-color);
            background: rgba(var(--primary-color-rgb, 99, 102, 241), 0.1);
            padding: 12px;
            border-radius: 12px;
        }

        .footer-info-item h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .footer-info-item p {
            font-size: 0.85rem;
            color: var(--text-tertiary);
            line-height: 1.4;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 5px;
            min-height: 1.2rem;
        }

        .loader-v3 {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin { to { transform: rotate(360deg); } }

        @media (max-width: 768px) {
            .hero-content-v3 h1 { font-size: 2.5rem; }
            .form-grid { grid-template-columns: 1fr; }
            .wizard-card { padding: 30px 20px; }
            .wizard-footer-info { grid-template-columns: 1fr; }
            .wizard-progress-bar { display: none; }
            .step-indicator span { display: none; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quoteForm = document.getElementById('quoteForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const formMessages = document.getElementById('form-messages');
            
            // Step Navigation
            const steps = document.querySelectorAll('.wizard-step');
            const indicators = document.querySelectorAll('.step-indicator');
            const progressBar = document.getElementById('progressBar');

            function updateProgress(stepNum) {
                const totalSteps = steps.length;
                const progressWidth = ((stepNum - 1) / (totalSteps - 1)) * 100;
                
                // Add a CSS variable to update progress
                document.documentElement.style.setProperty('--progress-width', progressWidth + '%');
                
                // Direct injection because CSS vars might be tricky in a single rule
                const style = document.createElement('style');
                style.innerHTML = `.wizard-progress-bar::after { width: ${progressWidth}%; }`;
                document.head.appendChild(style);

                indicators.forEach(indicator => {
                    const step = parseInt(indicator.getAttribute('data-step'));
                    if (step < stepNum) {
                        indicator.classList.remove('active');
                        indicator.classList.add('completed');
                    } else if (step === stepNum) {
                        indicator.classList.add('active');
                        indicator.classList.remove('completed');
                    } else {
                        indicator.classList.remove('active', 'completed');
                    }
                });
            }

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', () => {
                    const nextStep = button.getAttribute('data-next');
                    const currentStep = nextStep - 1;
                    
                    if (validateStep(currentStep)) {
                        document.getElementById(`step${currentStep}`).classList.remove('active');
                        document.getElementById(`step${nextStep}`).classList.add('active');
                        updateProgress(parseInt(nextStep));
                        window.scrollTo({ top: document.querySelector('.wizard-progress-container').offsetTop - 100, behavior: 'smooth' });
                    }
                });
            });

            document.querySelectorAll('.prev-step').forEach(button => {
                button.addEventListener('click', () => {
                    const prevStep = button.getAttribute('data-prev');
                    const currentStep = parseInt(prevStep) + 1;
                    
                    document.getElementById(`step${currentStep}`).classList.remove('active');
                    document.getElementById(`step${prevStep}`).classList.add('active');
                    updateProgress(parseInt(prevStep));
                    window.scrollTo({ top: document.querySelector('.wizard-progress-container').offsetTop - 100, behavior: 'smooth' });
                });
            });

            function validateStep(stepNum) {
                const stepElement = document.getElementById(`step${stepNum}`);
                const inputs = stepElement.querySelectorAll('input[required], select[required], textarea[required]');
                let isValid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        isValid = false;
                        input.style.borderColor = 'var(--danger-color)';
                        const error = stepElement.querySelector(`.error-message[data-field="${input.name}"]`);
                        if (error) error.textContent = 'This field is required.';
                    } else {
                        input.style.borderColor = 'var(--border-color)';
                        const error = stepElement.querySelector(`.error-message[data-field="${input.name}"]`);
                        if (error) error.textContent = '';
                    }
                });

                return isValid;
            }

            // Form Submit handled exactly as before
            quoteForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                clearMessages();
                clearErrors();
                setLoading(true);

                try {
                    const formData = new FormData(quoteForm);
                    const response = await fetch('{{ route("quote.store") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (data.success) {
                        showMessage('success', data.message);
                        quoteForm.reset();
                        // Reset wizard
                        document.querySelectorAll('.wizard-step').forEach(s => s.classList.remove('active'));
                        document.getElementById('step1').classList.add('active');
                        updateProgress(1);
                        window.scrollTo({ top: formMessages.offsetTop - 120, behavior: 'smooth' });
                    } else {
                        if (data.errors) {
                            showErrors(data.errors);
                            // If errors in earlier steps, jump to them? 
                            // For simplicity, just show them.
                        } else {
                            showMessage('error', data.message || 'An error occurred. Please try again.');
                        }
                    }
                } catch (error) {
                    showMessage('error', 'Network error. Please try again.');
                } finally {
                    setLoading(false);
                }
            });

            function setLoading(loading) {
                submitBtn.disabled = loading;
                btnText.style.display = loading ? 'none' : 'inline-block';
                btnLoader.style.display = loading ? 'inline-block' : 'none';
            }

            function showMessage(type, message) {
                const icon = type === 'success' ? '<i class="fas fa-check-circle"></i>' : '<i class="fas fa-exclamation-circle"></i>';
                const color = type === 'success' ? 'var(--success-color)' : 'var(--danger-color)';
                const bg = type === 'success' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)';
                
                formMessages.innerHTML = `
                    <div style="padding: 20px; border-radius: 12px; margin-bottom: 30px; background: ${bg}; color: ${color}; border: 1px solid ${color}; display: flex; align-items: center; gap: 15px; font-weight: 700;">
                        ${icon} ${message}
                    </div>
                `;
            }

            function showErrors(errors) {
                for (const [field, messages] of Object.entries(errors)) {
                    const errorElement = document.querySelector(`.error-message[data-field="${field}"]`);
                    if (errorElement) {
                        errorElement.textContent = messages[0];
                    }
                }
            }

            function clearMessages() { formMessages.innerHTML = ''; }
            function clearErrors() { document.querySelectorAll('.error-message').forEach(el => el.textContent = ''); }
        });
    </script>
@endpush