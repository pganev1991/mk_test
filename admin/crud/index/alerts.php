<div class="container">
        <?php if (isset($_SESSION["msg"])) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="success-alert">
                <?= htmlspecialchars($_SESSION["msg"], ENT_QUOTES, 'UTF-8') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION["msg"]); ?>
        <?php endif; ?>