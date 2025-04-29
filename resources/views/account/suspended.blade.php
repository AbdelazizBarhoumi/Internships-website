<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Account Suspended') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col items-center justify-center text-center space-y-6">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 w-full" role="alert">
                            <div class="flex">
                                <div class="py-1">
                                    <svg class="h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold">Account Suspended</p>
                                    <p class="text-sm">
                                        @if(Auth::user()->suspension_reason)
                                            Reason: {{ Auth::user()->suspension_reason }}
                                        @else
                                            Your account has been suspended by an administrator.
                                        @endif
                                    </p>
                                    <p class="text-xs mt-1 text-red-600">
                                        @if(Auth::user()->suspension_date)
                                            Suspended on: {{ Auth::user()->suspension_date->format('F j, Y, g:i a') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        @if(session('message'))
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 w-full" role="alert">
                                <p class="font-bold">Action Restricted</p>
                                <p>{{ session('message') }}</p>
                            </div>
                        @endif
                        
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">What does this mean?</h3>
                            <p class="mt-2 text-gray-600">
                                While your account is suspended, you cannot:
                            </p>
                            
                            @if(Auth::user()->isEmployer())
                                <!-- Employer-specific restrictions -->
                                <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                    <li>Post new internship opportunities</li>
                                    <li>Edit existing internship listings</li>
                                    <li>View or manage applications</li>
                                    <li>Download applicant documents</li>
                                    <li>Contact applicants</li>
                                    <li>Update your company profile</li>
                                </ul>
                                <p class="mt-4 text-gray-600">
                                    <strong class="text-red-600">Important:</strong> Your current internship listings are temporarily hidden from applicants.
                                </p>
                            @else
                                <!-- Student-specific restrictions -->
                                <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                    <li>Apply for internships</li>
                                    <li>View your application status</li>
                                    <li>Update your profile</li>
                                    <li>Upload or update documents</li>
                                    <li>Contact employers</li>
                                </ul>
                                <p class="mt-4 text-gray-600">
                                    <strong class="text-red-600">Note:</strong> Your current applications remain visible to employers, but you cannot interact with them.
                                </p>
                            @endif
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Why was my account suspended?</h3>
                            <p class="mt-2 text-gray-600">
                                Accounts may be suspended for various reasons, including:
                            </p>
                            
                            @if(Auth::user()->isEmployer())
                                <!-- Employer-specific reasons -->
                                <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                    <li>Posting misleading internship opportunities</li>
                                    <li>Requesting inappropriate information from applicants</li>
                                    <li>Violating our terms regarding fair compensation policies</li>
                                    <li>Multiple complaints from applicants</li>
                                    <li>Verification issues with your company information</li>
                                </ul>
                            @else
                                <!-- Student-specific reasons -->
                                <ul class="list-disc list-inside mt-2 text-gray-600 space-y-1">
                                    <li>Submitting fraudulent application materials</li>
                                    <li>Creating multiple accounts</li>
                                    <li>Inappropriate behavior in communications</li>
                                    <li>Violation of our community guidelines</li>
                                    <li>Suspicious activity detected in your account</li>
                                </ul>
                            @endif
                        </div>
                        
                        <div class="mt-8 border-t pt-8 w-full">
                            <h3 class="text-lg font-medium text-gray-900">What should I do now?</h3>
                            
                            <div class="mt-4 bg-gray-50 rounded-lg p-4 text-left">
                                <p class="text-gray-700">To appeal this suspension, please provide detailed information:</p>
                                <form action="{{ route('account.appeal') }}" method="POST" class="mt-4 space-y-4">
                                    @csrf
                                    <div>
                                        <label for="appeal_reason" class="block text-sm font-medium text-gray-700 text-left">Reason for appeal</label>
                                        <textarea id="appeal_reason" name="appeal_reason" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Please explain why you believe your account should be reinstated..."></textarea>
                                    </div>
                                    
                                    <div>
                                        <label for="additional_info" class="block text-sm font-medium text-gray-700 text-left">Additional information</label>
                                        <textarea id="additional_info" name="additional_info" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Any relevant details that could help us review your case..."></textarea>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input id="acknowledge" name="acknowledge" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <label for="acknowledge" class="ml-2 block text-sm text-gray-700">
                                            I understand the terms of service and agree to comply with the platform rules
                                        </label>
                                    </div>
                                    
                                    <div class="flex justify-center">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Submit Appeal
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="mt-6 text-sm text-gray-600">
                                <p>Alternative contact methods:</p>
                                <div class="flex justify-center space-x-4 mt-2">
                                    <a href="mailto:support@internships-website.com" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                        </svg>
                                        Email Support
                                    </a>
                                    <a href="tel:+11234567890" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                        Call Support
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 w-full border-t pt-4">
                            <p class="text-xs text-gray-500">
                                Appeal review typically takes 1-2 business days. You'll receive a notification via email once your appeal has been reviewed.
                                @if(Auth::user()->suspension_end_date)
                                    <br><br>
                                    <span class="font-semibold">Automatic reinstatement date: {{ Auth::user()->suspension_end_date->format('F j, Y') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load scripts specific to this page -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enable form validation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const appealReason = document.getElementById('appeal_reason').value.trim();
                const acknowledgeBox = document.getElementById('acknowledge');
                
                if (appealReason.length < 20) {
                    e.preventDefault();
                    alert('Please provide more information in your appeal reason (at least 20 characters).');
                    return false;
                }
                
                if (!acknowledgeBox.checked) {
                    e.preventDefault();
                    alert('Please acknowledge that you understand and agree to comply with the platform rules.');
                    return false;
                }
                
                return true;
            });
        });
    </script>
</x-app-layout>