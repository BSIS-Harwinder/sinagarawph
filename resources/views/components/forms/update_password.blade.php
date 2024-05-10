<form action="{{ route('engineers.update_password', Auth::id()) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="form-group">
                <label for="old_password">Current Password</label>
                <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Current Password" value="{{ old('old_password') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" value="{{ old('password') }}">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="{{ old('confirm_password') }}">
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <button type="submit" class="btn btn-primary">Update Password</button>
        </div>
    </div>
</form>
