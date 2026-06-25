@props(['errors'])

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
            <i class="fas fa-triangle-exclamation fa-fw fa-xl flex-shrink-0 me-2"></i>
            <div>
                {{ $error }}
            </div>
            <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
        </div>
    @endforeach

    @script
        <script>
            // Auto dismiss alerts after 5 seconds
            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(alert => {
                    const alertInstance = coreui.Alert.getOrCreateInstance(alert);
                    alertInstance.close();
                });
            }, 6000);
        </script>
    @endscript
@endif
