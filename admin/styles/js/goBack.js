// Връщане назад при ОТКАЗ вместо:
//-> за create.php и update.php: <a href="index.php?table=<?= htmlspecialchars($table) ?>" class="btn btn-danger">Отказ</a>

function goBack() {
    window.history.back();
}
