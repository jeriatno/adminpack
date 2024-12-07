{{-- single relationships (1-1, 1-n) --}}
@php
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
    <?php
        $attributes = $crud->getModelAttributeFromRelation($entry, $column['entity'], $column['attribute']);
        if (count($attributes)) {
            echo e(str_limit(strip_tags(implode(', ', $attributes)), array_key_exists('limit', $column) ? $column['limit'] : 50, "[...]"));
        } else {
            echo '-';
        }
    ?>
</span>
<style>
    .text-strike {
        text-decoration: line-through;
    }
</style>
