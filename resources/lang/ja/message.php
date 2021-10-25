<?php

return [
    'accounts' => [
        'add' => [
            'success' => 'アカウントを追加しました。',
        ],
    ],
    'events' => [
        'delete' => [
            'confirm' => 'このイベントを削除しますか？関連する全てのデータが削除されます。',
            'success' => 'イベントを削除しました。',
            'error' => 'イベントの削除に失敗しました。',
        ],
        'add' => [
            'success' => 'イベントを追加しました。',
            'collect_personal_information' => '観客の個人情報を収集する場合は以下で指定してください。',
        ],
        'edit' => [
            'success' => 'イベントを編集しました。',
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
            'confirm' => '以下の内容でチケットを発券します。',
            'memo_placeholder' => '配布相手・配布担当者のメモなど',
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
            'already_checked_in' => '入場処理が既に完了しています。',
        ],
    ],
    'personal_informations' => [
        'unentered' => 'QRコードを表示するには連絡先を登録してください。',
        'success' => '連絡先を登録しました。',
    ],
];
