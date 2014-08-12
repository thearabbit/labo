<?php

/*
 |-------------------------------------------------
 | Cpanel package (cpanel)
 |-------------------------------------------------
 */

// Home
Breadcrumbs::register(
    'cpanel.home.index',
    function ($breadcrumbs) {
        $breadcrumbs->push('<i class="fa fa-home"></i> Home', route('cpanel.home.index'));
    }
);

// User
Breadcrumbs::register(
    'cpanel.user.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('User', route('cpanel.user.index'));
    }
);
Breadcrumbs::register(
    'cpanel.user.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.user.index');
        $breadcrumbs->push('Add New', route('cpanel.user.create'));
    }
);
Breadcrumbs::register(
    'cpanel.user.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.user.index');
        $breadcrumbs->push('Edit', route('cpanel.user.edit'));
    }
);
// User profile
Breadcrumbs::register(
    'cpanel.profile.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Profile', route('cpanel.profile.edit'));
    }
);
// Company
Breadcrumbs::register(
    'cpanel.company.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Company', route('cpanel.company.edit'));
    }
);

// Backup
Breadcrumbs::register(
    'cpanel.backup.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Backup', route('cpanel.backup.create'));
    }
);

// Restore
Breadcrumbs::register(
    'cpanel.restore.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Restore', route('cpanel.restore.create'));
    }
);

/*
 |-------------------------------------------------
 | Laboratory package (labo)
 |-------------------------------------------------
 */
// Exchange
Breadcrumbs::register(
    'labo.exchange.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Exchange', route('labo.exchange.index'));
    }
);
Breadcrumbs::register(
    'labo.exchange.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.exchange.index');
        $breadcrumbs->push('Add New', route('labo.exchange.create'));
    }
);
Breadcrumbs::register(
    'labo.exchange.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.exchange.index');
        $breadcrumbs->push('Exchange', route('labo.exchange.edit'));
    }
);

// Staff
Breadcrumbs::register(
    'labo.staff.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Staff', route('labo.staff.index'));
    }
);
Breadcrumbs::register(
    'labo.staff.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.staff.index');
        $breadcrumbs->push('Add New', route('labo.staff.create'));
    }
);
Breadcrumbs::register(
    'labo.staff.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.staff.index');
        $breadcrumbs->push('Staff', route('labo.staff.edit'));
    }
);

// Agent
Breadcrumbs::register(
    'labo.agent.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Agent', route('labo.agent.index'));
    }
);
Breadcrumbs::register(
    'labo.agent.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.agent.index');
        $breadcrumbs->push('Add New', route('labo.agent.create'));
    }
);
Breadcrumbs::register(
    'labo.agent.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.agent.index');
        $breadcrumbs->push('Agent', route('labo.agent.edit'));
    }
);

// Category
Breadcrumbs::register(
    'labo.category.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Category', route('labo.category.index'));
    }
);
Breadcrumbs::register(
    'labo.category.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.category.index');
        $breadcrumbs->push('Add New', route('labo.category.create'));
    }
);
Breadcrumbs::register(
    'labo.category.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.category.index');
        $breadcrumbs->push('Edit', route('labo.category.edit'));
    }
);

// Product
Breadcrumbs::register(
    'labo.product.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Product', route('labo.product.index'));
    }
);
Breadcrumbs::register(
    'labo.product.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.product.index');
        $breadcrumbs->push('Add New', route('labo.product.create'));
    }
);
Breadcrumbs::register(
    'labo.product.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.product.index');
        $breadcrumbs->push('Edit', route('labo.product.edit'));
    }
);

// Product Child
Breadcrumbs::register(
    'labo.product_child.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.product.index');
        $breadcrumbs->push('Child [Add New]', route('labo.product_child.index', Request::segment(4)));
    }
);
Breadcrumbs::register(
    'labo.product_child.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.product_child.index');
        $breadcrumbs->push('Edit', route('labo.product_child.edit'));
    }
);

// Customer
Breadcrumbs::register(
    'labo.customer.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Customer', route('labo.customer.index'));
    }
);
Breadcrumbs::register(
    'labo.customer.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.customer.index');
        $breadcrumbs->push('Add New', route('labo.customer.create'));
    }
);
Breadcrumbs::register(
    'labo.customer.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.customer.index');
        $breadcrumbs->push('Edit', route('labo.customer.edit'));
    }
);

