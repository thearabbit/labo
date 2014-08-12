<script>
    $("#child").change(function () {
        childChange();
    });
    $("#fee_type").change(function () {
        feeTypeChange();
    });

    childChange();
    feeTypeChange();

    function childChange() {
        var element = $("#child").val();
        if (element == "Yes") {
            $("#normal_value").removeAttr("disabled");
        } else {// No
            $("#normal_value").prop("disabled", "true");
        }
    }

    function feeTypeChange() {
        var element = $("#fee_type").val();
        if (element == "Percentage") {
//            $("#fee").val("");
            $("#fee").attr("data-inputmask", "decimal");
            $("#fee").removeAttr("disabled");
            InputmaskDecimal();
        } else if (element == "Amount") {
//            $("#fee").val("");
            $("#fee").attr("data-inputmask", "integer");
            $("#fee").removeAttr("disabled");
            InputmaskInteger();
        } else {
            $("#fee").prop("disabled", "true");
        }
    }
</script>
