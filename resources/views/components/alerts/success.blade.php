@if(Session::has('success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    </script>
@elseif (Session::has('resent'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('A fresh verification link has been sent to your email address.') }}'
        });
    </script>
@elseif(Session::has('verified'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('You have successfully verified your email.') }}'
        });
    </script>
@elseif(Session::has('schedule_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Your scheduled site visit has been sent for approval.') }}'
        });
    </script>
@elseif(Session::has('schedule_update_success_approved'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('The client\'s schedule has been approved.') }}'
        });
    </script>
@elseif(Session::has('schedule_update_success_rejected'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('The client\'s schedule has been rejected.') }}'
        });
    </script>
@elseif(Session::has('store_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Data has been successfully saved') }}'
        });
    </script>
@elseif(Session::has('update_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Data has been successfully updated') }}'
        });
    </script>
@elseif(Session::has('delete_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Data has been successfully deleted!') }}'
        });
    </script>
@elseif(Session::has('update_password_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Your password has been successfully updated.') }}'
        });
    </script>
@elseif(Session::has('status'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ session('status') }}'
        });
    </script>
@elseif(Session::has('password_update_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('You have successfully changed your password, please login.') }}'
        });
    </script>
@elseif(Session::has('bill_upload_success'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('The bill has been uploaded for admin verification.') }}'
        });
    </script>
@elseif(Session::has('reset_password_sent'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Reset password for this employee has been sent.') }}'
        });
    </script>
@elseif(Session::has('invoice_created'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Invoice has been successfully saved.') }}'
        });
    </script>
@elseif(Session::has('invoice_updated'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Invoice has been successfully updated.') }}'
        });
    </script>
@elseif(Session::has('invoice_deleted'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Invoice has been successfully deleted.') }}'
        });
    </script>
@elseif(Session::has('invoice_successfully_created_routed'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ __('Invoice has been successfully routed for approval.') }}'
        });
    </script>
@elseif(Session::has('message'))
    <script type="text/javascript">
        Alert.fire({
            icon: 'success',
            title: '{{ session('message') }}'
        });
    </script>
@endif
