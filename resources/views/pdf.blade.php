<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
<div class="front-page">
    @if ($logo_path)
        <img src="{{ $logo_path }}" />
    @endif
    <div class="front-footer">
        {{ $fileName }}
    </div>
</div>
<?php
ini_set('max_execution_time', 300);
$product_path = public_path().'/assets/img/products/';
//    $product_path =url('/').'/assets/img/products/';
?>
@for ($p = 0; $p < $pages; $p++)
    <table class="page-content">
        <tbody>
        @for ($j = 0; $j < 3; $j++)
            <tr>
                @for ($i = 0; $i < $page_columns; $i++)
                    <?php $idx = $p*3*$page_columns+$j*3+$i; ?>
                    @if ($idx < count($productData) && $productData[$idx])
                        <td class="product">
                            @if (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'block')
                                <div class="new-block">
                                    {{ $productData[$idx]->name }}
                                </div>
                            @elseif (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'logo')
                                <img src="{{ $productData[0]->images }}" />
                            @else
                                <div class="product-body">
                                    @if (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'product_is_new')
                                        <div class="ribbon active">NEW</div>
                                    @endif
                                    <img src="{{ $productData[$idx]->images ? $productData[$idx]->images : $product_path.'empty.jpg' }}" />
                                    <div class="product-box">
                                        @if (in_array('title', $display_options))
                                            <div class="product-title">{{ $productData[$idx]->name }}</div>
                                        @endif
                                        <table class="product-footer">
                                            <tbody>
                                            <tr>
                                                <td class="product-detail">
                                                    @if (in_array('units', $display_options))
                                                        {{ $productData[$idx]->items_per_outer }} units per outer<br>
                                                    @endif
                                                    @if ($barcode_options)
                                                        <div>{{$productData[$idx]->barcode_unit}}</div>
                                                    @elseif (in_array('rrp', $display_options))
                                                        <div class="redLabelColor">RRP ${{ $productData[$idx]->rrp ? $productData[$idx]->rrp : '0.00' }}</div>
                                                    @endif
                                                </td>
                                                <td class="barcode-image">
                                                    @if ($barcode_options && array_key_exists('barcode_image', $productData[$idx]))
                                                        {{--<img src="{{ $productData[$idx]->barcode_image ? $productData[$idx]->barcode_image : $product_path.'barcode.png' }}" />--}}
                                                    @elseif (in_array('rrp', $display_options))
                                                        <div class="product-rrp">
                                                            RRP<br/>${{ number_format((float)$productData[$idx]->rrp, 2, '.', '') }}
                                                        </div>
                                                    @endif
                                                </td>
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
@endfor
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
    .front-page {
        page-break-after: always;
    }
    .front-footer {
        position: absolute;
        bottom: 100px;
        width: 100%;
        min-height: 35px;
        text-align: center;
        padding: 5px;
        background: #bb2026;
        color: #fff;
        font-size: 18px;
        line-height: 2;
    }
    .page-content {
        width: calc(100% - 16px);
        height: calc(100% - 30px);
        padding: 15px 8px;
        margin: 0 auto;
    }
    .page-content .product {
        border: 1px solid #d7d9da;
        padding: 2px;
    }
    .product-body img {
        min-width: 120px;
        min-height: 170px;
        max-width: 190px;
        max-height: 270px;
    }
    .product-title {
        text-align: center;
        font-weight: 500;
    }
    .product-footer {
        width: 100%;
    }
    .product-footer .product-detail {
        min-height: 18px;
        padding-left: 2px;
        font-size: 12px;
        line-height: 18px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .product-footer .barcode-image {
        text-align: right;
        padding-right: 2px;
    }
    .product-footer .barcode-image .product-rrp {
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
</style>
</body>
</html>
