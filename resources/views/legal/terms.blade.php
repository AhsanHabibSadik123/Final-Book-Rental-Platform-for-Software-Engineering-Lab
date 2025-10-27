@extends('layouts.app')

@section('content')
<div class="content p-4 p-md-5 shadow-sm" style="background:#fff; border-radius:.75rem;">
    <h1 class="h3 mb-2">Terms & Conditions</h1>
    <p class="text-muted mb-4">Last updated: {{ date('F j, Y') }}</p>

    <h2 class="h5 mt-4">1. Acceptance of Terms</h2>
    <p>By creating an account or using {{ config('app.name', 'BookStore') }}, you agree to these Terms & Conditions and our policies referenced herein. If you do not agree, do not use the Service.</p>

    <h2 class="h5 mt-4">2. Eligibility and Accounts</h2>
    <ul>
        <li>You must provide accurate information and keep your account secure.</li>
        <li>You are responsible for all activity under your account.</li>
    </ul>

    <h2 class="h5 mt-4">3. Roles</h2>
    <p>Users may act as borrowers and/or lenders. Additional permissions are granted to administrators for platform management.</p>

    <h2 class="h5 mt-4">4. Listings and Availability</h2>
    <ul>
        <li>Lenders must ensure books are accurately described and available as indicated.</li>
        <li>The platform may remove or modify listings that violate policies or law.</li>
    </ul>

    <h2 class="h5 mt-4">5. Renting and Payments</h2>
    <ul>
        <li>Renters are charged the rental amount (price per day × selected days) plus any security deposit at checkout.</li>
        <li>Payments occur within in-app wallets; external settlement methods may be added in the future.</li>
        <li>Borrowing limits may apply. You may have a maximum number of active rentals at one time. The platform may block checkout if you exceed your limit.</li>
    </ul>

    <h2 class="h5 mt-4">6. Security Deposit</h2>
    <ul>
        <li>Deposits are held until the book is returned. Upon timely and acceptable return, deposits are refunded to the borrower.</li>
        <li>In case of loss or damage, applicable amounts may be deducted according to these Terms and applicable policies.</li>
        <li>Users are responsible for the condition of borrowed materials. Damage or loss may result in deductions from the deposit and/or additional fines, up to the full replacement cost where applicable.</li>
    </ul>

    <h2 class="h5 mt-4">7. Returns and Refunds</h2>
    <ul>
        <li>On return completion, the book status becomes available again.</li>
        <li>Prepaid rentals: deposit is refunded to the borrower; rental proceeds are released to the lender.</li>
        <li>Non-prepaid or legacy rentals are settled per policy, which may require additional borrower payment.</li>
        <li>Due dates must be respected. Items should be returned on time to the designated drop-off point. Late returns may incur fees or affect account standing.</li>
    </ul>

    <h2 class="h5 mt-4">8. Fees and Wallet</h2>
    <ul>
        <li>The platform may charge fees or commissions, which can be deducted from payouts.</li>
        <li>You must maintain sufficient wallet balance to complete transactions.</li>
    </ul>

    <h2 class="h5 mt-4">9. Prohibited Conduct</h2>
    <ul>
        <li>Do not list unlawful, infringing, or misrepresented items.</li>
        <li>No fraud, harassment, or circumvention of the platform.</li>
    </ul>

    <h2 class="h5 mt-4">10. Content and Intellectual Property</h2>
    <p>You grant the platform a limited license to display your listings and content for operating the Service. Do not upload content you do not have rights to use.</p>

    <h2 class="h5 mt-4">11. Privacy</h2>
    <p>Your use of the Service is also governed by our Privacy Policy. We process data as described therein.</p>

    <h2 class="h5 mt-4">12. Disclaimers</h2>
    <p>The Service is provided “as is” without warranties of any kind. We do not guarantee continuous availability or error-free operation.</p>

    <h2 class="h5 mt-4">13. Limitation of Liability</h2>
    <p>To the maximum extent permitted by law, {{ config('app.name', 'BookStore') }} is not liable for indirect, incidental, or consequential damages arising from your use of the Service.</p>

    <h2 class="h5 mt-4">14. Termination</h2>
    <p>We may suspend or terminate accounts that violate these Terms or applicable laws. You may stop using the Service at any time.</p>

    <h2 class="h5 mt-4">15. Changes to Terms</h2>
    <p>We may update these Terms from time to time. Continued use of the Service after changes means you accept the updated Terms.</p>

    <h2 class="h5 mt-4">16. Contact</h2>
    <p>Questions about these Terms? Contact us at <a href="mailto:support@bookstore.com">support@bookstore.com</a>.</p>

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back</a>
        <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="fas fa-home me-1"></i> Dashboard</a>
    </div>
</div>
@endsection