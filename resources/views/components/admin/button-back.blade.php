<a data-coreui-toggle="tooltip" title="{{ __('Return Back') }}" {{ $attributes->merge(['class' => 'btn btn-warning btn-sm']) }} onclick="window.history.back();">
    <i class="fas fa-reply fa-fw"></i>
    {{ $slot }}
</a>
