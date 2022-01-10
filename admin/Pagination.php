<?php
$maxPage = ceil($count / $perPage);
?>
<nav aria-label="Page navigation example">
    <ul class="pagination pagination-sm justify-content-center">
        <li class="page-item <?php echo $currentPage == 1 ? "disabled" : "" ?>  ">
            <a class="fw-bold page-link" href="?<?php echo "page=" . ($currentPage - 1) . "$query" ?>" tabindex="-1" aria-disabled="true"><i class="fas fa-arrow-left"></i></a>
        </li>
        <?php for ($i = 1; $i <= $maxPage; $i++) { ?>
            <li class="page-item <?php echo $currentPage != $i ? "" : "active" ?>"><a class="fw-bold page-link" href="?<?php echo "page=$i$query" ?>"><?php echo $i ?></a>
            <?php  } ?>
            <li class="page-item <?php echo $currentPage < $maxPage ? "" : "disabled" ?> ">
                <a class="fw-bold page-link " href="?<?php echo "page=" . ($currentPage + 1) . "$query" ?>"><i class="fas fa-arrow-right"></i></a>
            </li>
    </ul>
</nav>