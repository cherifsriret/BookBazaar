<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php 
        $currentParams = $_GET;
        unset($currentParams['page']);

        foreach ($currentParams as $key => $value) {
          $currentParams[$key] = urlencode($value);
        }

        foreach ($currentParams as $key => $value) {
          $currentParams[$key] = "$key=$value";
        }
        $currentParamsString = implode('&', $currentParams);
      ?>
      <li class="page-item <?= ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./<?= htmlentities($current_url) ?>?page=1&<?= htmlentities($currentParamsString) ?>" tabindex="-1" aria-disabled="true">First</a>
      </li>
      <li class="page-item <?= ($currentPage == 1) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./<?= htmlentities($current_url) ?>?page=<?= urlencode($currentPage - 1); ?>&<?= htmlentities($currentParamsString) ?>" tabindex="-1" aria-disabled="true">Previous</a>
      </li>

      <?php for ($i = max(1, $currentPage - 2); $i <= min($currentPage + 2, $totalPages); $i++): ?>
        <li class="page-item <?= ($currentPage == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="./<?= htmlentities($current_url) ?>?page=<?= urlencode($i); ?>&<?= htmlentities($currentParamsString) ?>"><?= urlencode($i); ?></a>
        </li>
      <?php endfor; ?>

      <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./<?= htmlentities($current_url) ?>?page=<?= urlencode($currentPage + 1); ?>&<?= htmlentities($currentParamsString) ?>">Next</a>
      </li>
      <li class="page-item <?= ($currentPage == $totalPages) ? 'disabled' : ''; ?>">
        <a class="page-link" href="./<?= htmlentities($current_url) ?>?page=<?= htmlentities($totalPages); ?>&<?= htmlentities($currentParamsString) ?>">Last</a>
      </li>
    </ul>
  </nav>