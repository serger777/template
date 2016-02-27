// Объявление модуля
var validation = (function () {

    // Инициализирует наш модуль
    var init = function () {
        _setUpListners();
    };

    // Прослушивает события
    var _setUpListners = function () {
        //$('form').on('keydown', '.add-error', _removeError);
        $('form').on('reset',  _clearForm);
        $('.form_1').on('keydown', '.add-error', _removeError);
        $('.form_2').on('keydown', '.add-error', _removeError);
        $('.form_3').on('keydown', '.add-error', _removeError);
    };
    var _removeError = function () {
        $(this).removeClass('add-error');

    };
    var _clearForm = function (form){
        var form = $(this);
        form.find('input, textarea').trigger('hideTooltip');

        form.find('.add-error').removeClass('add-error');
    };
    var _createQtip = function  (element, position) {

        if(position === 'right'){
            position = {
                my: 'left center',
                at: 'right center'
            }
        }else{
            position = {
                my: 'right center',
                at: 'left center',
                adjust:{
                    method:'shift none'
                }
            }
        }

        // создание тултипа
        element.qtip({
            content: {
                text: function () {
                    return $(this).attr('qtip-content');
                }
            },
            show: {
                event: 'show'
            },
            hide: {
                event: 'keydown hideTooltip'
            },
            position : position,
            style: {
                classes: ' myclass',
                tip:{
                    height:10,
                    width:16
                }
            }
        }).trigger('show');

    };

// функция валидация
    var validateForm = function(form){

        var elements = form.find('input, textarea, .form__input').not('input[type="file"], input[type="hidden"]'),
            valid = true;

        $.each(elements, function(index, val){
            var element = $(val),
                val = element.val(),
                pos = element.attr('qtip-position');

            if(val.length === 0){
                element.addClass('add-error');
                _createQtip(element, pos);
                valid = false;
            }
        });
        return valid;
    };



    return {
        init: init,
        validateForm : validateForm,
        _clearForm : _clearForm,
        _createQtip : _createQtip

    };

})();

// Вызов модуля
validation.init();





