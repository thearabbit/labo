<script>

$(document).ready(function () {

    // Add
    var counter = <?php echo $counter; ?>;
    $("#add").click(function () {
        $(".item_row:last").after(
            '<tr class="item_row">' +
                '<td>' + '<?php echo $item; ?>' + '</td>' +
                '<td>' + '<?php echo $qty; ?>' + '</td>' +
                '<td>' + '<?php echo $cost; ?>' + '</td>' +
                '<td>' + '<?php echo $price; ?>' + '</td>' +
                '<td class="pull-right">' + '<?php echo $remove; ?>' + '</td>' +
                '</tr>'
        );

        counter++;

        if ($(".delete").length > 0) $(".delete").show();

        bind();

    });

    bind();


    // Submit
    $("#submit").click(function () {
        // Load Block UI page
        $.blockUI();

        $.ajax({
            type: "POST",
            url: "<?php echo $url; ?>",
            data: $("#my_form").serialize(),
            dataType: "json",
            beforeSend: function () {
                $("div.has-error").attr("class", "form-group");
                $("span.help-block").remove();
            },
            complete: function () {

            },
            success: function (data) {
                if (data.success == false) {
                    $("#alert").attr("class", "alert alert-danger alert-dismissable");
                    $("#alert span").html(data.alert);
                    var errors = data.errors;
                    $.each(errors, function (index, value) {
//                            alert(index);
                        if (value.length != 0) {
                            var selector = $("#" + index);
                            if (strStartsWith(index, "item") || strStartsWith(index, "cost") || strStartsWith(index, "qty")) {
                                var splitIndex = index.split(".");
                                selector = $("#" + splitIndex[0] + "_" + splitIndex[1]);
                            }
                            selector.parents("div.form-group").append("<span class=\"help-block\">" + value + "</span>");
                            selector.parents("div.form-group").attr("class", "form-group has-error");
                        }
                    });

                    $("#alert").show();

                } else {
                    // Clean item row
                    <?php
                        if($formAction == 'create'){
                            echo '$("#alert").attr("class", "alert alert-success alert-dismissable");
                                    $("#alert span").html(data.alert);';
                            echo 'item_clean();';
                            echo '$("#alert").show();';
                        }else{// $formAction == 'edit'
                            echo 'location.href = "' . $redirect . '";';
                        }
                    ?>


//                        $("#my_form")[0].reset();
//                        window.location.reload(true);
                }
            }
        });
        return false;
    });

    // Exchange Rate
    $("#exchange").change(function () {
        $.ajax({
            type: "GET",
            url: "<?php echo URL::route('labo.exchange_change.invoice'); ?>",
            data: "exchange=" + $(this).val(),
            dataType: "json",
            beforeSend: function () {
            },
            complete: function () {
                update_total();
            },
            success: function (data) {
                $("#ex_usd").val(data.usd);
                $("#ex_khr").val(data.khr);
                $("#ex_thb").val(data.thb);
            }
        });
    });

});
// End document.ready

function bind() {
    $(".delete").click(delete_row);
    $(".cost").keyup(function () {
        update_price($(this));
    });
    $(".qty").keyup(function () {
        update_price($(this));
    });
    $(".item_name").change(function () {
        item_change($(this
        ));
    });
    $("#add").click(function () {
        attach_select2();
    });

    $("[data-inputmask=decimal]").inputmask(
        "decimal", {radixPoint: ".", digits: 2, autoGroup: true, groupSeparator: ",", groupSize: 3, allowMinus: false }
    );
    $("[data-inputmask=integer]").inputmask(
        "integer", { autoGroup: true, groupSeparator: ",", groupSize: 3, allowMinus: false }
    );
}

// Item change
function item_change(obj) {
    var row = obj.parents(".item_row");
    var cost = row.find(".cost");
    $.ajax({
        type: "GET",
        url: "<?php echo URL::route('labo.item_change.invoice'); ?>",
        data: "item=" + obj.val(),
        dataType: "json",
        beforeSend: function () {
            cost.prop("disabled", "true");
        },
        complete: function () {
            update_price(obj);
        },
        success: function (data) {
            cost.val(roundNumber(data.cost, 0));
            cost.removeAttr("disabled");
        }
    });
}

// Item clean after create
function item_clean() {
    $(".item_row").not(".item_row:first").remove();
    if ($(".delete").length < 2) $(".delete").hide();
//    $(".item_name").val('');
//    $(".qty").val(1);
//    $(".cost").val(0);
//    $(".price").val(0);
    update_total();
}

// Delete item row
function delete_row() {
    $(this).parents('.item_row').remove();
    if ($(".delete").length < 2) $(".delete").hide();
    update_total();
}

// Attach select2 on add more
function attach_select2() {
    var row = $(".item_row:last");
    var item = row.find(".item_name");
    item.select2();
}

// Update total price
function update_price(obj) {
    var row = obj.parents('.item_row');
    var price = row.find('.cost').val().replace(",", "") * row.find('.qty').val().replace(",", "");
    isNaN(price) ? row.find('.price').val("N/A") : row.find('.price').val(roundNumber(price, 0));
    update_total();
}

// Update grand total
function update_total() {
    var total = 0;
    var totalFee = 0;
    $('.price').each(function (i) {
        price = $(this).val().replace(",", "");
        if (!isNaN(price)) total += Number(price);
    });
    $('.fee').each(function (i) {
        fee = $(this).val().replace(",", "");
        if (!isNaN(fee)) totalFee += Number(fee);
    });
    $('#total_khr').val(roundNumber(total, 0));
    $('#total_usd').val(roundNumber(total / $("#ex_khr").val(), 2));
}

</script>