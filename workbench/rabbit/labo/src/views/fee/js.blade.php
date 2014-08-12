<script>

    $("#agent_id").change(function () {
        agentChange($(this));
    });

    $("#invoice_id").change(function () {
        invoiceChange($(this));
    });

    $("#paid_amount").keyup(function () {
        updateBalance($(this));
    });

    /**
     * Agent onChange
     *
     * @param obj
     */
    function agentChange(obj) {
        var invoiceId = $("#invoice_id");
        $.ajax({
            type: "GET",
            url: "<?php echo URL::route('labo.agent_change.fee'); ?>",
            data: "agent_id=" + obj.val(),
            dataType: "json",
            beforeSend: function () {
            },
            complete: function () {
                // Attach Select2
                invoiceId.select2();
                clearAmount();
            },
            success: function (data) {
                invoiceId.html(data.option);
            }
        });
    }

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
            url: "<?php echo URL::route('labo.invoice_change.fee'); ?>",
            data: "invoice_id=" + obj.val(),
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

    /**
     * Clear amount after agent change
     */
    function clearAmount() {
        $("#overdue_amount").val('');
        $("#paid_amount").val('');
        $("#balance").val('');
    }

</script>
