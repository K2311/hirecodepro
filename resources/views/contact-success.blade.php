@extends('layouts.app')

@section('title', 'Message Sent | CodeCraft Studio')

@section('content')
    <!-- Success Section -->
    <section class="success-section">
        <div class="container">
            <div class="success-content">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <h1>Message Sent Successfully!</h1>

                <p class="success-message">
                    Thank you for reaching out! I've received your inquiry and will get back to you within 24 hours.
                </p>

                <div class="success-details">
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>Response Time: Within 24 hours</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-envelope"></i>
                        <span>Check your email for confirmation</span>
                    </div>
                </div>

                <div class="success-actions">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-large">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline btn-large">
                        <i class="fas fa-envelope"></i> Send Another Message
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.success-section {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 80px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.success-content {
    text-align: center;
    color: white;
    max-width: 600px;
    margin: 0 auto;
}

.success-icon {
    font-size: 5rem;
    color: #10b981;
    margin-bottom: 2rem;
    animation: checkmark 0.8s ease-in-out;
}

@keyframes checkmark {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.success-content h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.success-message {
    font-size: 1.125rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.success-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 3rem;
    padding: 1.5rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.detail-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    font-size: 1rem;
}

.detail-item i {
    color: #10b981;
    font-size: 1.125rem;
}

.success-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn-outline {
    background: transparent;
    border: 2px solid white;
    color: white;
}

.btn-outline:hover {
    background: white;
    color: #667eea;
}

/* Responsive */
@media (max-width: 768px) {
    .success-section {
        padding: 60px 0;
    }

    .success-content h1 {
        font-size: 2rem;
    }

    .success-icon {
        font-size: 4rem;
    }

    .success-actions {
        flex-direction: column;
        align-items: center;
    }

    .success-actions .btn {
        width: 100%;
        max-width: 300px;
    }

    .success-details {
        padding: 1rem;
    }

    .detail-item {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endpush