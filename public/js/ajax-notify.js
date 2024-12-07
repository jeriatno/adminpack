function notifySuccess(result) {
    if (result.success) {
        new PNotify({
            title: 'Success',
            text: result.message,
            type: "success"
        });

        $('.modal').modal('hide');

        // if (table && $.fn.dataTable.isDataTable(table)) {
        //     $(table).DataTable().ajax.reload(null, false);
        // } else {
            location.reload();
        // }
    } else {
        new PNotify({
            title: 'Failed',
            text: result.message,
            type: "warning"
        });
    }
}

function notifyError(result) {
    let message = typeof result === 'string' && result.trim() !== ''
        ? result
        : "Something went wrong. Please try again.";

    new PNotify({
        title: "Error",
        text: message,
        type: "danger"
    });
}
