// Функция за отваряне на модалния прозорец за генериране на тест
function openTestGenerationModal() {
    // Подготвяме AJAX заявка за извличане на съдържание от view/index.php
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
            alert('Грешка при извличане на данни.');
        }
    });
}

// Функция за отваряне на редакционния модален прозорец
function openUpdateModal(questionId, table) {

    // Подготвяме AJAX заявка за извличане на съдържание от update.php
    $.ajax({
        url: '../admin/update.php',
        type: 'get',
        data: {
            id: questionId,
            table: table
        },
        async: true,
        success: function (response) {
            // Показваме модалния прозорец и вмъкваме съдържанието в елемента
            $('#updateModalContent').html(response);
            $('#updateModal').fadeIn();
        },
        error: function () {
            // В случай на грешка може да изведете подходящо съобщение
            alert('Грешка при извличане на данни.');
        }
    });
}

// Функция, която се извиква при клик върху бутона за изтриване на снимката
function deleteImageConfirmation(event) {
    console.log('deleteImageConfirmation called');

    var result = confirm("Сигурни ли сте, че искате да изтриете снимката?");
    if (result) {
        // Изтриване на снимката (примерно с AJAX заявка)
        // Премахване на HTML елемента на снимката
        document.getElementById('imagePreview').src = ''; // Променете 'imagePreview' с ID-то на вашия елемент за снимка
    } else {
        // Отказано изтриване, нищо не правим
    }

    // Използваме специфичен селектор за бутоните, които искаме да изключим от стандартното действие
    if (!event.target.closest('.keep-modal-open')) {
        // Връщаме false, за да предотвратим стандартното действие на браузъра
        event.preventDefault();
        return false;
    }
}

// Функция за затваряне на модалния прозорец
function closeUpdateModal() {
    $('#updateModal').fadeOut();
}

// Функия ИЗБЕРИ ВСИЧКИ въпроси, чрез отбелязване на чекбокс
$(document).ready(function () {
    // Функция за проверка и актуализация на "ИЗБЕРИ ВСИЧКИ" чекбокс
    function updateSelectAllCheckbox() {
        const checkboxes = $('.question-checkbox');
        const allChecked = checkboxes.length > 0 && checkboxes.length === checkboxes.filter(':checked').length;
        $('#selectAll').prop('checked', allChecked);
    }

    // Слушане за промяна в "ИЗБЕРИ ВСИЧКИ" чекбокс
    $('#selectAll').change(function () {
        const checkboxes = $('.question-checkbox');
        checkboxes.prop('checked', $(this).prop('checked'));
        updateSelectAllCheckbox();
    });

    // Слушане за промяна във всеки чекбокс
    $('.question-checkbox').change(function () {
        updateSelectAllCheckbox();
    });

    // Актуализация при зареждане на страницата
    updateSelectAllCheckbox();
});

// Функция за обновяване на страницата за първата форма
function refreshPage() {
    location.reload(true);
}

// Изчисти полето на търсачката
function clearSearchForm() {
    document.getElementById('searchInput').value = ''; // Изчисти полето на търсачката
    document.getElementById('tableSelect').value = ''; // Върни селекта за раздел в началната позиция
    document.getElementById('questionsPerPage').value = ''; // Върни селекта за брой въпроси на страница в началната позиция
    document.getElementById('searchForm').submit(); // Изпрати формата за да изчисти резултатите
}

// Обща функция за изтриване на въпроси
function deleteQuestions(ids, table) {
    if (window.confirm('Сигурни ли сте, че искате да изтриете избраните въпроси?')) {
        if (table === 'all') {
            window.location.href = 'delete_all.php?ids=' + ids.join(',');
        } else {
            window.location.href = 'delete.php?ids=' + ids.join(',') + '&table=' + table;
        }
    }
}

// Изтриване на въпроси, отбелязани с чекбокс
function deleteSelectedQuestions() {
    const selectedIds = [];
    const checkboxes = document.querySelectorAll('.question-checkbox:checked');
    const table = document.querySelector('select[name="table"]').value;

    checkboxes.forEach(checkbox => {
        selectedIds.push(checkbox.dataset.questionId);
    });

    if (selectedIds.length === 0) {
        alert('Моля, изберете въпроси за изтриване.');
        return;
    }

    deleteQuestions(selectedIds, table);
}

// Потвърждаване на изтриване на въпрос от CRUD бутон
function confirmDelete(id, table) {
    deleteQuestions([id], table);
}

//Функция, свързана с броя въпроси на страница
function updateQuestionsPerPage() {
    const select = document.getElementById('questionsPerPage');
    const selectedValue = select.options[select.selectedIndex].value;
    document.querySelector('input[name="questions_per_page"]').value = selectedValue;

    // Вземете формата и я предайте като параметър при препращане
    const form = document.querySelector('form');
    form.submit();
}

//Изчистване на търсенето
function clearSearch() {
    document.getElementById('searchInput').value = '';
    location.href = window.location.pathname;
}

//Функции за топ бутона
window.onscroll = function () {
    scrollFunction()
};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("topBtn").style.display = "block";
    } else {
        document.getElementById("topBtn").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

//Изчезване на известието след 5 секунди
setTimeout(function () {
    var alert = document.getElementById("success-alert");
    if (alert) {
        alert.remove();
    }
}, 5000);
