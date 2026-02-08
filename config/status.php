<?php

return [
    'common_status' => [
        1 => [
            'name' => 'Active',
            'value' => 'active',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Inactive',
            'value' => 'inactive',
            'class' => 'danger',
            'logo' => '',
        ],
    ],
    'balance_type' => [
        1 => [
            'name' => 'Transfer',
            'value' => 'transfer',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Administrator Transfer',
            'value' => 'administrator_transfer',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Withdrawal',
            'value' => 'withdrawal',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Deposit',
            'value' => 'deposit',
            'class' => 'success',
        ],
        5 => [
            'name' => 'Purchase',
            'value' => 'purchase',
            'class' => 'success',
        ],
        6 => [
            'name' => 'Transfer For Purchase',
            'value' => 'transfer_for_purchase',
            'class' => 'success',
        ],
    ],
    'balance_flow' => [
        1 => [
            'name' => 'IN',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'OUT',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'balance_status' => [
        1 => [
            'name' => 'Paid',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'meta_trade_balance_type' => [
        1 => [
            'name' => 'Pull',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Push',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Attached',
            'value' => 'inactive',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Detached',
            'value' => 'inactive',
            'class' => 'success',
        ],
        5 => [
            'name' => 'Return',
            'value' => 'inactive',
            'class' => 'success',
        ],
        6 => [
            'name' => 'Profit Share',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'income_flow' => [
        1 => [
            'name' => 'IN',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'OUT',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'income_status' => [
        1 => [
            'name' => 'Paid',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Cancel',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'income_type' => [
        2 => [
            'name' => 'ROI Bonus',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Incentive Bonus',
            'value' => 'inactive',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Level Bonus',
            'value' => 'inactive',
            'class' => 'success',
        ],
        50 => [
            'name' => 'Withdraw',
            'value' => 'inactive',
            'class' => 'success',
        ],
        51 => [
            'name' => 'Transfer',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'order_type' => [
        1 => [
            'name' => 'Home Delivery',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Office Delivery',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => config('mlm.dealer_name') . ' Delivery',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'order_status' => [
        1 => [
            'name' => 'Complete',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'order_payment_status' => [
        1 => [
            'name' => 'Paid',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Due',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'order_delivery_status' => [
        1 => [
            'name' => 'Delivered',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'order_item_flow' => [
        1 => [
            'name' => 'In',
            'value' => 'in',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Out',
            'value' => 'out',
            'class' => 'success',
        ],
    ],
    'dealer_type' => [
        1 => [
            'name' => 'Office',
            'value' => 'office',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Dealer',
            'value' => 'dealer',
            'class' => 'success',
        ],
    ],
    'withdrawal_type' => [
        1 => [
            'name' => 'To Balance Wallet',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'To Bank/Cash',
            'value' => 'inactive',
            'class' => 'success',
        ],
        // 3 => [
        //     'name' => 'To Transfer',
        //     'value' => 'inactive',
        //     'class' => 'success',
        // ],
    ],
    'withdrawal_status' => [
        1 => [
            'name' => 'Paid',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'deposit_type' => [
        2 => [
            'name' => 'Bank/Cash',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'deposit_status' => [
        1 => [
            'name' => 'Paid',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'warning',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'danger',
        ],
    ],
    'payment_method' => [
        1 => [
            'name' => 'Cash',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
        2 => [
            'name' => 'Bank',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
        3 => [
            'name' => 'Bkash',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
        4 => [
            'name' => 'Nagad',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
    ],
    'order_payment_method' => [
        1 => [
            'name' => 'Cash On Delivery',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
        2 => [
            'name' => 'Credit',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => null,
            'account_no' => null,
            'account_details' => '',
        ],
    ],
    'package_status' => [
        1 => [
            'name' => 'Active',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Inactive',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'package_type' => [
        1 => [
            'name' => 'Coupon',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Upgrade',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'statement_type' => [
        1 => [
            'name' => 'ROI Return',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'statement_status' => [
        1 => [
            'name' => 'Active',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'fund_status' => [
        1 => [
            'name' => 'Approved',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Canceled',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'achievement_status' => [
        1 => [
            'name' => 'Active',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'ticket_type' => [
        1 => [
            'name' => 'Balance',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Bonus',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Withdrawal',
            'value' => 'inactive',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Technical',
            'value' => 'inactive',
            'class' => 'success',
        ],
        5 => [
            'name' => 'Others',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'ticket_priority' => [
        1 => [
            'name' => 'Normal',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Medium',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'High',
            'value' => 'inactive',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Critical',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'ticket_status' => [
        1 => [
            'name' => 'Solved',
            'value' => 'inactive',
            'class' => 'success',
        ],
        2 => [
            'name' => 'Open',
            'value' => 'inactive',
            'class' => 'success',
        ],
        3 => [
            'name' => 'Waiting for Review',
            'value' => 'inactive',
            'class' => 'success',
        ],
        4 => [
            'name' => 'Waiting for Reply',
            'value' => 'inactive',
            'class' => 'success',
        ],
        5 => [
            'name' => 'Hold',
            'value' => 'inactive',
            'class' => 'success',
        ],
        6 => [
            'name' => 'Cancel',
            'value' => 'inactive',
            'class' => 'success',
        ],
    ],
    'point_type' => [
        1 => [
            'name' => 'Order',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Upgrade',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        3 => [
            'name' => 'Transfer For Upgrade',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        4 => [
            'name' => 'Renew',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        5 => [
            'name' => 'Re-Purchase',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        6 => [
            'name' => 'System',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        7 => [
            'name' => 'Order Delivery',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
        8 => [
            'name' => 'Stock Generate',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'point_status' => [
        1 => [
            'name' => 'Approve',
            'value' => 'active',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Pending',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'point_flow' => [
        1 => [
            'name' => 'In',
            'value' => 'in',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Out',
            'value' => 'out',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'slider_id' => [
        1 => [
            'name' => 'Home Slide',
            'value' => 'home_slide',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Home Banner',
            'value' => 'home_banner',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'product_type' => [
        1 => [
            'name' => 'Product',
            'value' => 'product',
            'class' => 'success',
            'logo' => '',
        ],
        2 => [
            'name' => 'Service',
            'value' => 'service',
            'class' => 'success',
            'logo' => '',
        ],
    ],
    'deposit_payment_method' => [
        // 1 => [
        //     'name' => 'Cash',
        //     'value' => 'inactive',
        //     'class' => 'success',
        //     'logo' => null,
        //     'account_no' => 'TErKhAPSpXbYgKnFCyocycxVsbXTa4FYZz',
        //     'account_details' => '',
        // ],
        2 => [
            'name' => 'USDT',
            'value' => 'inactive',
            'class' => 'success',
            'logo' => "usdt.png",
            'account_no' => 'TErKhAPSpXbYgKnFCyocycxVsbXTa4FYZz',
            'account_details' => '',
        ],
        //  3 => [
        //     'name' => 'Bkash',
        //     'value' => 'inactive',
        //     'class' => 'success',
        //     'logo' => null,
        //     'account_no' => 'TErKhAPSpXbYgKnFCyocycxVsbXTa4FYZz',
        //     'account_details' => '',
        // ],
        // 4 => [
        //     'name' => 'Nagad',
        //     'value' => 'inactive',
        //     'class' => 'success',
        //     'logo' => null,
        //     'account_no' => 'TErKhAPSpXbYgKnFCyocycxVsbXTa4FYZz',
        //     'account_details' => '',
        // ],
    ],
];
