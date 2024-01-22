<x-auth-layout>

    <div class="mb-4 text-sm text-gray-600">
        {{ new Illuminate\Support\HtmlString(__("Received an email with a login code? If not, click <a class=\"hover:underline\" href=\":url\">here</a>.", ['url' => route('verify.resend')])) }}
    </div>

    <!--begin::Forgot Password Form-->
    <form class="form w-100" novalidate="novalidate" id="kt_password_reset_form" action="{{ route('verify.check') }}">
    @csrf

    <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">Please enter a Code sent via Email:</h1>
            <!--end::Title-->
             
        </div>
        <!--begin::Heading-->
        <!--begin::Input group=-->
        <div class="fv-row mb-8 fv-plugins-icon-container">
            <!--begin::two_factor_code-->
            <input placeholder="Code" type="password" name="two_factor_code" class="form-control bg-transparent">
            <!--end::two_factor_code-->
            @error('two_factor_code') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!--begin::Actions-->
        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" class="btn btn-primary me-4">
                Verify
            </button>
            <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>                         
        </div>
        <!--end::Actions-->
        <div></div>
    </form>
    <!--end::Forgot Password Form-->

</x-auth-layout>

