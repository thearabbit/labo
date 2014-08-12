<?php

return array(

    // Home
    'Home' => array(
        'icon' => 'home',
        'url' => URL::route('cpanel.home.index'),
//        'target' => '_blank',
//        'tree' => array(
//            'Title1' => array('url' => ''),
//            'Title2' => array('url' => ''),
//        )
    ),
    // Manage Data
    'Manage Data' => array(
        'icon' => 'suitcase',
        'tree' => array(
            'Customer' => array('url' => URL::route('labo.customer.index')),
            'Invoice' => array('url' => URL::route('labo.invoice.index')),
            'Payment' => array('url' => URL::route('labo.payment.index')),
            'Fee' => array('url' => URL::route('labo.fee.index')),
        ),
    ),
    // Report
    'Reports' => array(
        'icon' => 'file-text',
        'tree' => array(
            'Invoice' => array('url' => URL::route('labo.report-invoice.create')),
            'Invoice Payment' => array('url' => URL::route('labo.report-invoice_payment.create')),
            'Invoice Balance' => array('url' => URL::route('labo.report-invoice_balance.create')),
            'Fee Payment' => array('url' => URL::route('labo.report-fee_payment.create')),
            'Fee Balance' => array('url' => URL::route('labo.report-fee_balance.create')),
        ),
    ),
    // Setting
    'Settings' => array(
        'icon' => 'wrench',
        'tree' => array(
            'Exchange' => array('url' => URL::route('labo.exchange.index')),
            'Staff' => array('url' => URL::route('labo.staff.index')),
            'Agent' => array('url' => URL::route('labo.agent.index')),
            'Category' => array('url' => URL::route('labo.category.index')),
            'Product' => array('url' => URL::route('labo.product.index')),
        ),
    ),
    // Tool
    'Tools' => array(
        'icon' => 'cog',
        'tree' => array(
            'Company' => array('url' => URL::route('cpanel.company.edit', 1)),
            'User' => array('url' => URL::route('cpanel.user.index')),
            'Backup' => array('url' => URL::route('cpanel.backup.create')),
            'Restore' => array('url' => URL::route('cpanel.restore.create')),
        ),
    ),

);
