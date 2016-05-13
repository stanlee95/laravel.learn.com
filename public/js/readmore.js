
sh();
function sh() {
    obj = document.getElementById("info");
    if (obj.style.display == "none") {
        obj.style.display = "block";
    } else {
        obj.style.display = "none";
    }
}

//------------------------ImagePreview.---------------------------------------------------------------------------------
var previewWidth = 150, // ширина превью
    previewHeight = 150, // высота превью
    maxFileSize = 1024 * 1024, // (байт) Максимальный размер файла (1мб)
    selectedFiles = {},// объект, в котором будут храниться выбранные файлы
    queue = [],
    image = new Image(),
    imgLoadHandler,
    isProcessing = false,
    errorMsg, // сообщение об ошибке при валидации файла
    previewPhotoContainer = document.querySelector('#preview-photo'); // контейнер, в котором будут отображаться превью

// Когда пользователь выбрал файлы, обрабатываем их
$('input[type=file][id=photo]').on('change', function() {
    var newFiles = $(this)[0].files; // массив с выбранными файлами

    for (var i = 0; i < newFiles.length; i++) {

        var file = newFiles[i];

        // В качестве "ключей" в объекте selectedFiles используем названия файлов
        // чтобы пользователь не мог добавлять один и тот же файл
        // Если файл с текущим названием уже существует в массиве, переходим к следующему файлу
        if (selectedFiles[file.name] != undefined) continue;

        // Валидация файлов (проверяем формат и размер)
        if ( errorMsg = validateFile(file) ) {
            alert(errorMsg);
            return;
        }

        // Добавляем файл в объект selectedFiles
        selectedFiles[file.name] = file;
        queue.push(file);

    }

    $(this).val('');
    processQueue(); // запускаем процесс создания миниатюр
});

// Валидация выбранного файла (формат, размер)
var validateFile = function(file)
{
    if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
        return 'Фотография должна быть в формате jpg, png или gif';
    }

    if ( file.size > maxFileSize ) {
        return 'Размер фотографии не должен превышать 2 Мб';
    }
};

var listen = function(element, event, fn) {
    return element.addEventListener(event, fn, false);
};

// Создание миниатюры
var processQueue = function()
{
    // Миниатюры будут создаваться поочередно
    // чтобы в один момент времени не происходило создание нескольких миниатюр
    // проверяем запущен ли процесс
    if (isProcessing) { return; }

    // Если файлы в очереди закончились, завершаем процесс
    if (queue.length == 0) {
        isProcessing = false;
        return;
    }

    isProcessing = true;

    var file = queue.pop(); // Берем один файл из очереди

    var li = document.createElement('LI');
    var span = document.createElement('SPAN');
    var spanDel = document.createElement('SPAN');
    var canvas = document.createElement('CANVAS');
    var ctx = canvas.getContext('2d');

    span.setAttribute('class', 'img');
    spanDel.setAttribute('class', 'delete');
    spanDel.innerHTML = 'Удалить';

    li.appendChild(span);
    li.appendChild(spanDel);
    li.setAttribute('data-id', file.name);

    image.removeEventListener('load', imgLoadHandler, false);

    // создаем миниатюру
    imgLoadHandler = function() {
        ctx.drawImage(image, 0, 0, previewWidth, previewHeight);
        URL.revokeObjectURL(image.src);
        span.appendChild(canvas);
        isProcessing = false;
        setTimeout(processQueue, 200); // запускаем процесс создания миниатюры для следующего изображения
    };

    // Выводим миниатюру в контейнере previewPhotoContainer
    previewPhotoContainer.appendChild(li);
    listen(image, 'load', imgLoadHandler);
    image.src = URL.createObjectURL(file);

    // Сохраняем содержимое оригинального файла в base64 в отдельном поле формы
    // чтобы при отправке формы файл был передан на сервер
    var fr = new FileReader();
    fr.readAsDataURL(file);
    fr.onload = (function (file) {
        return function (e) {
            $('#preview-photo').append(
                '<input type="hidden" name="photos[]" value="' + e.target.result + '" data-id="' + file.name+ '">'
            );
        }
    }) (file);
};

// Удаление фотографии
$(document).on('click', '#preview-photo li span.delete', function() {
    var fileId = $(this).parents('li').attr('data-id');

    if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // Удаляем файл из объекта selectedFiles
    $(this).parents('li').remove(); // Удаляем превью
    $('input[name^=photo][data-id="' + fileId + '"]').remove(); // Удаляем поле с содержимым файла
});


//-----------------------------------------------------------------------------------------------------------------------
window.onload= function() {
    document.getElementById('toggler').onclick = function() {
        openbox('box', this);
        return false;
    };
};
function openbox(id, toggler) {
    var div = document.getElementById(id);
    if(div.style.display == 'block') {
        div.style.display = 'none';
        toggler.innerHTML = 'Открыть';
    }
else {
        div.style.display = 'block';
        toggler.innerHTML = 'Закрыть';
    }
}


