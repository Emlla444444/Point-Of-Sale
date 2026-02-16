@extends('user.layout.master')

@section('content')
    <div class="row">
        <div class="offset-2">
            <div class="fcf-body container" style="margin-top: 150px">
                <div class="fcf-form-wrap">
                    <div id="fcf-form">
                        <form class="{{ route('user#contact') }}" method="post">
                            @csrf
                            <div class="mb-5">
                                <h1 class="text-dark text-center">Contact Us</h1>
                            </div>
                            <div class="fcf-field">
                                <label for="Name" class="fcf-label has-text-weight-normal">Your name</label>
                                <div class="fcf-control">
                                    <input type="text" name="Name" id="Name"
                                        class="fcf-input is-full-width @error('Name')
                                                            is-invalid
                                                        @enderror"
                                        maxlength="60" data-validate-field="Name" value="{{ old('Name') }}">
                                    @error('Name')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="fcf-field">
                                <label for="Email" class="fcf-label has-text-weight-normal">Your email address</label>
                                <div class="fcf-control">
                                    <input type="email" name="Email" id="Email"
                                        class="fcf-input is-full-width @error('Email')
                                                            is-invalid
                                                        @enderror"
                                        maxlength="100" data-validate-field="Email" value="{{ old('Email') }}">
                                    @error('Email')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="fcf-field">
                                <label for="Phone" class="fcf-label has-text-weight-normal">Title</label>
                                <div class="fcf-control">
                                    <input type="text" name="Title" id="Phone"
                                        class="fcf-input is-full-width @error('Title')
                                                            is-invalid
                                                        @enderror"
                                        maxlength="30" data-validate-field="Phone" value="{{ old('Title') }}">
                                    @error('Title')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="fcf-field">
                                <label for="Message" class="fcf-label has-text-weight-normal">Your message</label>
                                <div class="fcf-control">
                                    <textarea name="Message" id="Message"
                                        class="fcf-textarea @error('Message')
                                                            is-invalid
                                                        @enderror"
                                        maxlength="3000" rows="5" data-validate-field="Message">{{ old('Message') }}</textarea>
                                    @error('Message')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div id="fcf-status" class="fcf-status"></div>
                            <div class="fcf-field">
                                <div class="fcf-buttons">
                                    <button id="fcf-button" type="submit"
                                        class="fcf-button is-link is-medium is-fullwidth">Send
                                        Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
                icon: "success",
                title: "Your message has been sent!",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endsection
@endif
