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
                                    <img src="{{ $product_path.$productData[0]->image }}" />
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
                                                                    RRP<br/>${{$productData[$idx]->rrp}}
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
                        @endif
                    @endfor
                </tr>
            @endfor
        </tbody>
    </table>
@endfor
<style>
    body {
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
        padding: 8px 5px;
        background: #bb2026;
        color: #fff;
        font-size: 16px;
        line-height: 2;
    }
    .page-content {
        width: calc(100% - 16px);
        height: calc(100% - 30px);
        padding: 15px 8px;
        page-break-after: always;
        margin: 0 auto;
    }
    .page-content .product {
        border: 1px solid #d7d9da;
        padding: 2px;
    }
    .product-body img {
        min-width: 150px;
        min-height: 180px;
        max-height: 220px;
    }
    .product-title {
        text-align: center;
        font-weight: bold;
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
</style>
</body>
</html>
