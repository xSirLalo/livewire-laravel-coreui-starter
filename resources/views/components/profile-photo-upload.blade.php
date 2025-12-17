@props([
    'user' => null,
])

<div class="form-group" x-data="{ photoName: null, photoPreview: null }">
    <!-- Profile Photo File Input -->
    <input type="file" class="d-none" wire:model="photo" x-ref="photo"
           x-on:change="
                photoName = $refs.photo.files[0].name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    photoPreview = e.target.result;
                };
                reader.readAsDataURL($refs.photo.files[0]);
            "
           accept="image/*" />

    <label class="form-label fw-bold">{{ __('Photo') }}</label>

    <!-- Current Profile Photo -->
    <div class="mt-2" x-show="! photoPreview">
        <img class="rounded-circle border border-3 border-light shadow-sm" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" style="width: 80px; height: 80px; object-fit: cover;">
    </div>

    <!-- New Profile Photo Preview -->
    <div class="mt-2" x-show="photoPreview" style="display: none;">
        <span class="d-block text-muted small mb-2">{{ __('New Photo Preview') }}</span>
        <img class="rounded-circle border border-3 border-primary shadow-sm" alt="{{ __('Preview') }}" x-bind:src="photoPreview" style="width: 80px; height: 80px; object-fit: cover;">
    </div>

    <div class="mt-3">
        <!-- Select Photo Button -->
        <button type="button" class="btn btn-outline-primary btn-sm me-2" x-on:click.prevent="$refs.photo.click()">
            <i class="cil-image me-1"></i>
            {{ __('Select A New Photo') }}
        </button>

        <!-- Remove Photo Button -->
        @if ($user && $user->hasProfilePhoto())
            <button type="button" class="btn btn-outline-danger btn-sm" wire:click="deleteProfilePhoto" wire:confirm="{{ __('Are you sure you want to delete your profile photo?') }}">
                <i class="cil-trash me-1"></i>
                {{ __('Remove Photo') }}
            </button>
        @endif
    </div>

    <!-- File Upload Progress -->
    <div class="mt-2" wire:loading wire:target="photo">
        <div class="progress" style="height: 6px;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
        <small class="text-muted">{{ __('Uploading photo...') }}</small>
    </div>

    <!-- Error Message -->
    @error('photo')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    <!-- Info Text -->
    <small class="text-muted d-block mt-2">
        {{ __('Supported formats: JPG, PNG, GIF. Maximum size: 1MB.') }}
    </small>
</div>

<script>
    // Limpiar preview cuando se complete la acción (igual que Jetstream)
    document.addEventListener('livewire:init', () => {
        Livewire.on('saved', () => {
            // Limpiar preview después de guardar exitosamente
            setTimeout(() => {
                const components = document.querySelectorAll('[x-data*="photoPreview"]');
                components.forEach(component => {
                    if (component.__x) {
                        component.__x.$data.photoName = null;
                        component.__x.$data.photoPreview = null;
                        // Reset file input
                        const fileInput = component.querySelector('input[type="file"]');
                        if (fileInput) fileInput.value = '';
                    }
                });
            }, 1000);
        });
    });
</script>
