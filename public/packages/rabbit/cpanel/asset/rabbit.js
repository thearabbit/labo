/*
 |-----------------------------
 | Date Picker
 |-----------------------------
 */
$("[date-picker]").datepicker({
    format: "yyyy-mm-dd",
    autoclose: true,
    todayBtn: "linked",
    todayHighlight: true,
    clearBtn: true,
    startDate: "",
    endDate: ""
});

// Add calendar icon
$("[date-picker]").wrap('<div class="input-group">');
$("[date-picker]").after('<span class="input-group-addon"><i class="fa fa-calendar"></i></span>');

$("[date-picker]").inputmask("yyyy-mm-dd", { "placeholder": "YYYY-MM-DD" });

/*
 |-----------------------------
 | Date Range Picker
 |-----------------------------
 */
//Date range picker
$("[date-range-picker]").daterangepicker({
    format: 'YYYY-MM-DD',
    showDropdowns: true,
    separator: ' To ',
    singleDatePicker: false
});
// Add calendar icon
$("[date-range-picker]").wrap('<div class="input-group">');
$("[date-range-picker]").after('<span class="input-group-addon"><i class="fa fa-calendar"></i></span>');

$("[date-range-picker]").inputmask("9999-99-99 To 9999-99-99", { "placeholder": "YYYY-MM-DD To YYYY-MM-DD" });

/*
 |-----------------------------
 | Select2
 |-----------------------------
 */
$(".select2").select2();

/*
 |-----------------------------
 | Input Mask for decimal
 |-----------------------------
 */
InputmaskDecimal();
InputmaskInteger();
function InputmaskDecimal() {
    $("[data-inputmask=decimal]").inputmask(
        "decimal", { radixPoint: ".", digits: 2, autoGroup: true, groupSeparator: ",", groupSize: 3, allowMinus: false }
    );
}
function InputmaskInteger() {
    $("[data-inputmask=integer]").inputmask(
        "integer", { autoGroup: true, groupSeparator: ",", groupSize: 3, allowMinus: false }
    );
}

// Str Starts With
function strStartsWith(str, prefix) {
    return str.indexOf(prefix) === 0;
}
// Str Ends With
function strEndsWith(str, suffix) {
    return str.match(suffix + "$") == suffix;
}
// Round Number
function roundNumber(number, decimals) {
    var newString;// The new rounded number
    decimals = Number(decimals);
    if (decimals < 1) {
        newString = (Math.round(number)).toString();
    } else {
        var numString = number.toString();
        if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
            numString += ".";// give it one at the end
        }
        var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
        var d1 = Number(numString.substring(cutoff, cutoff + 1));// The value of the last decimal place that we'll end up with
        var d2 = Number(numString.substring(cutoff + 1, cutoff + 2));// The next decimal, after the last one we want
        if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
            if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
                while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                    if (d1 != ".") {
                        cutoff -= 1;
                        d1 = Number(numString.substring(cutoff, cutoff + 1));
                    } else {
                        cutoff -= 1;
                    }
                }
            }
            d1 += 1;
        }
        if (d1 == 10) {
            numString = numString.substring(0, numString.lastIndexOf("."));
            var roundedNum = Number(numString) + 1;
            newString = roundedNum.toString() + '.';
        } else {
            newString = numString.substring(0, cutoff) + d1.toString();
        }
    }
    if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
        newString += ".";
    }
    var decs = (newString.substring(newString.lastIndexOf(".") + 1)).length;
    for (var i = 0; i < decimals - decs; i++) newString += "0";
    //var newNumber = Number(newString);// make it a number if you like
    return newString; // Output the result to the form field (change for your purposes)
}
