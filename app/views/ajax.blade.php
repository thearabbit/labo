<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel PHP Framework</title>
    <?php echo HTML::script('packages/rabbit/cpanel/lte/js/jquery-2.1.1.min.js'); ?>
</head>
<body>

<table id="items" width="800px">
    <thead>
    <tr>
        <th>Item</th>
        <th>Unit Price</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    </thead>
    <tr class="item-row">
        <td>
            <select class="item_name">
                <option value="ABC">ABC</option>
                <option value="Tiger">Tiger</option>
                <option value="Angkor">Angkor</option>
            </select>
        </td>
        <td><input type="text" class="cost" value=""></td>
        <td><input type="text" class="qty" value=""></td>
        <td><input type="text" class="price" value="" readonly="true"></td>
        <td><input type="button" class="delete" value="-"></td>
    </tr>
    <tr class="item-row">
        <td>
            <select class="item_name">
                <option value="ABC">ABC</option>
                <option value="Tiger">Tiger</option>
                <option value="Angkor">Angkor</option>
            </select>
        </td>
        <td><input type="text" class="cost" value=""></td>
        <td><input type="text" class="qty" value=""></td>
        <td><input type="text" class="price" value="" readonly="true"></td>
        <td><input type="button" class="delete" value="-"></td>
    </tr>

    <tr>
        <td colspan="4"><hr></td>
        <td><input type="button" id="add" value="+"></td>
    </tr>

    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">Total USD:</td>
        <td><input type="text" id="total_usd" value="" readonly="true"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">KHR:</td>
        <td><input type="text" id="total_khr" value="" readonly="true"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">Paid USD:</td>
        <td><input type="text" id="paid_usd" value=""></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">KHR:</td>
        <td><input type="text" id="paid_khr" value=""></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">Balance Due USD:</td>
        <td><input type="text" id="balance_usd" value="" readonly="true"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: right; font-weight: bold">KHR:</td>
        <td><input type="text" id="balance_khr" value="" readonly="true"></td>
        <td></td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td><input type="submit" id="save" value="Save"></td>
        <td></td>
    </tr>

</table>

<script>

    $(document).ready(function () {
        // Add
        $("#add").click(function () {
            $(".item-row:last").after(
                '<tr class="item-row">' +
                    '<td>' + '<select class="item_name">' +
                    '<option value="ABC">ABC</option>' +
                    '<option value="Tiger">Tiger</option>' +
                    '<option value="Angkor">Angkor</option>' +
                    '</select>' + '</td>' +
                    '<td><input type="text" class="cost" value=""></td>' +
                    '<td><input type="text" class="qty" value=""></td>' +
                    '<td><input type="text" class="price" value="" readonly="true"></td>' +
                    '<td><input type="button" class="delete" value="-"></td>' +
                    '</tr>'
            );
            if ($(".delete").length > 0) $(".delete").show();
            bind();
        });

        bind();

        $("#paid_usd").blur(function () {
//            alert($(this).val());
            if ($(this).val() > 0) {
                $("#paid_khr").attr("readonly", "true");
                $("#balance_usd").val($("#total_usd").val() - $(this).val());
                $("#balance_khr").val($("#balance_usd").val() * 4000);
            } else {
                $("#paid_khr").removeAttr("readonly");
                $("#balance_usd").val(0);
                $("#balance_khr").val(0);
            }
        });
        $("#paid_khr").blur(function () {
//            alert($(this).val());
            if ($(this).val() > 0) {
                $("#paid_usd").attr("readonly", "true");
                $("#balance_khr").val($("#total_khr").val() - $(this).val());
                $("#balance_usd").val($("#balance_khr").val() / 4000);
            } else {
                $("#paid_usd").removeAttr("readonly");
                $("#balance_usd").val(0);
                $("#balance_khr").val(0);
            }
        });
    });

    function bind() {
        $(".delete").click(delete_row);
        $(".cost").blur(update_price);
        $(".qty").blur(update_price);
    }

    function delete_row() {
        $(this).parents('.item-row').remove();
        if ($(".delete").length < 2) $(".delete").hide();
        update_total();
    }

    function update_price() {
        var row = $(this).parents('.item-row');
        var price = row.find('.cost').val() * row.find('.qty').val();
        isNaN(price) ? row.find('.price').val("N/A") : row.find('.price').val(price);
        update_total();
    }

    function update_total() {
        var total = 0;
        $('.price').each(function (i) {
            price = $(this).val();
            if (!isNaN(price)) total += Number(price);
        });

        $('#total_usd').val(total);
        $('#total_khr').val(total * 4000);
//        update_balance();
    }

</script>

</body>
</html>
