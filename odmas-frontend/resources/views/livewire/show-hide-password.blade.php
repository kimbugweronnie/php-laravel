 <div class="row mb-3">
    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
    <div class="col-md-6">
        <div class="input-group">
            <input type="{{ $showPassword ? 'text' : 'password' }}" name="password" id="password" class="form-control" placeholder="Enter your password">
            <button type="button" wire:click="togglePassword" class="btn btn-outline-secondary" id="togglePasswordButton">
                {{ $showPassword ? 'Hide' : 'Show' }}
            </button>
        </div> 
    </div>
</div>
