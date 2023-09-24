@props(['active' => false])

<i @class([
    'h4',
    'mdi',
    'mdi-check' => $active,
    'mdi-close' => !$active,
    'text-success' => $active,
    'text-danger' => !$active,
])></i>
