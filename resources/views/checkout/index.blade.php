@extends('layouts.app')

@section('title', 'Checkout | CodeCraft Studio')

@section('content')
    <!-- Checkout Hero -->
    <section class="checkout-hero"
        style="background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%); padding: 60px 0;">
        <div class="container text-center">
            <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 1rem;">Checkout</h1>
            <p style="color: var(--text-secondary); font-size: 1.125rem;">Secure your order and start your journey</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if(session('error'))
                <div class="alert alert-danger mb-5"
                    style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="checkout-grid"
                    style="display: grid; grid-template-columns: 1fr 420px; gap: 60px; align-items: start;">

                    <!-- Billing & Payment -->
                    <div class="checkout-form-column">
                        <!-- Billing Details -->
                        <div class="card mb-5"
                            style="border-radius: 24px; border: 1px solid var(--border-color); padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                            <h3
                                style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem; display: flex; align-items: center; gap: 15px;">
                                <span
                                    style="width: 35px; height: 35px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">1</span>
                                Billing Information
                            </h3>

                            <div class="row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div style="grid-column: span 2;">
                                    <label
                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-primary);">Full
                                        Name *</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}"
                                        style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);">
                                </div>
                                <div style="grid-column: span 1;">
                                    <label
                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-primary);">Email
                                        Address *</label>
                                    <input type="email" name="email" class="form-control" required
                                        value="{{ old('email') }}"
                                        style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);">
                                </div>
                                <div style="grid-column: span 1;">
                                    <label
                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-primary);">Company
                                        (Optional)</label>
                                    <input type="text" name="company" class="form-control" value="{{ old('company') }}"
                                        style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);">
                                </div>
                                <div style="grid-column: span 2;">
                                    <label
                                        style="display: block; margin-bottom: 8px; font-weight: 600; color: var(--text-primary);">Order
                                        Notes (Optional)</label>
                                    <textarea name="notes" class="form-control" rows="3"
                                        style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid var(--border-color); background: var(--bg-primary); color: var(--text-primary);">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Methods -->
                        @if($total > 0)
                            <div class="card"
                                style="border-radius: 24px; border: 1px solid var(--border-color); padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                                <h3
                                    style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem; display: flex; align-items: center; gap: 15px;">
                                    <span
                                        style="width: 35px; height: 35px; background: var(--primary-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1rem;">2</span>
                                    Payment Method
                                </h3>
    
                                <div class="payment-options" style="display: flex; flex-direction: column; gap: 15px;">
                                    @forelse($paymentMethods as $index => $method)
                                        <label class="payment-option"
                                            style="display: block; position: relative; border: 2px solid var(--border-color); border-radius: 16px; padding: 20px; cursor: pointer; transition: 0.3s;"
                                            onclick="selectPayment(this)">
                                            <input type="radio" name="payment_method" value="{{ $method->provider }}" {{ $index == 0 ? 'checked' : '' }} style="position: absolute; opacity: 0;">
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                                <div style="display: flex; align-items: center; gap: 15px;">
                                                    <div class="radio-custom"
                                                        style="width: 20px; height: 20px; border: 2px solid var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                        <div class="radio-inner"
                                                            style="width: 10px; height: 10px; background: var(--primary-color); border-radius: 50%; opacity: {{ $index == 0 ? '1' : '0' }};">
                                                        </div>
                                                    </div>
                                                    <span style="font-weight: 700; font-size: 1.1rem;">
                                                        @if($method->provider == 'stripe')
                                                            Credit / Debit Card (Stripe)
                                                        @elseif($method->provider == 'paypal')
                                                            PayPal
                                                        @elseif($method->provider == 'bank_transfer')
                                                            Bank Transfer
                                                        @else
                                                            {{ $method->provider_name }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div style="font-size: 1.5rem; color: var(--text-tertiary);">
                                                    @if($method->provider == 'stripe')
                                                        <i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard"></i> <i class="fab fa-cc-stripe"></i>
                                                    @elseif($method->provider == 'paypal')
                                                        <i class="fab fa-paypal"></i>
                                                    @elseif($method->provider == 'bank_transfer')
                                                        <i class="fas fa-university"></i>
                                                    @endif
                                                </div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="alert alert-warning">No payment methods available. Please contact support.</div>
                                    @endforelse
                                </div>
                            </div>
                        @else
                            <div class="card" style="border-radius: 24px; border: 1px solid #10b981; padding: 2.5rem; background: rgba(16, 185, 129, 0.05); box-shadow: 0 10px 30px rgba(0,0,0,0.02);">
                                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: #10b981; display: flex; align-items: center; gap: 15px;">
                                    <i class="fas fa-gift"></i> Free Checkout
                                </h3>
                                <p style="color: var(--text-secondary); margin-bottom: 0;">This order is completely free! No payment information is required. Just provide your billing details to get your downloads.</p>
                                <input type="hidden" name="payment_method" value="free_download">
                            </div>
                        @endif
                    </div>

                    <!-- Order Summary Stick -->
                    <div class="checkout-summary-column">
                        <div class="card"
                            style="border-radius: 24px; border: none; background: var(--bg-secondary); padding: 2.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.05); position: sticky; top: 120px;">
                            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem;">Your Order</h3>

                            <div class="checkout-items"
                                style="max-height: 300px; overflow-y: auto; margin-bottom: 2rem; padding-right: 10px;">
                                @foreach($cart as $id => $details)
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                                        <div style="display: flex; gap: 12px; align-items: center;">
                                            <div
                                                style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                                                <img src="{{ $details['image'] }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; font-size: 0.95rem;">{{ $details['name'] }}</div>
                                                <div style="font-size: 0.8rem; color: var(--text-tertiary);">Qty:
                                                    {{ $details['quantity'] }}</div>
                                            </div>
                                        </div>
                                        <div style="font-weight: 700;">
                                            ${{ number_format($details['price'] * $details['quantity'], 2) }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <hr style="border: none; border-top: 2px dashed var(--border-color); margin-bottom: 2rem;">

                            <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 2rem;">
                                <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                                    <span>Subtotal</span>
                                    <span style="font-weight: 600;">${{ number_format($total, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="font-size: 1.1rem; font-weight: 700;">Total</span>
                                    <span
                                        style="font-size: 1.75rem; font-weight: 800; color: var(--primary-color);">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-large w-100"
                                style="padding: 1.25rem; font-size: 1.1rem; border-radius: 16px; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);">
                                Complete Purchase <i class="fas fa-lock ms-2"></i>
                            </button>

                            <div
                                style="margin-top: 2rem; text-align: center; font-size: 0.85rem; color: var(--text-tertiary);">
                                <p>By completing this purchase, you agree to our <a href="#"
                                        style="color: var(--primary-color); text-decoration: none;">Terms of Service</a>.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </section>

    <script>
        function selectPayment(element) {
            // Remove active style from all
            document.querySelectorAll('.payment-option').forEach(opt => {
                opt.style.borderColor = 'var(--border-color)';
                opt.style.backgroundColor = 'transparent';
                opt.querySelector('.radio-inner').style.opacity = '0';
            });

            // Add active style to selected
            element.style.borderColor = 'var(--primary-color)';
            element.style.backgroundColor = 'var(--bg-tertiary)';
            element.querySelector('.radio-inner').style.opacity = '1';

            // Check the radio
            element.querySelector('input').checked = true;
        }

        // Initialize first one
        document.addEventListener('DOMContentLoaded', () => {
            const firstOption = document.querySelector('.payment-option');
            if (firstOption) selectPayment(firstOption);
        });
    </script>

    <style>
        .checkout-items::-webkit-scrollbar {
            width: 4px;
        }

        .checkout-items::-webkit-scrollbar-track {
            background: transparent;
        }

        .checkout-items::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        @media (max-width: 1024px) {
            .checkout-grid {
                grid-template-columns: 1fr !important;
                gap: 40px !important;
            }

            .checkout-summary-column {
                position: static !important;
            }
        }
    </style>
@endsection