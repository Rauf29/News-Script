@extends('layouts.front')
@section('meta')
<title>{{ $gs->title }} - Privacy Policy / গোপনীয়তা নীতি</title>
<meta name="description" content="{{ $gs->title }} privacy policy - how we collect, use, and protect your personal information.">
@endsection
@section('contents')
<style>
.privacy-page { max-width: 800px; margin: 30px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); font-size: 16px; line-height: 1.8; color: #333; }
.privacy-page h1 { font-size: 28px; color: #222; margin-bottom: 10px; padding-bottom: 15px; border-bottom: 2px solid #e74c3c; }
.privacy-page .updated { color: #888; font-size: 14px; margin-bottom: 25px; }
.privacy-page h4 { font-size: 18px; color: #222; margin: 25px 0 10px; }
.privacy-page p { margin-bottom: 12px; }
.privacy-page ul { margin: 10px 0 15px 20px; }
.privacy-page ul li { margin-bottom: 8px; list-style: disc; }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="privacy-page">
                <h1>Privacy Policy / গোপনীয়তা নীতি</h1>
                <p class="updated">Last updated: June 2026</p>

                <h4>1. Introduction</h4>
                <p>{{ $gs->title }} ("we," "our," or "us") respects your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>

                <h4>2. Information We Collect</h4>
                <ul>
                    <li><strong>Personal Data:</strong> Name, email address, and other details you voluntarily provide when registering or contacting us.</li>
                    <li><strong>Usage Data:</strong> Pages visited, time spent, browser type, device information, and IP address collected automatically.</li>
                    <li><strong>Cookies:</strong> Small text files stored on your device to improve your browsing experience.</li>
                </ul>

                <h4>3. How We Use Your Information</h4>
                <ul>
                    <li>To operate and maintain our website</li>
                    <li>To send newsletters or updates (with your consent)</li>
                    <li>To improve user experience and content</li>
                    <li>To comply with legal obligations</li>
                </ul>

                <h4>4. Third-Party Services</h4>
                <p>We may use third-party services that collect, monitor, and analyze data:</p>
                <ul>
                    <li><strong>Google Analytics</strong> – for traffic analysis</li>
                    <li><strong>Google AdSense</strong> – for advertisements</li>
                    <li><strong>Facebook Comments/SDK</strong> – for social features</li>
                    <li><strong>ShareThis</strong> – for social sharing buttons</li>
                </ul>
                <p>These third parties have their own privacy policies governing your data.</p>

                <h4>5. Cookies</h4>
                <p>We use cookies to enhance your experience. You can control cookie settings in your browser. Disabling cookies may affect some website features.</p>

                <h4>6. Data Security</h4>
                <p>We implement reasonable security measures to protect your personal data. However, no method of transmission over the internet is 100% secure.</p>

                <h4>7. Your Rights</h4>
                <p>You have the right to:</p>
                <ul>
                    <li>Access, update, or delete your personal data</li>
                    <li>Opt out of marketing communications</li>
                    <li>Disable cookies via browser settings</li>
                </ul>

                <h4>8. Contact Us</h4>
                <p>If you have questions about this Privacy Policy, please contact us:</p>
                <ul>
                    <li>Email: {{ $gs->email ?? 'Not available' }}</li>
                    <li>Phone: {{ $gs->phone ?? 'Not available' }}</li>
                    <li>Address: {{ $gs->adress ?? 'Not available' }}</li>
                </ul>

                <h4>9. Changes to This Policy</h4>
                <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated date.</p>
            </div>
        </div>
    </div>
</div>
@endsection
