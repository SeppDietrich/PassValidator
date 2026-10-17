<?php
// Tarife abonamente (MDL). Prețurile sunt într-un singur loc, ușor de modificat.
// 'preturi' => null înseamnă abonament gratuit.
return [
    'perioade' => [
        1 => '1 lună',
        3 => '3 luni',
        6 => '6 luni',
    ],
    'categorii' => [
        [
            'nume'      => 'General',
            'descriere' => 'Pentru toți călătorii.',
            'preturi'   => [1 => 273, 3 => 693, 6 => 1134],
        ],
        [
            'nume'      => 'Elev',
            'descriere' => 'Pentru elevi.',
            'preturi'   => [1 => 136, 3 => 346, 6 => 567],
        ],
        [
            'nume'      => 'Student / angajat în educație și sănătate',
            'descriere' => 'Pentru studenți, personal didactic și medical.',
            'preturi'   => [1 => 191, 3 => 485, 6 => 794],
        ],
        [
            'nume'      => 'Elevi clasele I–IV',
            'descriere' => 'Abonament gratuit pentru elevii din clasele primare.',
            'preturi'   => null,
        ],
    ],
];