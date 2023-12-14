function getHTMLContent(callback) {
  // Извикваме AJAX заявка към /mk_test/view/index.php
  $.ajax({
    url: '/mk_test/view/index.php',
    type: 'get',
    success: function (response) {
      var htmlContent = response;

      // Вграждане на снимките в HTML кода
      var images = document.querySelectorAll('img');
      images.forEach(function (image) {
        var dataURL = getBase64Image(image);
        var imageSrc = 'data:image/png;base64,' + dataURL;
        htmlContent = htmlContent.replace(image.getAttribute('src'), imageSrc);
      });

      // Изключване на елементите с атрибут data-export="exclude"
      var excludeElements = document.querySelectorAll('[data-export="exclude"]');
      excludeElements.forEach(function (element) {
        htmlContent = htmlContent.replace(element.outerHTML, '');
      });

      // Извикваме callback функцията с полученото съдържание
      callback(htmlContent);
    },
    error: function () {
      // В случай на грешка може да изведете подходящо съобщение
      alert('Грешка при извличане на данни.');
    }
  });
}

// Функция за конвертиране на изображение в base64 формат
function getBase64Image(img) {
  var canvas = document.createElement('canvas');
  canvas.width = img.width;
  canvas.height = img.height;

  var ctx = canvas.getContext('2d');
  ctx.drawImage(img, 0, 0, img.width, img.height);

  var dataURL = canvas.toDataURL('image/png');
  return dataURL.replace(/^data:image\/(png|jpg);base64,/, '');
}

function exportToDoc() {
  // Извикване на html2docx функцията с HTML съдържанието, включващо снимките
  getHTMLContent(function (htmlContent) {
    var converted = htmlDocx.asBlob(htmlContent);

    // Генериране на името на файла с текущата дата и година
    var currentDate = new Date();
    var fileName = 'DZI_Test_' + currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate() + '.docx';

    // Създаване на временен <a> елемент за изтегляне на файл
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(converted);
    link.download = fileName;

    // Добавяне на елемента към DOM и извикване на "click" събитие
    document.body.appendChild(link);
    link.click();

    // Премахване на временния елемент
    document.body.removeChild(link);
  });
}

$(document).on('click', '#refreshButton', function() {
  // Проверяваме дали бутона е активен (не е в процес на заявка)
  if (!$(this).hasClass('disabled')) {
    // Активираме бутона и добавяме клас disabled
    $(this).addClass('disabled');

    // Извикваме AJAX заявка
    $.ajax({
      url: '../view/index.php',
      type: 'get',
      data: { modal: 1 },  // Подаваме параметъра modal в заявката
      success: function (response) {
          // Показваме модалния прозорец и вмъкваме съдържанието в елемента
          $('#updateModalContent').html(response);
          $('#updateModal').fadeIn();
      },
      error: function () {
        // В случай на грешка може да изведете подходящо съобщение
        alert('Грешка при изпращане на данните.');

        // Разблокираме бутона и премахваме клас disabled
        $('#refreshButton').removeClass('disabled');
      }
    });
  }
});

