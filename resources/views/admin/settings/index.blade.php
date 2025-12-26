@extends('admin.layouts.app')

@section('title', 'Settings | CodeCraft Studio')
@section('page-title', 'Settings')

@section('content')
    <div class="settings-page">

        <!-- Main Content Area -->
        <div class="settings-content"
            style="background: white; border-radius: 0.5rem; border: 1px solid #e2e8f0; padding: 2rem; max-width: 900px; margin: 0 auto;">

            <div class="content-header mb-8" style="margin-bottom: 2rem;">
                <h1 class="text-2xl font-bold text-gray-900 mb-1"
                    style="font-size: 1.5rem; color: #0f172a; margin-bottom: 0.25rem;">Settings</h1>
                <p class="text-gray-500" style="color: #64748b;">Manage your application settings and configurations.</p>
            </div>

            <!-- Custom Tabs -->
            <div class="settings-tabs mb-8" style="border-bottom: 1px solid #e2e8f0; display: flex; gap: 2rem;">
                <button type="button" onclick="switchTab('general')" id="tab-general" class="tab-btn active"
                    style="padding-bottom: 1rem; color: #3b82f6; border-bottom: 2px solid #3b82f6; font-weight: 500;">General</button>
                <button type="button" onclick="switchTab('homepage')" id="tab-homepage" class="tab-btn"
                    style="padding-bottom: 1rem; color: #64748b; border-bottom: 2px solid transparent; font-weight: 500;">Home
                    Page</button>
                <button type="button" onclick="switchTab('payment')" id="tab-payment" class="tab-btn"
                    style="padding-bottom: 1rem; color: #64748b; border-bottom: 2px solid transparent; font-weight: 500;">Payment</button>
                <button type="button" onclick="switchTab('system')" id="tab-system" class="tab-btn"
                    style="padding-bottom: 1rem; color: #64748b; border-bottom: 2px solid transparent; font-weight: 500;">System</button>
                <button type="button" onclick="switchTab('social')" id="tab-social" class="tab-btn"
                    style="padding-bottom: 1rem; color: #64748b; border-bottom: 2px solid transparent; font-weight: 500;">Social</button>
                <button type="button" onclick="switchTab('appearance')" id="tab-appearance" class="tab-btn"
                    style="padding-bottom: 1rem; color: #64748b; border-bottom: 2px solid transparent; font-weight: 500;">Appearance</button>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(session('success'))
                    <div class="alert alert-success mb-6"
                        style="background: #ecfdf5; border: 1px solid #10b981; color: #047857; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem;">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- GENERAL TAB -->
                <div id="content-general" class="tab-content" style="display: block;">
                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem;">General
                        Information</h3>

                    <div class="grid grid-cols-2 gap-6 mb-6"
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Business Name</label>
                            <input type="text" name="site_name" value="{{ $keyedSettings['site_name']->value ?? '' }}"
                                class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Contact Email</label>
                            <input type="email" name="contact_email"
                                value="{{ $keyedSettings['contact_email']->value ?? '' }}" class="form-input">
                        </div>
                    </div>

                    <!-- Logo Section -->
                    <div class="grid grid-cols-3 gap-6 mb-8"
                        style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">

                        <!-- Light Logo -->
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Light Logo</label>
                            <div class="image-upload-container">
                                <label for="site_logo_light" class="upload-box" id="preview-container-light">
                                    <div class="preview-area">
                                        @if(!empty($keyedSettings['site_logo_light']->value))
                                            <div class="relative group" style="position: relative; width: 100%; height: 100%;">
                                                <img src="{{ asset($keyedSettings['site_logo_light']->value) }}"
                                                    id="img-preview-light" alt="Light Logo">
                                                <button type="button" onclick="removeImage('site_logo_light')" class="remove-image-btn" title="Remove Logo">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <img src="" id="img-preview-light" class="hidden" alt="Preview">
                                            <div class="placeholder" id="placeholder-light">
                                                <i class="fas fa-cloud-upload-alt mb-2 text-2xl text-gray-400"></i>
                                                <span class="text-xs text-gray-500">Upload Light Logo</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="site_logo_light" id="site_logo_light" class="hidden-input"
                                        onchange="previewImage(this, 'light')">
                                </label>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 block">Recommended height: 40px</span>
                        </div>

                        <!-- Dark Logo -->
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Dark Logo</label>
                            <div class="image-upload-container">
                                <label for="site_logo_dark" class="upload-box dark-bg" id="preview-container-dark"
                                    style="background-color: #0f172a; border-color: #1e293b;">
                                    <div class="preview-area">
                                        @if(!empty($keyedSettings['site_logo_dark']->value))
                                            <div class="relative group" style="position: relative; width: 100%; height: 100%;">
                                                <img src="{{ asset($keyedSettings['site_logo_dark']->value) }}"
                                                    id="img-preview-dark" alt="Dark Logo">
                                                <button type="button" onclick="removeImage('site_logo_dark')" class="remove-image-btn" title="Remove Logo">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <img src="" id="img-preview-dark" class="hidden" alt="Preview">
                                            <div class="placeholder" id="placeholder-dark">
                                                <i class="fas fa-cloud-upload-alt mb-2 text-2xl text-gray-500"></i>
                                                <span class="text-xs text-gray-400">Upload Dark Logo</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="site_logo_dark" id="site_logo_dark" class="hidden-input"
                                        onchange="previewImage(this, 'dark')">
                                </label>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 block">Recommended height: 40px</span>
                        </div>

                        <!-- Favicon -->
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Favicon</label>
                            <div class="image-upload-container">
                                <label for="site_favicon" class="upload-box" id="preview-container-favicon">
                                    <div class="preview-area">
                                        @if(!empty($keyedSettings['site_favicon']->value))
                                            <div class="relative group" style="position: relative; width: 100%; height: 100%;">
                                                <img src="{{ asset($keyedSettings['site_favicon']->value) }}"
                                                    id="img-preview-favicon" alt="Favicon" style="max-height: 32px; width: auto;">
                                                <button type="button" onclick="removeImage('site_favicon')" class="remove-image-btn" title="Remove Favicon">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @else
                                            <img src="" id="img-preview-favicon" class="hidden" alt="Preview">
                                            <div class="placeholder" id="placeholder-favicon">
                                                <i class="fas fa-gem mb-2 text-2xl text-gray-400"></i>
                                                <span class="text-xs text-gray-500">Upload Favicon</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="site_favicon" id="site_favicon" class="hidden-input"
                                        onchange="previewImage(this, 'favicon')">
                                </label>
                            </div>
                            <span class="text-xs text-gray-500 mt-2 block">Recommended: 32x32px (PNG/ICO)</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6"
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Support Email</label>
                            <input type="email" name="support_email"
                                value="{{ $keyedSettings['support_email']->value ?? '' }}" class="form-input">
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone_number" value="{{ $keyedSettings['phone_number']->value ?? '' }}"
                                class="form-input">
                        </div>
                    </div>

                    <div class="form-group mb-6">
                        <label class="block mb-2 font-medium text-gray-700">Business Address</label>
                        <textarea name="business_address" rows="3"
                            class="form-input">{{ $keyedSettings['business_address']->value ?? '' }}</textarea>
                    </div>

                    <div class="form-group mb-6">
                        <label class="block mb-2 font-medium text-gray-700">Site Description (SEO)</label>
                        <textarea name="site_description" rows="3"
                            class="form-input">{{ $keyedSettings['site_description']->value ?? '' }}</textarea>
                    </div>

                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem; margin-top: 2rem;">
                        Regional Settings</h3>

                    <div class="grid grid-cols-2 gap-6 mb-6"
                        style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Currency</label>
                            <select name="currency" class="form-select">
                                <option value="USD" {{ ($keyedSettings['currency']->value ?? '') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                                <option value="EUR" {{ ($keyedSettings['currency']->value ?? '') == 'EUR' ? 'selected' : '' }}>Euro (EUR)</option>
                                <option value="GBP" {{ ($keyedSettings['currency']->value ?? '') == 'GBP' ? 'selected' : '' }}>British Pound (GBP)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Timezone</label>
                            <select name="timezone" class="form-select">
                                <option value="America/New_York" {{ ($keyedSettings['timezone']->value ?? '') == 'America/New_York' ? 'selected' : '' }}>Eastern Time (UTC-5)</option>
                                <option value="Europe/London" {{ ($keyedSettings['timezone']->value ?? '') == 'Europe/London' ? 'selected' : '' }}>London (UTC+0)</option>
                                <option value="Asia/Tokyo" {{ ($keyedSettings['timezone']->value ?? '') == 'Asia/Tokyo' ? 'selected' : '' }}>Tokyo (UTC+9)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- HOME PAGE TAB -->
                <div id="content-homepage" class="tab-content" style="display: none;">
                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem;">
                        Homepage Sections Visibility
                    </h3>
                    <p class="text-gray-600 mb-6" style="color: #64748b; margin-bottom: 1.5rem;">
                        Toggle the visibility of different sections on your homepage. Disabled sections will not be displayed to visitors.
                    </p>

                    <div class="space-y-4" style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <!-- Hero Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-home mr-2" style="color: #3b82f6;"></i>Hero Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Main landing section with headline and CTA buttons
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_hero_section" value="1" 
                                    {{ ($keyedSettings['show_hero_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Services Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-cog mr-2" style="color: #3b82f6;"></i>Services Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Display development services offered
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_services_section" value="1" 
                                    {{ ($keyedSettings['show_services_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Products Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-box mr-2" style="color: #3b82f6;"></i>Products Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Premium code products and templates
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_products_section" value="1" 
                                    {{ ($keyedSettings['show_products_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Portfolio Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-briefcase mr-2" style="color: #3b82f6;"></i>Portfolio Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Featured work and projects showcase
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_portfolio_section" value="1" 
                                    {{ ($keyedSettings['show_portfolio_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- About Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-user mr-2" style="color: #3b82f6;"></i>About Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    About the business and experience
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_about_section" value="1" 
                                    {{ ($keyedSettings['show_about_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Testimonials Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-star mr-2" style="color: #3b82f6;"></i>Testimonials Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Client reviews and feedback
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_testimonials_section" value="1" 
                                    {{ ($keyedSettings['show_testimonials_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Blog Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-blog mr-2" style="color: #3b82f6;"></i>Blog Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Latest blog posts and insights
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_blog_section" value="1" 
                                    {{ ($keyedSettings['show_blog_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <!-- Contact Section -->
                        <div class="flex justify-between items-center p-4 rounded-lg border border-gray-200"
                            style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background: #f8fafc;">
                            <div>
                                <h4 class="font-medium text-gray-900" style="font-weight: 500; color: #0f172a; margin-bottom: 0.25rem;">
                                    <i class="fas fa-envelope mr-2" style="color: #3b82f6;"></i>Contact Section
                                </h4>
                                <p class="text-sm text-gray-500" style="font-size: 0.875rem; color: #64748b;">
                                    Contact form and CTA
                                </p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="show_contact_section" value="1" 
                                    {{ ($keyedSettings['show_contact_section']->value ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- PAYMENT TAB -->
                <div id="content-payment" class="tab-content" style="display: none;">
                    <!-- Stripe Section -->
                    <div class="payment-section p-6 rounded-lg border border-gray-200 mb-6"
                        style="border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
                        <div class="flex justify-between items-center mb-4"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <h3 class="text-lg font-bold text-gray-800"
                                style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem;">
                                <i class="fab fa-stripe fa-2x text-indigo-600"></i> Stripe Payment
                            </h3>
                            <label class="switch">
                                <input type="checkbox" name="stripe_enabled" value="1" {{ ($keyedSettings['stripe_enabled']->value ?? '') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="grid gap-4">
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Publishable Key</label>
                                <input type="text" name="stripe_key" value="{{ $keyedSettings['stripe_key']->value ?? '' }}"
                                    class="form-input font-mono text-sm">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Secret Key</label>
                                <input type="password" name="stripe_secret"
                                    value="{{ $keyedSettings['stripe_secret']->value ?? '' }}"
                                    class="form-input font-mono text-sm">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Webhook Secret</label>
                                <input type="password" name="stripe_webhook_secret"
                                    value="{{ $keyedSettings['stripe_webhook_secret']->value ?? '' }}"
                                    class="form-input font-mono text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- PayPal Section -->
                    <div class="payment-section p-6 rounded-lg border border-gray-200 mb-6"
                        style="border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
                        <div class="flex justify-between items-center mb-4"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <h3 class="text-lg font-bold text-gray-800"
                                style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem;">
                                <i class="fab fa-paypal fa-2x text-blue-600"></i> PayPal Payment
                            </h3>
                            <label class="switch">
                                <input type="checkbox" name="paypal_enabled" value="1" {{ ($keyedSettings['paypal_enabled']->value ?? '') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="grid gap-4">
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Client ID</label>
                                <input type="text" name="paypal_client_id"
                                    value="{{ $keyedSettings['paypal_client_id']->value ?? '' }}"
                                    class="form-input font-mono text-sm">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Secret</label>
                                <input type="password" name="paypal_secret"
                                    value="{{ $keyedSettings['paypal_secret']->value ?? '' }}"
                                    class="form-input font-mono text-sm">
                            </div>
                            <div class="form-group">
                                <label class="flex items-center cursor-pointer mt-2">
                                    <input type="checkbox" name="paypal_sandbox" value="1" {{ ($keyedSettings['paypal_sandbox']->value ?? '') == '1' ? 'checked' : '' }}
                                        class="mr-2">
                                    <span class="text-gray-700">Enable Sandbox Mode</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Bank Transfer Section -->
                    <div class="payment-section p-6 rounded-lg border border-gray-200"
                        style="border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1.5rem;">
                        <div class="flex justify-between items-center mb-4"
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                            <h3 class="text-lg font-bold text-gray-800"
                                style="display: flex; align-items: center; gap: 0.5rem; font-size: 1.125rem;">
                                <i class="fas fa-university fa-2x text-gray-600"></i> Bank Transfer
                            </h3>
                            <label class="switch">
                                <input type="checkbox" name="bank_transfer_enabled" value="1" {{ ($keyedSettings['bank_transfer_enabled']->value ?? '') == '1' ? 'checked' : '' }}>
                                <span class="slider round"></span>
                            </label>
                        </div>

                        <div class="grid grid-cols-2 gap-4"
                            style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Bank Name</label>
                                <input type="text" name="bank_name" value="{{ $keyedSettings['bank_name']->value ?? '' }}"
                                    class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">Account Name</label>
                                <input type="text" name="bank_account_holder"
                                    value="{{ $keyedSettings['bank_account_holder']->value ?? '' }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">IBAN / Account Number</label>
                                <input type="text" name="bank_account_number"
                                    value="{{ $keyedSettings['bank_account_number']->value ?? '' }}" class="form-input">
                            </div>
                            <div class="form-group">
                                <label class="block mb-2 font-medium text-gray-700">SWIFT / BIC Code</label>
                                <input type="text" name="bank_swift_code"
                                    value="{{ $keyedSettings['bank_swift_code']->value ?? '' }}" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SYSTEM TAB -->
                <div id="content-system" class="tab-content" style="display: none;">
                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem;">Notifications
                    </h3>
                    <div class="space-y-4 mb-8" style="display: flex; flex-direction: column; gap: 1rem;">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_new_orders" value="1" {{ ($keyedSettings['notify_new_orders']->value ?? '') == '1' ? 'checked' : '' }}
                                class="mr-3 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Email notifications for new orders</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="notify_new_messages" value="1" {{ ($keyedSettings['notify_new_messages']->value ?? '') == '1' ? 'checked' : '' }}
                                class="mr-3 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Email notifications for new messages</span>
                        </label>
                    </div>

                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem; border-top: 1px solid #e2e8f0; paddingTop: 1.5rem;">
                        System & Features</h3>
                    <div class="space-y-4" style="display: flex; flex-direction: column; gap: 1rem;">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="enable_registrations" value="1" {{ ($keyedSettings['enable_registrations']->value ?? '') == '1' ? 'checked' : '' }}
                                class="mr-3 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Allow User Registration</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="enable_shopping_cart" value="1" {{ ($keyedSettings['enable_shopping_cart']->value ?? '1') == '1' ? 'checked' : '' }}
                                class="mr-3 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700">Enable Shopping Cart (Display 'Add to Cart' buttons)</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="maintenance_mode" value="1" {{ ($keyedSettings['maintenance_mode']->value ?? '') == '1' ? 'checked' : '' }}
                                class="mr-3 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-gray-700 text-red-600 font-medium" style="color: #dc2626;">Enable Maintenance
                                Mode</span>
                        </label>
                    </div>
                </div>

                <!-- SOCIAL TAB -->
                <div id="content-social" class="tab-content" style="display: none;">
                    <h3 class="section-title mb-4"
                        style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin-bottom: 1.5rem;">Social Media
                        Links</h3>
                    <div class="grid gap-6">
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Facebook</label>
                            <div class="input-group flex" style="display: flex;">
                                <span class="input-prefix"
                                    style="padding: 0.625rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-right: none; border-radius: 0.375rem 0 0 0.375rem; color: #64748b;">
                                    <i class="fab fa-facebook-f"></i>
                                </span>
                                <input type="text" name="social_facebook"
                                    value="{{ $keyedSettings['social_facebook']->value ?? '' }}" class="form-input"
                                    style="border-radius: 0 0.375rem 0.375rem 0;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Twitter (X)</label>
                            <div class="input-group flex" style="display: flex;">
                                <span class="input-prefix"
                                    style="padding: 0.625rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-right: none; border-radius: 0.375rem 0 0 0.375rem; color: #64748b;">
                                    <i class="fab fa-twitter"></i>
                                </span>
                                <input type="text" name="social_twitter"
                                    value="{{ $keyedSettings['social_twitter']->value ?? '' }}" class="form-input"
                                    style="border-radius: 0 0.375rem 0.375rem 0;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">LinkedIn</label>
                            <div class="input-group flex" style="display: flex;">
                                <span class="input-prefix"
                                    style="padding: 0.625rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-right: none; border-radius: 0.375rem 0 0 0.375rem; color: #64748b;">
                                    <i class="fab fa-linkedin-in"></i>
                                </span>
                                <input type="text" name="social_linkedin"
                                    value="{{ $keyedSettings['social_linkedin']->value ?? '' }}" class="form-input"
                                    style="border-radius: 0 0.375rem 0.375rem 0;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="block mb-2 font-medium text-gray-700">Instagram</label>
                            <div class="input-group flex" style="display: flex;">
                                <span class="input-prefix"
                                    style="padding: 0.625rem 1rem; background: #f8fafc; border: 1px solid #cbd5e1; border-right: none; border-radius: 0.375rem 0 0 0.375rem; color: #64748b;">
                                    <i class="fab fa-instagram"></i>
                                </span>
                                <input type="text" name="social_instagram"
                                    value="{{ $keyedSettings['social_instagram']->value ?? '' }}" class="form-input"
                                    style="border-radius: 0 0.375rem 0.375rem 0;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- APPEARANCE TAB -->
                <div id="content-appearance" class="tab-content" style="display: none;">
                    <div class="flex justify-between items-center mb-6" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 class="section-title" style="font-size: 1.125rem; font-weight: 600; color: #1e293b; margin: 0;">Website Colors</h3>
                        <button type="button" onclick="resetDefaults()" class="btn btn-outline" style="padding: 0.5rem 1rem; color: #ef4444; border: 1px solid #fca5a5; background: #fef2f2; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;">
                            <i class="fas fa-undo mr-1"></i> Reset to Defaults
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-6 mb-8" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                         <div class="form-group color-picker-group">
                            <label class="block mb-2 font-medium text-gray-700">Primary Color</label>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 1rem;">
                                <input type="color" name="primary_color" value="{{ $keyedSettings['primary_color']->value ?? '#6366f1' }}" class="color-input">
                                <input type="text" value="{{ $keyedSettings['primary_color']->value ?? '#6366f1' }}" class="form-input font-mono" style="width: 120px;" readonly>
                            </div>
                        </div>

                        <div class="form-group color-picker-group">
                            <label class="block mb-2 font-medium text-gray-700">Primary Dark (Hover)</label>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 1rem;">
                                <input type="color" name="primary_hover" value="{{ $keyedSettings['primary_hover']->value ?? '#4f46e5' }}" class="color-input">
                                <input type="text" value="{{ $keyedSettings['primary_hover']->value ?? '#4f46e5' }}" class="form-input font-mono" style="width: 120px;" readonly>
                            </div>
                        </div>

                        <div class="form-group color-picker-group">
                            <label class="block mb-2 font-medium text-gray-700">Secondary Color</label>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 1rem;">
                                <input type="color" name="secondary_color" value="{{ $keyedSettings['secondary_color']->value ?? '#10b981' }}" class="color-input">
                                <input type="text" value="{{ $keyedSettings['secondary_color']->value ?? '#10b981' }}" class="form-input font-mono" style="width: 120px;" readonly>
                            </div>
                        </div>

                        <div class="form-group color-picker-group">
                            <label class="block mb-2 font-medium text-gray-700">Accent Color</label>
                            <div class="flex items-center gap-3" style="display: flex; align-items: center; gap: 1rem;">
                                <input type="color" name="accent_color" value="{{ $keyedSettings['accent_color']->value ?? '#8b5cf6' }}" class="color-input">
                                <input type="text" value="{{ $keyedSettings['accent_color']->value ?? '#8b5cf6' }}" class="form-input font-mono" style="width: 120px;" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions mt-8 pt-6 border-t border-gray-100"
                    style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary"
                        style="padding: 0.75rem 2rem; background: #3b82f6; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: background-color 0.2s;">
                        <i class="fas fa-save mr-2"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-input,
        .form-select {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .tab-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            transition: color 0.2s;
        }

        .tab-btn:hover {
            color: #3b82f6 !important;
        }

        /* Toggle Switch */
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #3b82f6;
        }

        input:checked+.slider:before {
            transform: translateX(24px);
        }

        .slider.round {
            border-radius: 24px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Image Upload Styling */
        .image-upload-container {
            width: 100%;
        }

        .upload-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 120px;
            background-color: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .upload-box:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .upload-box.dark-bg:hover {
            border-color: #3b82f6;
            background-color: #1e293b;
        }

        .preview-area {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        .preview-area img {
            max-height: 100px;
            max-width: 100%;
            object-fit: contain;
        }

        .hidden-input {
            display: none;
        }

        .hidden {
            display: none !important;
        }

        .color-input {
            width: 50px;
            height: 42px;
            border: 1px solid #cbd5e1;
            border-radius: 0.375rem;
            padding: 2px;
            cursor: pointer;
        }

        .remove-image-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 24px;
            height: 24px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 10;
            transition: all 0.2s;
        }

        .remove-image-btn:hover {
            background: #dc2626;
            transform: scale(1.1);
        }
    </style>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(el => el.style.display = 'none');

            // Remove active class from buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => {
                btn.classList.remove('active');
                btn.style.color = '#64748b';
                btn.style.borderBottom = '2px solid transparent';
            });

            // Show selected tab
            document.getElementById('content-' + tabName).style.display = 'block';

            // Activate button
            const activeBtn = document.getElementById('tab-' + tabName);
            activeBtn.classList.add('active');
            activeBtn.style.color = '#3b82f6';
            activeBtn.style.borderBottom = '2px solid #3b82f6';
        }

        function previewImage(input, type) {
            const preview = document.getElementById('img-preview-' + type);
            const placeholder = document.getElementById('placeholder-' + type);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) {
                        placeholder.classList.add('hidden');
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Color input hex sync
        document.querySelectorAll('input[type="color"]').forEach(picker => {
            picker.addEventListener('input', (e) => {
                e.target.nextElementSibling.value = e.target.value.toUpperCase();
            });
        });

        function resetDefaults() {
            if (confirm('Are you sure you want to reset all website colors to their default values?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.settings.reset-colors') }}";
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function removeImage(key) {
            if (confirm('Are you sure you want to remove this image?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('admin.settings.remove-image') }}";
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                
                const keyInput = document.createElement('input');
                keyInput.type = 'hidden';
                keyInput.name = 'setting_key';
                keyInput.value = key;
                
                form.appendChild(csrf);
                form.appendChild(keyInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection