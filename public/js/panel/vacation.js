(function ($, window, document) {
    'use strict';
    var Vacation = function () {
        Utility.call(this);
        var _vacation = this;

        this.defaults = {
            data: {},
            ajax: false,
            formElement: '#vacation-form',
            modalElement: '#vacation-modal',
            modalShowElement: '#vacation-show',
            url: {
                base: '',
            },
            table: {
                vacation: null
            }
        };

        this.index = function () {
            var $container = $('#index-vacation');
            var $table = $('#tablePlan');

            $table.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: _vacation.defaults.url.base + '/table',
                    type: "POST",
                    data: function (s) {
                        s.search = $container.find('input[type="search"]').val();
                    },
                    dataSrc: function (json) {
                        var data = json.data;

                        var btns = '<div class="text-center"><div class="btn-group">' +
                            '<button type="button" class="btn-primary vacation-show">Show</button>' +
                            '<button type="button" class="btn-secondary vacation-edit">Edit</button>' +
                            '<button type="button" class="btn-danger vacation-remove">Remove</button>' +
                            '</div></div>';

                        for (var row in data) {
                            data[row]['acao'] = btns;
                        }

                        return data;
                    }
                },
                columns: [
                    { name: "title", data: "title" },
                    { name: "description", data: "description" },
                    { name: "location", data: "location" },
                    { name: "participant", data: "participant" },
                    { name: "date_initial_format", data: "date_initial_format" },
                    { name: "date_final_format", data: "date_final_format" },
                    { data: 'acao', name: 'acao', orderable: false, searchable: false }
                ],
                order: [[1, 'desc']]
            });

            _vacation.defaults.table.vacation = $table.DataTable();

            $table.on('click', '.vacation-edit', function (event) {
                var data = _vacation.defaults.table.vacation.row($(this).parents('tr')).data();

                if (!_vacation.defaults.ajax) {
                    location.href = _vacation.defaults.url.base + '/' + data['id'] + '/edit';
                } else {
                    _vacation.serachVacation(data['id'], _vacation.showModal);
                }
            });

            $table.on('click', '.vacation-show', function (event) {
                var data = _vacation.defaults.table.vacation.row($(this).parents('tr')).data();

                if (!_vacation.defaults.ajax) {
                    location.href = _vacation.defaults.url.base + '/' + data['id'];
                } else {
                    _vacation.overlay('Wait,Loading show!');
                    _vacation.displayVacation(data['id']);
                }
            });

            $('#vacation-add').click(function (e) {
                if (_vacation.defaults.ajax) {
                    _vacation.overlay('Wait,loading Create!');
                    _vacation.showModal();
                    e.preventDefault();
                    e.stopPropagation();
                }
            });

            $table.on('click', '.vacation-remove', function (e) {
                var data = _vacation.defaults.table.vacation.row($(this).parents('tr')).data();

                alertify
                    .confirm('Do you really want to remove this plan?')
                    .set({
                        labels: { ok: "Yes", cancel: "No" },
                        title: "Confirm the operation:",
                        onok: function () {
                            _vacation.overlay('Await, removing...');
                            $.ajax({
                                url: _vacation.defaults.url.base + '/' + data['id'],
                                type: 'POST',
                                data: { _method: 'DELETE' },
                                dataType: 'json',
                                success: function (data) {
                                    if (data.error) {
                                        _vacation.notificationError(
                                            "<i>" + data['message'] + "</i>"
                                        );
                                        _vacation.removeOverlay();
                                    } else {
                                        _vacation.reloadtableVacation();
                                        _vacation.notificationSuccess(
                                            "removed successfully!"
                                        );
                                    }
                                    _vacation.removeOverlay();
                                }
                            });
                        }
                    });

                e.preventDefault();
            });

        };

        this.formulario = {};


        this.formulario.fields = function () {
            var $form = $(_vacation.defaults.formElement);

            $form.find("[name=date_initial]").datetimepicker({ format: 'm/d/Y H:i' });
            $form.find("[name=date_final]").datetimepicker({ format: 'm/d/Y H:i' });
            $form.find("[name=date_initial]").inputmask({ showMaskOnHover: false, clearIncomplete: false, mask: ['99/99/9999 99:99'] });
            $form.find("[name=date_final]").inputmask({ showMaskOnHover: false, clearIncomplete: false, mask: ['99/99/9999 99:99'] });

        };

        this.formulario.validations = function () {
            var $form = $(_vacation.defaults.formElement);

            $form.validate({
                ignore: '.ignore',
                rules: {
                    title: {
                        required: true
                    },
                    date_initial: {
                        required: true
                    },
                    date_final: {
                        required: true
                    },
                    location: {
                        required: true
                    },
                    participant: {
                        required: false
                    },
                    description: {
                        required: true
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
            var $form = $(_vacation.defaults.formElement);

            _vacation.formulario.fields();
            _vacation.formulario.validations();

            $form.submit(function (e) {
                var ok = $form.valid();

                if (!ok) {
                    e.preventDefault();
                    e.stopPropagation();
                    _vacation.notificationError('empty fields!');
                    return false;
                }

                if (_vacation.defaults.ajax || $form.data('ajax')) {
                    var data = new FormData($form[0]);
                    data.append('ajax', true);

                    if (!$form.data('ajax')) {
                        $form.data('ajax', true);
                        _vacation.overlay('await...');

                        $.ajax({
                            url: _vacation.defaults.url.base + (data.get('id') ? '/' + data.get('id') : ''),
                            type: 'POST',
                            contentType: false,
                            processData: false,
                            data: data,
                            success: function (data) {
                                if (data.error) {
                                    _vacation.notificationError(
                                        data['message'] || "Unable to save"
                                    );
                                } else {
                                    _vacation.reloadtableVacation();
                                    _vacation.notificationSuccess(
                                        data['message'] || "Save!"
                                    );
                                    $(_vacation.defaults.modalElement).hide();
                                }

                                _vacation.removeOverlay();
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

        this.serachVacation = function (id, callback) {
            var $form = $(_vacation.defaults.formElement);
            $form.attr('action');

            _vacation.overlay('wait, looking for plan...');

            $.ajax({
                url: _vacation.defaults.url.base + "/" + id + "/edit",
                dataType: 'json',
                type: 'GET',
                success: function (data) {
                    if (Object.keys(data).length == 0) {
                        _vacation.notificationInfo('no plans found!');
                    } else if (data.error) {
                        _vacation.notificationError(
                            "<i>" + data['message'] + "</i>"
                        );
                    } else {
                        callback(data);
                    }

                    _vacation.removeOverlay($form);
                },
                error: function () {
                    _vacation.notificationError('unknown error!');
                    _vacation.removeOverlay();
                }
            });
        };

        this.showModal = function (data) {
            data = data || {};
            var $form = $('#vacation-form');
            var $modal = $('#vacation-modal');

            data['id'] = (data['id'] || '');
            data['_method'] = (data['id'] ? "PUT" : 'POST');

            var actionForm = _vacation.defaults.url.base + (data['id'] ? "/" + data['id'] : '');
            var actionTitle = (data['id'] ? 'Edit' : 'Create');

            data['title'] = (data['title'] || '');
            data['date'] = (data['date'] || '');
            data['description'] = (data['description'] || '');
            data['location'] = (data['location'] || '');
            data['participant'] = (data['participant'] || '');
            data['data_initial'] = (data['data_initial'] || '')
            data['data_final'] = (data['data_final'] || '')

            $form.attr('action', actionForm);

            $form[0].reset();

            $form.deserialize(data);

            $modal.find('.modal-title').html(actionTitle + ' Vacation Plan');
            $modal.show();

            _vacation.removeOverlay();
        };

        this.displayVacation = function (id) {
            $.ajax({
                url: _vacation.defaults.url.base + "/" + id,
                type: 'GET',
                success: function (data) {
                    if (Object.keys(data).length > 0 && data['error']) {
                        _vacation.notificationError(
                            "<i>" + data['message'] + "</i>"
                        );
                    } else {
                        var $modal = $('#vacation-show');
                        $modal.find('.modal-body').html(data);
                        $modal.show();
                    }

                    _vacation.removeOverlay();
                },
                error: function () {
                    _vacation.notificationError('unknown error!');
                    _vacation.removeOverlay();
                }
            });
        };

        this.reloadtableVacation = function () {
            _vacation.getTableVacation().ajax.reload(null, false);
        };

        this.getTableVacation = function () {
            if (!_vacation.defaults.table.vacation) {
                _vacation.defaults.table.vacation = $('#tableVacation').DataTable();
            }

            return _vacation.defaults.table.vacation;
        };

        this.run = function (config) {
            _vacation.start(config);
        };
    };

    $.vacation = function (params) {
        params = params || [];

        var obj = $(window).data("holiday.vacation");

        if (!obj) {
            obj = new Vacation();
            obj.run(params);
            $(window).data('holiday.vacation', obj);
        }

        return obj;
    };

})(window.jQuery, window, document);