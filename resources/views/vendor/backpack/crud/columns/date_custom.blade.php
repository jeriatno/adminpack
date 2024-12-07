{{-- localized date using nesbot carbon --}}
@php
    $value = data_get($entry, $column['name']);

    // Handle the class attribute which might be a Closure
    $classAttribute = $column['attributes']['class'] ?? '';
    if (is_callable($classAttribute)) {
        $classAttribute = $classAttribute($entry);
    }

    // Handle strike usage
    if (!empty($column['useStrike']) && $column['useStrike'] === true) {
        $statusField = method_exists($entry, 'getStatusField') ? $entry->{$entry->getStatusField()} : $entry->status;
        if ($statusField == -1 || $statusField === 'cancelled') {
            $classAttribute = trim($classAttribute . ' text-strike');
        }
    }

    $classAttribute = trim($classAttribute);
@endphp

<span data-order="{{ $value }}" class="{{ $classAttribute }}">
    @if (!empty($value))
	{{
		\Carbon\Carbon::parse($value)
		->locale(App::getLocale())
		->isoFormat($column['format'] ?? config('backpack.base.default_date_format'))
	}}
    @endif
</span>
<style>
    .text-strike {
        text-decoration: line-through;
    }
</style>
