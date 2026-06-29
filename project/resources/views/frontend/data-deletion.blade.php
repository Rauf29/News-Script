@extends('layouts.front')
@section('meta')
<title>{{ $gs->title }} - Data Deletion Request / ডেটা মুছে ফেলার অনুরোধ</title>
<meta name="description" content="Request deletion of your personal data from {{ $gs->title }}.">
@endsection
@section('contents')
<style>
.privacy-page { max-width: 800px; margin: 30px auto; padding: 30px; background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); font-size: 16px; line-height: 1.8; color: #333; }
.privacy-page h1 { font-size: 28px; color: #222; margin-bottom: 10px; padding-bottom: 15px; border-bottom: 2px solid #e74c3c; }
.privacy-page h4 { font-size: 18px; color: #222; margin: 25px 0 10px; }
.privacy-page p { margin-bottom: 12px; }
.privacy-page ul { margin: 10px 0 15px 20px; }
.privacy-page ul li { margin-bottom: 8px; list-style: disc; }
</style>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="privacy-page">
                <h1>Data Deletion Request / ডেটা মুছে ফেলার অনুরোধ</h1>
                <p>Last updated: June 2026</p>

                <h4>How to Request Data Deletion</h4>
                <p>If you wish to delete your personal data from {{ $gs->title }}, you can request it in two ways:</p>

                <h4>Option 1: Through Your Account</h4>
                <ul>
                    <li>Log in to your account on {{ $gs->title }}</li>
                    <li>Go to your Profile / Dashboard settings</li>
                    <li>Look for the account deletion or data removal option</li>
                    <li>Follow the instructions to delete your account and associated data</li>
                </ul>

                <h4>Option 2: Contact Us Directly</h4>
                <p>Send an email from the registered email address with the subject "Data Deletion Request" to:</p>
                <ul>
                    <li>Email: {{ $gs->email ?? 'Not available' }}</li>
                </ul>
                <p>We will process your request within 30 days and confirm once your data has been deleted.</p>

                <h4>What Data Will Be Deleted</h4>
                <ul>
                    <li>Your account information (name, email, profile data)</li>
                    <li>Your comments and activity on the site</li>
                    <li>Any personal data you provided during registration</li>
                </ul>

                <h4>Data That May Be Retained</h4>
                <p>Some data may be retained for legal obligations or legitimate business purposes (e.g., transaction records required by law). This data will be anonymized where possible.</p>

                <h4>Contact</h4>
                <p>For any questions about data deletion, contact us at {{ $gs->email ?? 'Not available' }}.</p>
            </div>
        </div>
    </div>
</div>
@endsection
