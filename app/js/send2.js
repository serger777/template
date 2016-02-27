// Объявление модуля
var contactME = (function () {

    // Инициализирует наш модуль
    var init = function () {
        _setUpListners();
    };

    // Прослушивает события
    var _setUpListners = function () {
        $('.form_1').on('submit', _submitForm);
    };
    var _submitForm = function  (ev) {
        ev.preventDefault();
        var form = $(this),
            url = 'action.php',
            box = $('#serv-msg'),
            defObj = _ajaxForm(form, url);
        console.log(defObj);

        if (defObj) {
            defObj.done(function(ans){
                //ajax выполен, вернул значение ans
                if (ans.status === 'OK') {
                    box.text(ans.text).addClass('success').removeClass('error').show();


                }else{
                    box.text(ans.text).addClass('error').removeClass('success').show();


                }
            })
        }
    };

    var _ajaxForm = function (form, url) {

        if (!validation.validateForm(form)) return false

        // Если false то код ниже не произодет никгда
        var data = form.serialize(), //сериализуем форму для отправки в виде
            box = $('#serv-msg'),
        //присваеваем значение которое вернет ajax
            result = $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',  //тип передаваемых данных
                data: data,		   //передаваеммые данные с формы
            }).fail(function(ans) {
                //в случаи если ajax не удался выводим ошибку
                box.text('Письмо не отправлено! Проблемы с сервером.').addClass('error').removeClass('success').show();
            });

        return result;


    };




    // Возвращаем объект (публичные методы)
    return {
        init: init

    };

})();

// Вызов модуля
contactME.init();