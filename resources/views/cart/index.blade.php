@extends('layouts.app')

@section('title', 'Shopping Cart | CodeCraft Studio')

@section('content')
    <!-- Cart Hero -->
    <section class="cart-hero" style="background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-tertiary) 100%); padding: 60px 0;">
        <div class="container text-center">
            <h1 style="font-size: 3rem; font-weight: 800; margin-bottom: 1rem;">Your Shopping Cart</h1>
            <p style="color: var(--text-secondary); font-size: 1.125rem;">Review your items and proceed to checkout</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success mb-5" style="border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            @if(count($cart) > 0)
                <div class="cart-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 60px; align-items: start;">
                    <!-- Cart Items -->
                    <div class="cart-items-column">
                        <div class="card" style="border-radius: 20px; border: 1px solid var(--border-color); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                            <table class="cart-table" style="width: 100%; border-collapse: collapse;">
                                <thead style="background-color: var(--bg-secondary);">
                                    <tr>
                                        <th style="padding: 1.5rem; text-align: left; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary);">Product</th>
                                        <th style="padding: 1.5rem; text-align: center; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary);">Price</th>
                                        <th style="padding: 1.5rem; text-align: center; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary);">Qty</th>
                                        <th style="padding: 1.5rem; text-align: right; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-tertiary);">Subtotal</th>
                                        <th style="padding: 1.5rem;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach($cart as $id => $details)
                                        @php $total += $details['price'] * $details['quantity']; @endphp
                                        <tr style="border-bottom: 1px solid var(--border-color);">
                                            <td style="padding: 1.5rem;">
                                                <div style="display: flex; align-items: center; gap: 20px;">
                                                    <div style="width: 80px; height: 80px; border-radius: 12px; overflow: hidden; background-color: var(--bg-tertiary); border: 1px solid var(--border-color);">
                                                        @if($details['image'])
                                                            <img src="{{ $details['image'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                        @else
                                                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-tertiary);">
                                                                <i class="fas fa-box fa-2x"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700;">{{ $details['name'] }}</h4>
                                                        <span style="font-size: 0.85rem; color: var(--text-tertiary);">Item ID: {{ substr($id, 0, 8) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="padding: 1.5rem; text-align: center; font-weight: 600;">
                                                ${{ number_format($details['price'], 2) }}
                                            </td>
                                            <td style="padding: 1.5rem;">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                           style="width: 60px; padding: 8px; border-radius: 8px; border: 2px solid var(--border-color); text-align: center; font-weight: 600; background: var(--bg-primary); color: var(--text-primary);" 
                                                           min="1">
                                                    <button type="submit" class="btn-icon" style="background: var(--bg-secondary); border: none; width: 32px; height: 32px; border-radius: 8px; cursor: pointer; color: var(--primary-color);" title="Update">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td style="padding: 1.5rem; text-align: right; font-weight: 700; color: var(--primary-color);">
                                                ${{ number_format($details['price'] * $details['quantity'], 2) }}
                                            </td>
                                            <td style="padding: 1.5rem; text-align: right;">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="background: none; border: none; color: #ef4444; opacity: 0.6; transition: 0.2s; cursor: pointer;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.6'">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 2rem;">
                            <a href="{{ url('/#products') }}" style="display: inline-flex; align-items: center; gap: 10px; color: var(--text-secondary); text-decoration: none; font-weight: 500;" onmouseover="this.style.color='var(--primary-color)'" onmouseout="this.style.color='var(--text-secondary)'">
                                <i class="fas fa-arrow-left"></i> Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="cart-summary-column">
                        <div class="card" style="border-radius: 24px; border: none; background: var(--bg-secondary); padding: 2.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.05); position: sticky; top: 120px;">
                            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 2rem;">Order Summary</h3>
                            
                            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2rem;">
                                <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                                    <span>Subtotal</span>
                                    <span style="font-weight: 600;">${{ number_format($total, 2) }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                                    <span>Shipping</span>
                                    <span style="font-weight: 600; color: #10b981;">Free</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                                    <span>Tax</span>
                                    <span style="font-weight: 600;">$0.00</span>
                                </div>
                            </div>
                            
                            <hr style="border: none; border-top: 2px dashed var(--border-color); margin-bottom: 2rem;">
                            
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                                <span style="font-size: 1.25rem; font-weight: 700;">Total</span>
                                <span style="font-size: 2rem; font-weight: 800; color: var(--primary-color);">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-large w-100" style="padding: 1.25rem; font-size: 1.1rem; border-radius: 16px; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);">
                                Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            
                            <div style="margin-top: 2rem; text-align: center;">
                                <p style="font-size: 0.85rem; color: var(--text-tertiary); margin-bottom: 1.5rem;">
                                    <i class="fas fa-shield-alt me-2"></i> Secure SSL Encrypted Checkout
                                </p>
                                <div style="display: flex; justify-content: center; gap: 15px; opacity: 0.5;">
                                    <i class="fab fa-cc-visa fa-2x"></i>
                                    <i class="fab fa-cc-mastercard fa-2x"></i>
                                    <i class="fab fa-cc-stripe fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div style="text-align: center; padding: 100px 0;">
                    <div style="width: 120px; height: 120px; background-color: var(--bg-secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: var(--text-tertiary);">
                        <i class="fas fa-shopping-cart fa-3x"></i>
                    </div>
                    <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 1rem;">Your cart is empty</h2>
                    <p style="color: var(--text-secondary); margin-bottom: 2.5rem; max-width: 400px; margin-left: auto; margin-right: auto;">
                        Looks like you haven't added anything to your cart yet. Check out our products and start building!
                    </p>
                    <a href="{{ url('/#products') }}" class="btn btn-primary btn-large">Browse Products</a>
                </div>
            @endif
        </div>
    </section>

    <style>
        @media (max-width: 1024px) {
            .cart-grid { grid-template-columns: 1fr !important; gap: 40px !important; }
            .cart-summary-column { position: static !important; }
            .cart-table th:nth-child(2), .cart-table td:nth-child(2) { display: none; }
        }
    </style>
@endsection