//------------------------------------------------------------------------------------------------------------------------
    /*!
     * @preserve
     *
     * Readmore.js jQuery plugin
     * Author: @jed_foster
     * Project home: http://jedfoster.github.io/Readmore.js
     * Licensed under the MIT license
     *
     * Debounce function from http://davidwalsh.name/javascript-debounce-function
     */
    !function(t){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports?module.exports=t(require("jquery")):t(jQuery)}(function(t){"use strict";function e(t,e,i){var a;return function(){var n=this,o=arguments,r=function(){a=null,i||t.apply(n,o)},s=i&&!a;clearTimeout(a),a=setTimeout(r,e),s&&t.apply(n,o)}}function i(t){var e=++h;return String(null==t?"rmjs-":t)+e}function a(t){var e=t.clone().css({height:"auto",width:t.width(),maxHeight:"none",overflow:"hidden"}).insertAfter(t),i=e.outerHeight(),a=parseInt(e.css({maxHeight:""}).css("max-height").replace(/[^-\d\.]/g,""),10),n=t.data("defaultHeight");e.remove();var o=a||t.data("collapsedHeight")||n;t.data({expandedHeight:i,maxHeight:a,collapsedHeight:o}).css({maxHeight:"none"})}function n(t){if(!d[t.selector]){var e=" ";t.embedCSS&&""!==t.blockCSS&&(e+=t.selector+" + [data-readmore-toggle], "+t.selector+"[data-readmore]{"+t.blockCSS+"}"),e+=t.selector+"[data-readmore]{transition: height "+t.speed+"ms;overflow: hidden;}",function(t,e){var i=t.createElement("style");i.type="text/css",i.styleSheet?i.styleSheet.cssText=e:i.appendChild(t.createTextNode(e)),t.getElementsByTagName("head")[0].appendChild(i)}(document,e),d[t.selector]=!0}}function o(e,i){this.element=e,this.options=t.extend({},s,i),n(this.options),this._defaults=s,this._name=r,this.init(),window.addEventListener?(window.addEventListener("load",l),window.addEventListener("resize",l)):(window.attachEvent("load",l),window.attachEvent("resize",l))}var r="readmore",s={speed:100,collapsedHeight:200,heightMargin:16,moreLink:'<a href="#">Read More</a>',lessLink:'<a href="#">Close</a>',embedCSS:!0,blockCSS:"display: block; width: 100%;",startOpen:!1,beforeToggle:function(){},afterToggle:function(){}},d={},h=0,l=e(function(){t("[data-readmore]").each(function(){var e=t(this),i="true"===e.attr("aria-expanded");a(e),e.css({height:e.data(i?"expandedHeight":"collapsedHeight")})})},100);o.prototype={init:function(){var e=t(this.element);e.data({defaultHeight:this.options.collapsedHeight,heightMargin:this.options.heightMargin}),a(e);var n=e.data("collapsedHeight"),o=e.data("heightMargin");if(e.outerHeight(!0)<=n+o)return!0;var r=e.attr("id")||i(),s=this.options.startOpen?this.options.lessLink:this.options.moreLink;e.attr({"data-readmore":"","aria-expanded":this.options.startOpen,id:r}),e.after(t(s).on("click",function(t){return function(i){t.toggle(this,e[0],i)}}(this)).attr({"data-readmore-toggle":"","aria-controls":r})),this.options.startOpen||e.css({height:n})},toggle:function(e,i,a){a&&a.preventDefault(),e||(e=t('[aria-controls="'+_this.element.id+'"]')[0]),i||(i=_this.element);var n=t(i),o="",r="",s=!1,d=n.data("collapsedHeight");n.height()<=d?(o=n.data("expandedHeight")+"px",r="lessLink",s=!0):(o=d,r="moreLink"),this.options.beforeToggle(e,n,!s),n.css({height:o}),n.on("transitionend",function(i){return function(){i.options.afterToggle(e,n,s),t(this).attr({"aria-expanded":s}).off("transitionend")}}(this)),t(e).replaceWith(t(this.options[r]).on("click",function(t){return function(e){t.toggle(this,i,e)}}(this)).attr({"data-readmore-toggle":"","aria-controls":n.attr("id")}))},destroy:function(){t(this.element).each(function(){var e=t(this);e.attr({"data-readmore":null,"aria-expanded":null}).css({maxHeight:"",height:""}).next("[data-readmore-toggle]").remove(),e.removeData()})}},t.fn.readmore=function(e){var i=arguments,a=this.selector;return e=e||{},"object"==typeof e?this.each(function(){if(t.data(this,"plugin_"+r)){var i=t.data(this,"plugin_"+r);i.destroy.apply(i)}e.selector=a,t.data(this,"plugin_"+r,new o(this,e))}):"string"==typeof e&&"_"!==e[0]&&"init"!==e?this.each(function(){var a=t.data(this,"plugin_"+r);a instanceof o&&"function"==typeof a[e]&&a[e].apply(a,Array.prototype.slice.call(i,1))}):void 0}});