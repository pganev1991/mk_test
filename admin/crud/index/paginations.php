</div>
<div class="pagination justify-content-center">
        <?php if ($currentPage > 1) : ?>
            <a class="page-link" href="<?= $prevLink ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a class="page-link <?= $i === $currentPage ? 'active' : '' ?>"
                href="?table=<?= $table ?>&sort=<?= $sort ?>&order=<?= $order ?>&page=<?= $i ?>&questions_per_page=<?= $questionsPerPage ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages) : ?>
            <a class="page-link" href="<?= $nextLink ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        <?php endif; ?>
    </div>