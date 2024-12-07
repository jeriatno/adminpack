"use strict";


function formatNumber(n) {
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function formatCurrency(input, blur) {
    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") {
        return;
    }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

        // get position of first decimal
        // this prevents multiple decimals from
        // being entered
        var decimal_pos = input_val.indexOf(".");

        // split number by decimal point
        var left_side = input_val.substring(0, decimal_pos);
        var right_side = input_val.substring(decimal_pos);

        // add commas to left side of number
        left_side = formatNumber(left_side);

        // validate right side
        right_side = formatNumber(right_side);

        // On blur make sure 2 numbers after decimal
        if (blur === "blur") {
            right_side += "00";
        }

        // Limit decimal to only 2 digits
        right_side = right_side.substring(0, 2);

        // join number by .
        input_val = left_side + "." + right_side;

    } else {
        // no decimal entered
        // add commas to number
        // remove all non-digits
        input_val = formatNumber(input_val);
        input_val = input_val;

        // final formatting
        if (blur === "blur") {
            input_val += ".00";
        }
    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
}

function formatRupiah(angka) {
    var number_string = angka.toFixed(2).toString().replace(/[^0-9,-]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/g);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

function parseFormat(val, def) {
    def = def !== undefined ? def : 0;
    return parseFloat(val.replace(/\$|,/g, '')) || def;
}

function numberFormat(number, decimal, point, separator) {
    decimal = decimal !== undefined ? decimal : 2;
    point = point !== undefined ? point : '.';
    separator = separator !== undefined ? separator : ',';

    number = number.toFixed(decimal);
    var nstr = number.toString();
    nstr += '';
    var x = nstr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? point + x[1] : '';
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(x1))
        x1 = x1.replace(rgx, '$1' + separator + '$2');

    return x1 + x2;
}

function currencyFormat(n) {
    n = typeof n === 'string' ? n : n.toString();
    return n.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}

function currencyFormatted(n, useDecimal= false) {
    var num = parseFloat(n);

    if (useDecimal) {
        num = num.toFixed(2);
    } else {
        num = Math.round(num);
    }

    // Convert number to string with commas as thousand separators
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}





