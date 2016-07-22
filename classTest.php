<?php

// クラスを定義@
class Product
{
    private $name;  // 商品名
    private $price;   // 価格

    // 商品名を取得する
    public function getName()
    {
        return $this->name;
    }

    // 商品名を設定する
    public function setName($name)
    {
        $this->name = $name;
    }
}

// インスタンス生成
$product= new Product();

// 商品名を設定
$product->setName("かまぼこ");

// 商品名を取得
$productName = $product->getName();

var_dump($productName);

?>
