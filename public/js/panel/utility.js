
var Utility = Utility || function () {
    this.defaults = this.defaults || {};
    var _utility = this;
    this.overlay = function (mensagem) {
        mensagem = mensagem || 'wait...';
        body = 'body';
        body = $(body);
        body.append('<h2 class="panel-overlay text-center text-white"><i class="fas fa-sun fa-spin fa-lg"></i>&nbsp;' + mensagem + '</h2>');
    };

    this.removeOverlay = function () {
        body = $('body');
        body.find('.panel-overlay').remove();
    };

    this.notificationSuccess = function ($mensagem) {
        toastr.success($mensagem, 'Success:');
    }

    this.notificationError = function ($mensagem) {
        toastr.error($mensagem, 'Error:');
    }


    this.start = function (config) {
        _utility.defaults = $.extend(true, this.defaults, config);

        jQuery.datetimepicker.setLocale('en');

        $('.close-modal').click(function () {
            $(_utility.defaults.modalShowElement).hide();
            $(_utility.defaults.modalElement).hide();
        });

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };
};