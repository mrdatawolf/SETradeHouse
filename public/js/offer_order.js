
$('#set_amount').change(function () {
    $('.amount').html($(this).val());
    exportTableToDIV(false);
});
$('#set_modifier').change(function () {
    //$('.')
   // get the current value
});


//Loop through all Labels with class 'editable'.
$(".editable").each(function () {
    //Reference the Label.
    var label = $(this);

    //Add a TextBox next to the Label.
    label.after("<input type='text' style='display:none'>");

    //Reference the TextBox.
    var textbox = $(this).next();

    //Set the name attribute of the TextBox.
    textbox[0].name = this.id.replace("lbl", "txt");

    //Assign the value of Label to TextBox.
    textbox.val(label.html());

    //When Label is clicked, hide Label and show TextBox.
    label.click(function () {
        $(this).hide();
        $(this).next().show().focus();
    });

    //When focus is lost from TextBox, hide TextBox and show Label.
    textbox.focusout(function () {
        $(this).hide();
        $(this).prev().html($(this).val());
        $(this).prev().show();
        exportTableTo();
    });
});

/**
 *
 * @param csv
 * @param filename
 */
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;
    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});
    // Download link
    downloadLink = document.createElement("a");
    // File name
    downloadLink.download = filename;
    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);
    // Hide download link
    downloadLink.style.display = "none";
    // Add the link to DOM
    document.body.appendChild(downloadLink);
    // Click download link
    downloadLink.click();
}

/**
 *
 * @param filename
 * @param exportAs
 * @param showHeader
 */
function exportTableTo(showHeader = false, filename = '', exportAs = 'text') {
    var data = [];
    var qSA = (showHeader) ? "td th" : "td";
    var rows = document.querySelectorAll("table tr");

    for (var i = 0; i < rows.length; i++) {
        var row = [];
        var cols = rows[i].querySelectorAll(qSA);

        for (var j = 1; j < cols.length; j++) {
            row.push(cols[j].innerText);
        }
        data.push(row.join(","));
    }
    data.shift();
    if(exportAs === 'csv') {
        // Download CSV file
        downloadCSV(data.join("\n"), filename);
    } else {
        $('#csv_text').text(data.join('\r\n'));
    }
}
