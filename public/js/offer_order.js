$(document).ready(function() {
    $('#set_amount').change(function () {
        $('.amount').html($(this).val());
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
        label.after("<input type = 'text' style = 'display:none' />");

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
        });
    });
});