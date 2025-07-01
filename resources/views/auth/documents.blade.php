@extends('layout.app')
@section('admin')
    <main class="full-width bg-white flex justify-center items-center py-3 transition signup-main-wrapper">
        <div class="doc-main-wrapper">
            <div>
                <h1 class="doc-wrapper-heading">Submit Your Document</h1>
                <p class="doc-wrapper-paragraph">Upload Your Document to Get Started with us.</p>
            </div>

            <form class="doc-form-wrapper w-full" action="{{ route('admin.signup.store.documents') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="doc-uploader-main-wrapper">
                    <div class="mb-1 transition flex flex-column gap-05 justify-start items-start border-box w-full">
                        <label for="company-name" id="company-name" class="transition border-box w-full company-name-label">Company Name</label>
                        <input class="transition w-full event-input border-box company-name-input" type="text" id="company-name" name="company_name" value="{{ old('company_name', Auth::user()?->company_name) }}" placeholder="ABC Corp." required>
                        @error('company_name')
                            <span class="text-primary">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="doc-uploader-main-wrapper">
                    <div>
                        <div class="mb-1 transition flex flex-column gap-05 justify-start items-start border-box w-full">
                            <label for="company-name" id="license-number" class="transition border-box w-full company-name-label">Driver Licence Number</label>
                            <input class="transition w-full event-input border-box company-name-input" type="text" id="license-number" name="license_number" value="{{ old('licence_number', Auth::user()?->license_number) }}" placeholder="DLXXXXXX" required>
                            @error('license_number')
                                <span class="text-primary">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="driver-licence" id="driver-licence" class="transition border-box w-full company-name-label">Driver Licence</label>
                            <p class="doc-uploader-text-info">only JPEG and PDFs are accepted</p>
                        </div>
                        <div class="custom-doc-upload-wrapper">
                            <button class="input-btn transition w-full mb-05-rem event-input border-box cursor-pointer driver-licence-btn custom-doc-upload-btn" type="button" value="">Upload Driver Licence</button>
                            @if(Auth::user()?->license_file)
                                <button type="button" class="custom-doc-show-file-btn">
                                    <span>{{ Auth::user()?->license_file['filename'] }}</span>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @else
                                <button type="button" class="custom-doc-show-file-btn hidden">
                                    <span>No File Chosen</span>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @endif
                            <input type="file" name="license_file" class="hidden" accept=".jpg,.jpeg,.pdf">
                            @error('license_file')
                            <span class="text-primary">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="mb-1 transition flex flex-column gap-05 justify-start items-start border-box w-full">
                            <label for="company-name" id="address-proof" class="transition border-box w-full company-name-label">Select Address Proof</label>
                            <select class="transition w-full event-input border-box company-name-input" type="text" id="address-proof" name="address_proof" placeholder="ABC Corp." required>
                                <option value="">Select Address Proof</option>
                                <option value="{{ \App\Enums\Proof::UTILITY }}" @if( Auth::user()?->address_proof == 'utility_bill') selected @endif>Utility Bill</option>
                                <option value="{{ \App\Enums\Proof::BANK }}" @if( Auth::user()?->address_proof == 'bank_statement') selected @endif>Bank Statement</option>
                                <option value="{{ \App\Enums\Proof::PASSPORT }}" @if( Auth::user()?->address_proof == 'passport') selected @endif>Passport</option>
                            </select>
                            @error('address_proof')
                            <span class="text-primary">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="address-proof" id="address-proof" class="transition border-box w-full company-name-label">Address Proof</label>
                            <p class="doc-uploader-text-info">only JPEG and PDFs are accepted</p>
                        </div>
                        <div class="custom-doc-upload-wrapper">
                            <button class="input-btn transition w-full mb-05-rem event-input border-box cursor-pointer driver-licence-btn custom-doc-upload-btn" type="button" value="">Upload  Address Proof</button>
                            @if(Auth::user()?->address_proof_file)
                                <button type="button" class="custom-doc-show-file-btn">
                                    <span>{{ Auth::user()?->address_proof_file['filename'] }}</span>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @else
                                <button type="button" class="custom-doc-show-file-btn hidden">
                                    <span>No File Chosen</span>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            @endif
                            <input type="file" name="address_proof_file" class="hidden" accept=".jpg,.jpeg,.pdf">
                            @error('address_proof_file')
                            <span class="text-primary">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="transition flex flex-column gap-05 justify-start items-start border-box">
                    <button type="submit" class="transition text-white base-form-event-wrapper-btn w-full border-box create-event-default-btn">Upload Documents</button>
                </div>

            </form>



        </div>
    </main>
@endsection