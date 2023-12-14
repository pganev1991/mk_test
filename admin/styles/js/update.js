// JavaScript за изтриване на снимка
function deleteImage(id, imageName, table, field, imageElementId, deleteButtonId) {
    if (confirm("Сигурни ли сте, че искате да изтриете тази снимка?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_img.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                alert(xhr.responseText); // Показване на отговор от сървъра
                // Скриване на снимката и бутона
                hideImageAndButton(imageElementId, deleteButtonId);
            } else {
                alert("Грешка при изтриване на снимка. Статус: " + xhr.status);
            }
        };

        xhr.onerror = function () {
            alert("Грешка при изпращане на заявка до сървъра.");
        };

        xhr.send("id=" + encodeURIComponent(id) + "&image_name=" + encodeURIComponent(imageName) + "&table=" + encodeURIComponent(table) + "&field=" + encodeURIComponent(field));
    }
}

// Функция за скриване на снимката и бутона
function hideImageAndButton(imageElementId, deleteButtonId) {
    // Скрийте снимката и бутона за изтриване
    document.getElementById(imageElementId).style.display = 'none';
    document.getElementById(deleteButtonId).style.display = 'none';
}

// JavaScript за автоматично скриване на съобщението след 5 секунди
        setTimeout(function () {
            document.getElementById("success-alert").style.display = "none";
        }, 5000);