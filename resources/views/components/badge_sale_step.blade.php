@switch($sale_step)
    @case('1')
    <span class="badge badge-success">{{ __('QP') }}</span>
    @break

    @case('2')
    <span class="badge badge-success">{{ __('Order') }}</span>
    @break

    @case('3')
    <span class="badge badge-success">{{ __('Contract') }}</span>
    @break

    @case('4')
    <span class="badge badge-success">{{ __('Delivery') }}</span>
    @break
@endswitch