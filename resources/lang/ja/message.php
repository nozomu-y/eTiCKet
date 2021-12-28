<?php

return [
    'home' => [
        'latest_event' => [
            'not_found' => '最新のイベントはありません。'
        ],
    ],
    'account' => [
        'change_password' => [
            'current_password_incorrect' => '現在のパスワードが異なります。',
            'success' => 'パスワードを変更しました。',
        ],
    ],
    'accounts' => [
        'add' => [
            'success' => 'アカウントを追加しました。',
        ],
        'delete' => [
            'confirm' => 'このアカウントを削除しますか？',
            'success' => 'アカウントを削除しました。',
            'error' => 'アカウントの削除に失敗しました。',
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
            'memo' => '注意事項などをMarkdown形式で記入してください。',
        ],
        'edit' => [
            'success' => 'イベントを編集しました。',
        ],
    ],
    'tickets' => [
        'form' => [
            'seat_list_help' => '座席番号を1行につき1席分入力してください。',
        ],
        'add' => [
            'success' => 'チケットを追加しました。',
        ],
        'issue' => [
            'success' => 'チケットを発券しました。',
            'success_before' => 'チケットを',
            'success_after' => '枚発券しました。',
            'confirm' => '以下の内容でチケットを発券します。',
            'memo_placeholder' => '配布相手・配布担当者のメモなど',
            'error' => 'エラーが発生しました。再度実行してください。',
            'select_at_least_one_ticket' => 'チケットを最低1枚選択してください。',
        ],
        'already_used' => 'このチケットは使用済みです。',
        'delete' => [
            'disabled' => '発券済みのチケットは削除できません。',
            'confirm' => 'このチケットを削除しますか？',
            'success' => 'チケットを削除しました。',
            'error' => 'チケットの削除に失敗しました。',
        ],
        'edit' => [
            'success' => 'チケットを編集しました。',
        ],
    ],
    'front' => [
        'collect' => [
            'confirm' => '観客の入場処理を行いますか？',
            'confirmed' => '観客の入場処理が完了しました。',
        ],
        'error' => [
            'ticket_invalid' => 'チケットが無効です。',
            'already_checked_in' => '入場処理が既に完了しています。',
            'personal_info_unentered' => '連絡先の入力が完了していません。',
        ],
        'qrcode' => [
            'form' => [
                'token' => 'チケット下部に示されているランダムな文字列のうち、最初の6文字を入力してください。',
            ],
        ],
    ],
    'personal_informations' => [
        'unentered' => 'QRコードを表示するには連絡先を登録してください。',
        'success' => '連絡先を登録しました。',
    ],
];
