<?php
session_start();
include "sources.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
$products = [];

if (isset($_SESSION['products'])) {
    $products = $_SESSION['products'];
} else {
    generateProduct();
    $_SESSION['products'] = $products;
}

if (isset($_GET['session'])) {
    session_destroy();
    header("Location: index.php");
}

if (isset($_GET['update'])) {
    $icon1s = (isset($_GET['icon1']) && $_GET['icon1'] === "true");
    $icon2s = (isset($_GET['icon2']) && $_GET['icon2'] === "true");
    $icon3s = (isset($_GET['icon3']) && $_GET['icon3'] === "true");
    showProduct();
} else {
    $icon1s = true;
    $icon2s = true;
    $icon3s = true;
}

function displayCheckBox()
{
    echo "Filter by type of store <br>";
    echo '<div class="form-check">
    <input class="form-check-input" type="checkbox" value="1" id="icon1" onclick="updateCheckBox()" checked>
    <label class="form-check-label" for="flexCheckChecked">
      ' . $GLOBALS['icon1'] . '
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="2" id="icon2" onclick="updateCheckBox()" checked>
    <label class="form-check-label" for="flexCheckChecked">
    ' . $GLOBALS['icon2'] . '
    </label>
  </div>
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="3" id="icon3" onclick="updateCheckBox()" checked>
    <label class="form-check-label" for="flexCheckChecked">
    ' . $GLOBALS['icon3'] . '
    </label>
  </div>';
}
function showProduct()
{
    global $icon1s, $icon2s, $icon3s;
    global $products;
    echo '  <div class="container-fluid text-center ps-3">
                    <div class="row my-2 text-start">
                        <b>Products</b>
                    </div>
                    <div class="row border-top border-2 py-2 text-center overflow-scroll full-height ms-auto d-flex justify-content-center">';
    foreach ($products as $product) {
        if (($product->type == "icon1" && $icon1s) || ($product->type == "icon2" && $icon2s) || ($product->type == "icon3" && $icon3s)) {
            echo "<div class='card text-start my-3 me-3' style='width: 18rem;'>
                    <img src='{$product->imageURL}' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$product->name}</h5>
                        <p class='card-text mb-0'>Rp.{$product->price}</p>
                        <p class='card-text my-0'>{$product->icon}{$product->storeName}</p>
                        <p class='card-text mt-0'>Stock: {$product->totalStock}</p>
                        <a href='#' class='stretched-link'></a>
                    </div>
                </div>";
        }
    }
    echo '      </div>
            </div>';
    if (isset($_GET['update'])) exit();
}
function generateProduct()
{
    global $products;
    $counter = 0;
    $counterPict = 0;
    $icon = "";
    for ($i = 0; $i < 20; $i++) {
        $counterPict++;
        if ($i % 2 == 0) {
            $counter++;
            $random = "icon" . rand(1, 3);
            $icon = $GLOBALS[$random];
        }
        if ($i % 3 == 0) $counterPict = 0;

        $productTemp = new product("pictures/lamy" . ($counterPict + 1) . ".jpeg", "LAMY Safari Fountain Pen " . ($i + 1), 450000 + $i, "Store$counter", rand(50, 500), $icon, $random);
        array_push($products, $productTemp);
        unset($productTemp);
    }
}
function resetSessionButton()
{
    echo '
    <form action="index.php" method="GET">
        <button type="submit" class="btn btn-primary my-3" name="session">Reset Product</button>
    </form>
    ';
}
class product
{
    public $imageURL;
    public $name;
    public $price;
    public $storeName;
    public $totalStock;
    public $icon;
    public $type;
    function __construct($imageURL, $name, $price, $storeName, $totalStock, $icon, $type)
    {
        $this->imageURL = $imageURL;
        $this->name = $name;
        $this->price = $price;
        $this->storeName = $storeName;
        $this->totalStock = $totalStock;
        $this->icon = $icon;
        $this->type = $type;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas Asistensi M1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="update.js"></script>
</head>

<body>
    <?= $navbar ?>
    <div class="container-fluid text-center">
        <div class="row">
            <div class="col-2 h-auto my-5 text-start">
                <?php
                displayCheckBox();
                resetSessionButton();
                ?>
            </div>
            <div class="col border-start border-3 h-auto" id="product">
                <?php showProduct(); ?>
            </div>
        </div>
    </div>

</body>

</html>