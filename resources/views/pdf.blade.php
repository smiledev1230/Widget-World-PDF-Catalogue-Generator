<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
<div class="front-page">
    <img src="{{ $brand_path }}" class="cover-image" />
    @if ($logo_url)
        <img src="{{ $logo_url }}" class="logo-image" />
    @endif
    <div class="front-footer">
        {{ $fileName }}
    </div>
</div>
<?php
    ini_set('max_execution_time', 500);
    $product_path = public_path().'/assets/img/products/';
    $pageRows = $page_columns == 4 ? 4 : 3;
    if ($page_columns == 4) {
        $pageRows = 4;
        $fourCols = 'cols-4';
    } else {
        $pageRows = 3;
        $fourCols = '';
    }
?>
@for ($p = 0; $p < $pages; $p++)
    <table class="page-content <?php echo $fourCols; ?>" width="100%">
        <tbody>
        @for ($j = 0; $j < $pageRows; $j++)
            <tr>
                @for ($i = 0; $i < $page_columns; $i++)
                    <?php $idx = $p*$pageRows*$page_columns+$j*$page_columns+$i; ?>
                    @if ($idx < count($productData) && $productData[$idx])
                        <?php
                            $logoState = array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'logo';
                            $barcodeState = $barcode_options && array_key_exists('barcode_image', $productData[$idx]);
                        ?>
                        <td class="product <?php if (!$logoState) echo 'product-border'; ?>">
                            @if (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'block')
                                <div class="new-block">
                                    <div>
                                        <?php echo $productData[$idx]->name;?>
                                    </div>
                                </div>
                            @elseif ($logoState)
                                <div class="brand-image">
                                    <img src="{{ $productData[$idx]->images }}"/>
                                </div>
                            @else
                                <div class="product-body">
                                    @if (array_key_exists('product_is_new', $productData[$idx]) && $productData[$idx]->product_is_new)
                                        <div class="product-new <?php if ($barcodeState) echo 'product-new-2'; ?>">NEW</div>
                                    @endif
                                    <div class="content-center">
                                        <img src="{{ $productData[$idx]->images ? $productData[$idx]->images : $product_path.'empty.jpg' }}" class="product-image"/>
                                    </div>
                                    <div class="product-box">
                                        @if (in_array('title', $display_options))
                                            <div class="product-title">{{ $productData[$idx]->name }}</div>
                                        @endif
                                        <table class="product-footer">
                                            <tbody>
                                            <tr>
                                                <th align="left" class="product-detail">
                                                    @if (in_array('units', $display_options))
                                                        {{ $productData[$idx]->items_per_outer }} units per outer<br>
                                                    @endif
                                                    @if (!$barcode_options)
                                                        <div>{{$productData[$idx]->barcode_unit}}</div>
                                                    @elseif (in_array('rrp', $display_options))
                                                        <div class="redLabelColor">RRP ${{ $productData[$idx]->rrp ? $productData[$idx]->rrp : '0.00' }}</div>
                                                    @endif
                                                </th>
                                                <th align="right" class="barcode-image">
                                                    @if ($barcodeState)
                                                        <img src="{{ $productData[$idx]->barcode_image ? $productData[$idx]->barcode_image : $product_path.'barcode.png' }}" />
                                                    @elseif (in_array('rrp', $display_options))
                                                        <div class="product-rrp">
                                                            RRP<br/>${{ number_format((float)$productData[$idx]->rrp, 2, '.', '') }}
                                                        </div>
                                                    @endif
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </td>
                    @else
                        <td></td>
                    @endif
                @endfor
            </tr>
        @endfor
        </tbody>
    </table>
    <div class="page-number">Page {{$p + 1}}</div>
    <div class="page-title">{{ $fileName }}</div>
    @if ($p < $pages -1)
        <span class="front-page"></span>
    @endif
    <style>
        @font-face {
            font-family: 'Deja';
            font-style: normal;
            font-weight: normal;
            src: url('<?= $_SERVER['DOCUMENT_ROOT'] ?>/widget-world/vendors/dompdf/dompdf/lib/fonts/DejaVuSans.ttf') format('truetype');
        }
        body {
            font-family: 'Deja', sans-serif;
            margin: 0px;
        }
        .content-center {
            text-align: center;
        }
        .front-page {
            page-break-after: always;
        }
        .front-page .cover-image {
            position: absolute;
            width: 100%;
            max-height: 100%;
            height: auto;
        }
        .front-page .logo-image {
            position: absolute;
            bottom: 280px;
            width: 240px;
            margin-left: 240px;
        }
        .front-footer {
            position: absolute;
            bottom: 100px;
            width: 86.5%;
            height: 40px;
            margin-left: 6%;
            padding: 0px 5px;
            text-align: center;
            background: #bb2026;
            color: #fff;
            font-size: 18px;
            line-height: 1.8;
        }
        .page-content {
            margin: 0 auto;
        }
        .page-content .product {
            padding: 5px 5px 0;
            width: 200px;
            height: 283px;
            position: relative;
            overflow: hidden;
        }
        .product-border {
            border: 1px solid #d7d9da;
        }
        .brand-image {
            text-align: center;
        }
        .brand-image img {
            max-width: 200px;
            max-height: 283px;
        }
        .product-body .product-new {
            text-align: center;
            transform: rotate(45deg);
            padding: 3px 0;
            top: -5px;
            right: -20px;
            width: 75px;
            color: #fff;
            position: absolute;
            font-size: 12px;
            font-weight: bold;
            z-index: 1;
            cursor: pointer;
            background-color: #a30c11;
        }
        .product-body .product-new.product-new-2 {
            top: 5px;
        }
        .product-body .product-image {
            min-width: 120px;
            min-height: 160px;
            max-width: 160px;
            max-height: 180px;
        }
        .barcode-image img {
            height: 32px;
        }
        .product-title {
            text-align: center;
            font-weight: 500;
            font-size: 10px;
            height: 55px;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 12px;
            /*display: -webkit-box;*/
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .product-footer {
            width: 100%;
        }
        .product-footer .product-detail {
            min-height: 18px;
            font-size: 12px;
            line-height: 18px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .product-footer .barcode-image .product-rrp,
        .product-footer .redLabelColor {
            font-size: 12px;
            line-height: 16px;
            color: #a30c11;
        }
        .page-number {
            position: absolute;
            bottom: 20px;
            left: 0px;
            padding: 2px 10px;
            background: #8bc53f;
            color: #fff;
        }
        .page-title {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }
        .new-block {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .cols-4.page-content .product {
            width: 150px;
            height: 160px;
        }
        .cols-4 .product-body .product-image {
            min-width: 100px;
            min-height: 100px;
            max-width: 120px;
            max-height: 120px;
        }
    </style>
@endfor
</body>
</html>
