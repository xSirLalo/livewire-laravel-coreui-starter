@push('js')
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });

        function toast_show(icon, message) {
            Toast.fire({
                icon: icon,
                title: message
            });
        }

        function success_message(message) {
            toast_show('success', message);
        }

        function info_message(message) {
            toast_show('info', message);
        }

        function error_message(message) {
            toast_show('error', message);
        }

        function warning_message(message) {
            toast_show('warning', message);
        }

        document.addEventListener('livewire:init', function() {
            Livewire.on('alert', function(event) {
                switch (event.icon) {
                    case 'success':
                        success_message(event.message);
                        break;
                    case 'info':
                        info_message(event.message);
                        break;
                    case 'warning':
                        warning_message(event.message);
                        break;
                    case 'error':
                        error_message(event.message);
                        break;
                }
            });
        });
    </script>
    @if ($message = \Illuminate\Support\Facades\Session::get('success_message'))
        @if (is_iterable($message))
            @foreach ($message as $m)
                <script>
                    success_message('{{ addslashes($m) }}');
                </script>
            @endforeach
        @else
            <script>
                success_message('{{ addslashes($message) }}');
            </script>
        @endif
    @endif
    @if ($message = \Illuminate\Support\Facades\Session::get('info_message'))
        @if (is_iterable($message))
            @foreach ($message as $m)
                <script>
                    info_message('{{ addslashes($m) }}');
                </script>
            @endforeach
        @else
            <script>
                info_message('{{ addslashes($message) }}');
            </script>
        @endif
    @endif
    @if ($message = \Illuminate\Support\Facades\Session::get('warning_message'))
        @if (is_iterable($message))
            @foreach ($message as $m)
                <script>
                    warning_message('{{ addslashes($m) }}');
                </script>
            @endforeach
        @else
            <script>
                warning_message('{{ addslashes($message) }}');
            </script>
        @endif
    @endif
    @if ($message = \Illuminate\Support\Facades\Session::get('error_message'))
        @if (is_iterable($message))
            @foreach ($message as $m)
                <script>
                    error_message('{{ addslashes($m) }}');
                </script>
            @endforeach
        @else
            <script>
                error_message('{{ addslashes($message) }}');
            </script>
        @endif
    @endif
@endpush
