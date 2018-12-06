<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
</head>
<body>
<?php
    $product_path = public_path().'/assets/img/products/';
//$product_path =url('/').'/assets/img/products/';
?>
<div>
    @for ($p = 0; $p < $pages; $p++)
        <div class="row">
            <div class="page-body">
                @for ($j = 0; $j < 3; $j++)
                    <div class="row">
                        @for ($i = 0; $i < $page_columns; $i++)
                            <?php $idx = $p*3*$page_columns+$j*3+$i; ?>
                            @if ($idx < count($productData) && $productData[$idx])
                                <div class="nopadding {{ $page_columns == 2 ? 'col-6' : 'col-4'}}">
                                    @if (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'block')
                                        <div class="new-block">
                                            {{ $productData[$idx]->name }}
                                        </div>
                                    @elseif (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'logo')
                                        <img src="{{ $product_path.$productData[0]->image }}" />
                                    @else
                                        <div class="product-image">
                                            @if (array_key_exists('type', $productData[$idx]) && $productData[$idx]->type == 'product_is_new')
                                                <div class="ribbon active">NEW</div>
                                            @endif
                                            <img src="{{ $productData[$idx]->images ? $productData[$idx]->images : $product_path.'empty.jpg' }}" />
                                            <div class="product-box">
                                                @if (in_array('title', $display_options))
                                                    <div class="product-title">{{ $productData[$idx]->name }}</div>
                                                @endif
                                                <div>
                                                    @if (in_array('units', $display_options))
                                                        <div class="product-detail">{{ $productData[$idx]->items_per_outer }} units per outer</div>
                                                    @endif
                                                    <div class="product-detail pb-1">
                                                        @if ($barcode_options)
                                                            <div>{{$productData[$idx]->barcode_unit}}</div>
                                                        @elseif (in_array('rrp', $display_options))
                                                            <div class="redLabelColor">RRP ${{ $productData[$idx]->rrp ? $productData[$idx]->rrp : '0.00' }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="barcode-image">
                                                        @if ($barcode_options && array_key_exists('barcode_image', $productData[$idx]))
                                                            <img src="{{ $productData[$idx]->barcode_image ? $productData[$idx]->barcode_image : $product_path.'barcode.png' }}" />
                                                        @elseif (in_array('rrp', $display_options))
                                                            <div class="product-rrp">
                                                                RRP<br/>${{$productData[$idx]->rrp}}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endfor
                    </div>
                @endfor
            </div>
            <div class="page-footer">
                <span class="page-label">Page {{$p+1}}</span>
                <span class="pull-right pr-3">{{$fileName}}</span>
            </div>
        </div>
    @endfor
</div>
<style>
    .row {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }
    .col-4 {
        flex: 0 0 33.33333%;
        max-width: 33.33333%;
    }
    .col-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
    .page-body {
        height: 100%;
        width: 100%;
        padding: 15px 15px 40px;
    }
    .page-body .product-image {
        position: relative;
        height: calc(100% - 10px);
        min-height: 220px;
        margin: 5px;
        border: 1px solid #d7d9da;
        overflow: hidden;
        z-index: 999;
    }
    .page-body .product-image img {
        width: 100%;
        max-height: 58%;
    }
    .page-body .product-image .ribbon {
        text-align: center;
        transform: rotate(45deg);
        padding: 3px 0;
        top: 5px;
        right: -20px;
        width: 75px;
        background-color: #e6e6e6;
        color: #fff;
        position: absolute;
        font-size: 12px;
        font-weight: bold;
        z-index: 1;
        cursor: pointer;
    }
    .page-body .product-image .ribbon.active {
        background-color: #a30c11;
    }
    .page-body .new-block {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .page-body .product-image .product-box {
        position: absolute;
        width: 100%;
        bottom: 0px;
    }
    .page-body .product-image .product-box .product-title {
        min-height: 36px;
        text-align: center;
        padding: 0px 5px;
        font-size: 13px;
        font-weight: bold;
        position: absolute;
        bottom: 42px;
        width: 100%;
    }
    .page-body .product-image .product-box .product-detail {
        max-width: 60%;
        min-height: 18px;
        padding-left: 8px;
        font-size: 12px;
        line-height: 18px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .page-body .product-image .product-box .barcode-image {
        position: absolute;
        bottom: 5px;
        right: 8px;
        max-width: 40%;
    }
    .page-body .product-image .product-box .product-rrp {
        font-size: 12px;
        line-height: 16px;
        color: #a30c11;
    }
    .page-footer {
        position: absolute;
        width: 100%;
        bottom: 10px;
    }
    .page-footer .page-label {
        background: #8bc53f;
        color: #fff;
        padding: 2px 10px;
    }
    .pull-right {
        float: right;
    }
    .pr-3 {
        padding-right: 1rem !important;
    }
</style>
</body>
</html>
