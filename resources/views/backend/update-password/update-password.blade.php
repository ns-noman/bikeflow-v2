@extends('layouts.admin.master')
@section('content')
<div class="content-wrapper">
    @include('layouts.admin.content-header')
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Change Password</h3>
                        </div>
                        <form id="password-form" method="POST" action="{{ route('admin.password.update', Auth::guard('admin')->user()->id) }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="Enter current password">
                                    <small id="check-current-password" class="form-text"></small>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Enter new password">
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirm new password">
                                    <small id="check-confirm-password" class="form-text"></small>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button type="submit" id="submit-btn" class="btn btn-primary" disabled>Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        const form = $('#password-form');
        const submitBtn = $('#submit-btn');
        const currentInput = $('#current_password');
        const newInput = $('#new_password');
        const confirmInput = $('#confirm_password');
        const currentFeedback = $('#check-current-password');
        const confirmFeedback = $('#check-confirm-password');

        let isCurrentPasswordValid = false;

        // Validate current password via AJAX
        async function checkCurrentPassword() {
            const password = currentInput.val();
            if (!password) {
                currentFeedback.html('');
                isCurrentPasswordValid = false;
                toggleSubmit();
                return;
            }

            try {
                const res = await nsAjaxPost("{{ route('admin.password.check') }}", {
                    current_password: password
                });

                if (res.is_match == '1') {
                    isCurrentPasswordValid = true;
                    currentFeedback.html('<span class="text-success">✅ Correct Password</span>');
                } else {
                    isCurrentPasswordValid = false;
                    currentFeedback.html('<span class="text-danger">❌ Incorrect Password</span>');
                }
                toggleSubmit();
            } catch (e) {
                console.error('Password check error:', e);
                currentFeedback.html('<span class="text-danger">Server error</span>');
            }
        }

        // Validate new/confirm password match
        function checkPasswordMatch() {
            const newVal = newInput.val();
            const confirmVal = confirmInput.val();

            if (!confirmVal) {
                confirmFeedback.html('');
                return false;
            }

            if (newVal === confirmVal) {
                confirmFeedback.html('<span class="text-success">✅ Passwords match</span>');
                return true;
            } else {
                confirmFeedback.html('<span class="text-danger">❌ Passwords do not match</span>');
                return false;
            }
        }

        // Enable/disable submit button
        function toggleSubmit() {
            const match = checkPasswordMatch();
            submitBtn.prop('disabled', !(isCurrentPasswordValid && match));
        }

        // Event listeners
        currentInput.on('keyup', checkCurrentPassword);
        newInput.on('input', toggleSubmit);
        confirmInput.on('input', toggleSubmit);

        // Submit form via AJAX
        form.on('submit', async function (e) {
            e.preventDefault();

            const data = {
                current_password: currentInput.val(),
                new_password: newInput.val(),
                confirm_password: confirmInput.val()
            };

            if (data.new_password !== data.confirm_password) {
                return Swal.fire('Error', 'Passwords do not match', 'error');
            }

            try {
                const res = await nsAjaxPost(form.attr('action'), data);
                if (res.is_updated == '1') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated!',
                        text: 'Your password has been changed successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    form[0].reset();
                    currentFeedback.html('');
                    confirmFeedback.html('');
                    submitBtn.prop('disabled', true);
                    isCurrentPasswordValid = false;
                }
            } catch (err) {
                console.error('Password update error:', err);
                Swal.fire('Error', 'Something went wrong!', 'error');
            }
        });
    });
</script>
@endsection
