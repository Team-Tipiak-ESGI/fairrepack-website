<div class="container my-5">
    <div class=raw">
        <div class="col-md-6">
            <h3>Accès aux différents CRUDs</h3>
            <div class="list-group">
                <a href="index.php"
                   class="list-group-item list-group-item-action <?php if ($page == 'index') echo "active"; ?>">Index</a>
                <a href="warehouses.php" class="list-group-item list-group-item-action <?php if ($page == 'warehouses') echo "active"; ?>">BO Entrepôts</a>
                <a href="categories.php" class="list-group-item list-group-item-action <?php if ($page == 'categories') echo "active"; ?>">BO Catégories</a>
                <a href="types.php" class="list-group-item list-group-item-action <?php if ($page == 'types') echo "active"; ?>">BO types</a>
                <a href="addresses.php" class="list-group-item list-group-item-action <?php if ($page == 'addresses') echo "active"; ?>">BO Adresses</a>
                <a href="associations.php" class="list-group-item list-group-item-action <?php if ($page == 'associations') echo "active"; ?>">BO Associations</a>
            </div>
        </div>
    </div>
</div>
