<script>
    typeChange();

    $("#type").change(function () {
        typeChange();
    });

    function typeChange() {
        var element = $("#type").val();
        if (element == "Admin") {
            $("#password_action").removeAttr("disabled");
        } else {// Guest
            $("#password_action").prop("disabled", "true");
        }
    }
</script>