<script>
    /**
     * Create a confirm modal
     * We want to send an HTTP DELETE request
     *
     * @usage  <a href="posts/2" data-method="delete"
     *            data-modal-text="Are you sure you want to delete"
     *         >
     */
    $(document).ready(function () {
        $(document).on("click", "a[data-method]", function (e) {
            var link = $(this);

            var httpMethod = link.data('method').toUpperCase();
            var allowedMethods = ['PUT', 'DELETE'];
            var extraMsg = link.data('modal-text');


            var msg = '<div class="input-group"><i class="icon-warning-sign modal-icon"></i>&nbsp;Are you sure you want to&nbsp;' + extraMsg;
            var txt = '<input autofocus="true" type="password" id="delete_action" name="delete_action" class="col-md-12 form-control" value="" /></div>';

            if ($.inArray(httpMethod, allowedMethods) === -1) {
                return;
            }

            bootbox.dialog({
                message: msg + txt,
                title: "Please Confirm",
                buttons: {
                    success: {
                        label: "OK",
                        className: "btn-primary",
                        callback: function () {
                            // Check decode
                            <?php
                                $data = \Rabbit\Cpanel\UserModel::whereIn('type', array('Super', 'Admin'))->get();
                                $validator = '';
                                $logicalOp = '';
                                foreach($data as $val){
                                    if(!is_null($val->password_action) and !empty($val->password_action)){
                                        $validator .= $logicalOp . '$("#delete_action").val() != "' . $val->password_action . '"';
                                        $logicalOp = ' && ';
                                    }
                                }
                            ?>

                            if (<?php echo $validator; ?>) {
                                return false;
                            }

                            var form =
                                $('<form>', {
                                    'method': 'POST',
                                    'action': link.attr('href')
                                });
                            var hiddenInput =
                                $('<input>', {
                                    'name': '_method',
                                    'type': 'hidden',
                                    'value': link.data('method')
                                });

                            form.append(hiddenInput).appendTo('body').submit();
                        }
                    },
                    danger: {
                        label: "Close",
                        className: "btn-default"
                    }

                }
            });
            return false;
        });
    })
    ;

</script>