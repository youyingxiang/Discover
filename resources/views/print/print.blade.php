<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>{{ $orderName }}</title>
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="{{asset("static/bootstarp.css")}}" crossorigin="anonymous">
</head>
<body>
<div class="print">
    <style>
        .table-bordered > tbody > tr > td,
        .table-bordered > thead > tr > th,
        .table-bordered > tbody > tr > th,
        .table-bordered > tfoot > tr > th,
        .table-bordered > tfoot > tr > td {
            text-align: left;
        }
        .card {
            position: relative;
        }
        .card .postImg{
            width: 160px;
            height: 100px;
            position: absolute;
            right: 115px;
            top: 80px;
            z-index: 999;
        }
        .card .postImg img{
            width: 100%;
        }

    </style>
    @foreach($orders as $order)
        <div class="card ">
            <table class="table table-bordered">
                <i class="postImg"><img src="{{store_order_img($order->review_status)}}"/></i>

                <caption class="text-center"><h3>{{ $orderName }}</h3></caption>
                <thead>
                @foreach($orderField as $field)
                <tr>
                    @foreach($field as $key => $value)
                    <th colspan="{{ceil(count($itemField)/2)}}">{{$value}}：{{
                            collect(explode(".", $key))->reduce(function ($object,$field) use ($order){
                                return $object ? $object->$field : $order->$field;
                            })
                        }}</th>
                    @endforeach
                    @if(count($field) === 1)
                        <th colspan="{{ceil(count($itemField)/2)}}"></th>
                    @endif
                </tr>
                @endforeach
                <tr>
                @foreach($itemField as $field)
                    <th>{{ $field }}</th>
                @endforeach
                </tr>
                </thead>
                <tbody>
                @php
                if(! $order->items instanceof Illuminate\Database\Eloquent\Collection) {
                    $order->items = [$order->items];
                }
                @endphp
                @foreach($order->items as $item)
                    <tr>
                    @foreach($itemField as $key => $field)
                        <th>
                        {{
                            collect(explode(".", $key))->reduce(function ($object,$value) use ($item){
                                return $object ? $object->$value : $item->$value;
                            })
                        }}
                        </th>
                    @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
</body>
<script language="javascript" src="{{asset('static/js/jquery.js')}}"></script>
<script language="javascript" src="{{asset('static/js/jquery.print.js')}}"></script>
<script>
    $(".print").jqprint();
</script>
</html>
