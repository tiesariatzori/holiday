(function ($, window, document) {
    'use strict';
    var Register = function () {
        Utility.call(this);
        var _register = this;

        this.defaults = {
            data: {},
            ajax: false,
            formElement: '#register-form',
            modalElement: '#register-modal',
            modalShowElement: '#register-show',
            url: {
                base: '',
            },
        };

        this.formulario = {};

        this.formulario.validations = function () {
            var $form = $(_register.defaults.formElement);

            $form.validate({
                ignore: '.ignore',
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true, email: true
                    },
                },
                messages: {
                    title: { required: 'Required field!' },
                    location: { required: 'Required field!' },
                    description: { required: 'Required field!' },
                    date_final: { required: 'Required field!' },
                    date_initial: { required: 'Required field!' }
                }
            });
        };

        this.validations = function () {
            var $form = $(_register.defaults.formElement);

            _register.formulario.validations();

            $form.submit(function (e) {
                var ok = $form.valid();

                if (!ok) {
                    e.preventDefault();
                    e.stopPropagation();
                    _register.notificationError('empty fields!');
                    return false;
                }

                if (_register.defaults.ajax || $form.data('ajax')) {
                    var data = new FormData($form[0]);
                    data.append('ajax', true);

                    if (!$form.data('ajax')) {
                        $form.data('ajax', true);
                        _register.overlay('await...');

                        $.ajax({
                            url: _register.defaults.url.base + '/user/store',
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            data: data,
                            success: function (data) {
                                if (data.error) {
                                    _register.notificationError(
                                        data['message'] || "Unable to save"
                                    );
                                } else {
                                    _register.notificationSuccess(
                                        data['message'] || "Save!"
                                    );
                                    $(_register.defaults.modalElement).hide();
                                }

                                _register.removeOverlay();
                                $form.data('ajax', false);
                            }
                        });
                    } else {
                        $form.data('ajax', false);
                    }

                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }

                return true;
            });
        };

        this.showModal = function (data) {
            data = data || {};
            var $form = $('#register-form');
            var $modal = $('#register-modal');

            data['id'] = (data['id'] || '');

            data['name'] = (data['name'] || '');
            data['email'] = (data['email'] || '');

            $form[0].reset();

            $form.deserialize(data);

            $modal.show();

            _register.removeOverlay();
        };


        this.run = function (config) {
            _register.start(config);
            $('#create-accont').click(function (e) {
                if (_register.defaults.ajax) {
                    _register.overlay('Wait,loading!');
                    _register.showModal();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });
        };
    };

    $.register = function (params) {
        params = params || [];

        var obj = $(window).data("holiday.register");

        if (!obj) {
            obj = new Register();
            obj.run(params);
            $(window).data('holiday.register', obj);
        }

        return obj;
    };

})(window.jQuery, window, document);