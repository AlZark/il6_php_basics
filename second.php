<?php


//$x = '2faAutth';
//$y = 2;

//var_dump($x);
//var_dump($y);
//var_dump(2 * $y);

//var_dump($x * $y);

//$x = 2;
//$y = 3;
//
//if($x > $y){
//    echo 'true';
//}else{
//    echo 'false';
//}
//
//switch($x){
//    case 2:
//        echo 'true';
//        break;
//    case 3:
//        echo 'false';
//        break;
//    default:
//        echo "something else";
//        break;
//}

//if(!$variable){
//    $variable = 2;
//}


//$products = [
//    [
//        'name' => 'Siulai',
//        'price' => 12.4,
//        'special_price' => 10.1,
//        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
//    ],
//    [
//        'name' => 'Adata',
//        'price' => 1.99,
//        'special_price' => 0.99,
//        'img' => 'https://www.kumutis.lt/wp-content/uploads/2020/10/Ilga-adata-rankdarbiams-scaled.jpg'
//    ],
//    [
//        'name' => 'Siulai',
//        'price' => 12.4,
//        'special_price' => 10.1,
//        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
//    ],
//    [
//        'name' => 'Adata',
//        'price' => 1.99,
//        'img' => 'https://www.kumutis.lt/wp-content/uploads/2020/10/Ilga-adata-rankdarbiams-scaled.jpg'
//    ],
//    [
//        'name' => 'Siulai',
//        'price' => 12.4,
//        'img' => 'https://siulupinkles.lt/wp-content/uploads/2021/01/Mezgimo-siulai-ritese-italiski-siulai-kasmyras-kasmyro-siulai-silko-siulai-silkas.jpg'
//    ]
//];

//$product_count = 0;
//foreach ($products as $product){
//    echo '<img width="150" src="'. $product["img"] .'" />';
//    echo '<h2>' . $product["name"] . '</h2>';
//    if(isset($product["special_price"])){
//        echo '<h2><del> Price: ' .$product["price"] . '</del></h2>';
//        echo '<h2> Special price: ' .$product["special_price"] . '<h2>';
//    }else{
//        echo '<h2> Price: ' .$product["price"] . '<h2>';
//    }
//    $product_count++;
//    if($product_count % 3 === 0) {
//        echo '<hr>';
//    }
//}


//for ($y = 0; $y < 10; $y++) {
//    for($x = 0; $x < 10; $x++) {
//        if($y % 2 == 0) {
//            if($x % 2 == 0) {
//                echo '#';
//            } else {
//                echo '.';
//            }
//        } else {
//            echo '#';
//        }
//    }
//    echo '<br>';
//}

for($years = 2015; $years < 2022; $years++) {
    for ($months = 1; $months <= 12; $months++) {
        if ($months == 1 || $months == 3 || $months == 5 || $months == 8 || $months == 10 || $months == 12) {
            $to = 31;
        } elseif ($months == 2) {
            if ($years % 4 == 0) {
                $to = 29;
            } else {
                $to = 28;
            }
        } else {
            $to = 30;
        }
        for ($day = 1; $day <= $to; $day++) {
            echo $years . ' ' . $months . ' ' . $day;
            echo '<br>';
        }
    }
}

