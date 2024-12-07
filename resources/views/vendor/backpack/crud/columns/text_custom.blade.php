{{-- regular object attribute --}}
@php
	$value = data_get($entry, $column['name']);

    // Ensure the value is a string
    if (is_array($value)) {
        $value = json_encode($value);
    } elseif (!is_string($value)) {
        $value = (string)$value;
    }

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

<span class="{{ $classAttribute }}">
    {{ (array_key_exists('prefix', $column) ? $column['prefix'] : '').str_limit(strip_tags($value), array_key_exists('limit', $column) ? $column['limit'] : 50, "[...]").(array_key_exists('suffix', $column) ? $column['suffix'] : '') }}
</span>
<style>
    .text-strike {
        text-decoration: line-through;
    }
</style>