// Invoice
Breadcrumbs::register(
    'labo.invoice.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Invoice', route('labo.invoice.index'));
    }
);
Breadcrumbs::register(
    'labo.invoice.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.invoice.index');
        $breadcrumbs->push('Add New', route('labo.invoice.create'));
    }
);
Breadcrumbs::register(
    'labo.invoice.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.invoice.index');
        $breadcrumbs->push('Edit', route('labo.invoice.edit'));
    }
);

// Payment
Breadcrumbs::register(
    'labo.payment.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Payment', route('labo.payment.index'));
    }
);
Breadcrumbs::register(
    'labo.payment.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.payment.index');
        $breadcrumbs->push('Add New', route('labo.payment.create'));
    }
);
Breadcrumbs::register(
    'labo.payment.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.payment.index');
        $breadcrumbs->push('Edit', route('labo.payment.edit'));
    }
);

// Fee
Breadcrumbs::register(
    'labo.fee.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Fee', route('labo.fee.index'));
    }
);
Breadcrumbs::register(
    'labo.fee.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.fee.index');
        $breadcrumbs->push('Add New', route('labo.fee.create'));
    }
);
Breadcrumbs::register(
    'labo.fee.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.fee.index');
        $breadcrumbs->push('Edit', route('labo.fee.edit'));
    }
);

// Result
Breadcrumbs::register(
    'labo.result.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.invoice.index');
        $breadcrumbs->push('Result [Add New]', route('labo.result.create'));
    }
);
Breadcrumbs::register(
    'labo.result.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('labo.invoice.index');
        $breadcrumbs->push('Result [Edit]', route('labo.result.edit'));
    }
);

/*********************
 * Labo Reports
 ********************/
// Invoice
Breadcrumbs::register(
    'labo.report-invoice.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Invoice Report', route('labo.report-invoice.create'));
    }
);

// Invoice Payment
Breadcrumbs::register(
    'labo.report-invoice_payment.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Invoice Payment Report', route('labo.report-invoice_payment.create'));
    }
);

// Balance
Breadcrumbs::register(
    'labo.report-invoice_balance.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Invoice Balance Report', route('labo.report-invoice_balance.create'));
    }
);

// Fee Payment
Breadcrumbs::register(
    'labo.report-fee_payment.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Fee Payment Report', route('labo.report-fee_payment.create'));
    }
);

// Fee Balance
Breadcrumbs::register(
    'labo.report-fee_balance.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Fee Balance Report', route('labo.report-fee_balance.create'));
    }
);

/*
 |-------------------------------------------------
 | Simple package (simple)
 |-------------------------------------------------
 */
// Test
Breadcrumbs::register(
    'simple.test.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Test', route('simple.test.index'));
    }
);
Breadcrumbs::register(
    'simple.test.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('simple.test.index');
        $breadcrumbs->push('Add New', route('simple.test.create'));
    }
);
Breadcrumbs::register(
    'simple.test.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('simple.test.index');
        $breadcrumbs->push('Edit', route('simple.test.edit'));
    }
);
// Form
Breadcrumbs::register(
    'simple.form',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Form', route('simple.form'));
    }
);
// Post Comment
Breadcrumbs::register(
    'generator.post_comment.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Post Comment', route('generator.post_comment.index'));
    }
);
Breadcrumbs::register(
    'generator.post_comment.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('generator.post_comment.index');
        $breadcrumbs->push('Add New', route('generator.post_comment.create'));
    }
);
Breadcrumbs::register(
    'generator.post_comment.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('generator.post_comment.index');
        $breadcrumbs->push('Edit', route('generator.post_comment.edit'));
    }
);
// Post Comment
Breadcrumbs::register(
    'generator.post_comment.index',
    function ($breadcrumbs) {
        $breadcrumbs->parent('cpanel.home.index');
        $breadcrumbs->push('Post Comment', route('generator.post_comment.index'));
    }
);
Breadcrumbs::register(
    'generator.post_comment.create',
    function ($breadcrumbs) {
        $breadcrumbs->parent('generator.post_comment.index');
        $breadcrumbs->push('Add New', route('generator.post_comment.create'));
    }
);
Breadcrumbs::register(
    'generator.post_comment.edit',
    function ($breadcrumbs) {
        $breadcrumbs->parent('generator.post_comment.index');
        $breadcrumbs->push('Edit', route('generator.post_comment.edit'));
    }
);
