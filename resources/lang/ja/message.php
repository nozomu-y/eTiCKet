<?php

return [
    'events' => [
        'delete' => [
            'confirm' => 'このイベントを削除しますか？関連する全てのデータが削除されます。',
            'success' => 'イベントを削除しました。',
            'error' => 'イベントの削除に失敗しました。',
        ],
    ],
    'tickets' => [
        'form' => [
            'csv' => "seat_number,door_number\nA1,L1\nA2,L1",
        ],
        'add' => [
            'success' => 'チケットを追加しました。',
        ],
        'issue' => [
            'success' => 'チケットを発券しました。',
        ],
        'already_used' => 'このチケットは使用済みです。'
    ],
    'front' => [
        'collect' => [
            'confirm' => '観客の入場処理を行いますか？',
            'confirmed' => '観客の入場処理が完了しました。',
        ],
        'error' => [
            'ticket_invalid' => 'チケットが無効です。',
            'already_checked_in' => '入場処理が既に完了しています。'
        ],
    ],
];
