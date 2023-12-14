// Смени таблица при 'all'
document.addEventListener('DOMContentLoaded', function () {
    var tableSelect = document.querySelector('select[name="table"]');
    var urlParams = new URLSearchParams(window.location.search);
    var selectedTable = urlParams.get('table');

    if (selectedTable) {
        tableSelect.value = selectedTable;
    }

    tableSelect.addEventListener('change', function () {
        var selectedTable = tableSelect.value;
        window.location.href = 'create.php?table=' + selectedTable;
    });
});

// Когато се превърти страницата, се проверява дали трябва да се покаже бутона за Top
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

// Когато бутона се кликне, върнете потребителя най-отгоре на страницата
function topFunction() {
    document.body.scrollTop = 0; // За Safari
    document.documentElement.scrollTop = 0; // За Chrome, Firefox, IE и Opera
}

// JavaScript за автоматично скриване на съобщението след 2 секунди
setTimeout(function () {
    document.getElementById("success-alert").style.display = "none";
}, 2000);
