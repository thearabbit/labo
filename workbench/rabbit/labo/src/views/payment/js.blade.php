<script>

    $("#invoice_id").change(function () {
        invoiceChange($(this));
    });

    $("#paid_amount").keyup(function () {
        updateBalance($(this));
    });

    /**
     * Update overdue, paid and balance when invoice is changed
     *
     * @param obj
     */
    function invoiceChange(obj) {
        var overdueAmount = $("#overdue_amount");
        var paidAmount = $("#paid_amount");
        var balance = $("#balance");
        $.ajax({
            type: "GET",
            url: "<?php echo URL::route('labo.invoice_change.payment'); ?>",
            data: "invoice=" + obj.val(),
            dataType: "json",
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (data) {
                overdueAmount.val(roundNumber(data.overdue, 0));
                paidAmount.val(roundNumber(data.overdue, 0));
                balance.val(0);
            }
        });
    }

    /**
     * Update balance when paid amount is keyup
     *
     * @param obj
     */
    function updateBalance(obj) {
        var balance = $("#overdue_amount").val().replace(",", "") - obj.val().replace(",", "");
        $("#balance").val(balance);
    }

</script>
