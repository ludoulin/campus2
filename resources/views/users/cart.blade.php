@extends('layouts.basic')

@section('basic')
<link href="{{ asset('css/user/cart.css') }}" rel="stylesheet">
@endsection

@section('content')

<table id="cart" class="table table-hover table-condensed">
    <thead>
    <tr>
        <th style="width:50%">二手書</th>
        <th style="width:10%">價格</th>
        <th style="width:8%">賣家</th>
        <th style="width:22%" class="text-center">總計</th>
        <th style="width:10%"></th>
    </tr>
    </thead>
    <tbody>
    <?php $total = 0 ?>
    @guest
    @if(session('cart'))
    @foreach(session('cart') as $id => $details)
        <?php $total += $details['price'] ?>
        <tr>
            <td data-th="Product">
                <div class="row">
                    <div class="col-sm-3 hidden-xs"><img src="{{ asset($details['image']) }}" width="100" height="100" class="img-responsive"/></div>
                    <div class="col-sm-9">
                        <h4 class="nomargin">{{ $details['name'] }}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Price">${{ $details['price'] }}</td>
            <td data-th="Seller_name">
                {{ $details['seller_name'] }}
            </td>
            <td class="actions" data-th="">
                <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $id }}"><i class="fa fa-trash-o"></i></button>
                <button class="btn btn-success btn-sm">立即購買</button>
            </td>
        </tr>
    @endforeach
  @endif
@else
<?php $mycarts = Auth::user()->cartitems ?>
@foreach($mycarts as $id => $cart)
<?php $total += $cart->price ?>
<tr>
    <td data-th="Product">
        <div class="row">
            <div class="col-sm-3 hidden-xs"><img src="{{ asset($cart->images[0]->path) }}" width="100" height="100" class="img-responsive"/></div>
            <div class="col-sm-9">
                <h4 class="nomargin">{{ $cart->name }}</h4>
            </div>
        </div>
    </td>
    <td data-th="Price">${{ $cart->price }}</td>
    <td data-th="Seller_name">
        {{ $cart->user->name }}
    </td>
    <td class="actions" data-th="">
        <button class="btn btn-danger btn-sm remove-from-cart" data-id="{{ $cart->id }}"><i class="fa fa-trash-o"></i></button>
    </td>
</tr>
@endforeach
@endguest
    </tbody>
    <tfoot>
    <tr>
        <td><a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i>繼續購買</a></td>
        <td colspan="2" class="hidden-xs"></td>
        <td class="hidden-xs text-center"><strong>總計: ${{ $total }}</strong></td>
    </tr>
    </tfoot>
</table>

@endsection

@section('script')
    <script type="text/javascript">
        $(".remove-from-cart").click(function (e) {
            e.preventDefault();
            var ele = $(this);
            
            swal.fire({
                    title: '確定要將商品從購物車移除嗎?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: '確定!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ url('/remove-from-cart') }}',
                            method: "DELETE",
                            data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                            success: function (response) {
                                swal.fire(
                                    {
                                    title: '成功移除',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                    });   
                  }
                });

            // if(confirm("Are you sure")) {
            //     $.ajax({
            //         url: '{{ url('/remove-from-cart') }}',
            //         method: "DELETE",
            //         data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
            //         success: function (response) {
            //             window.location.reload();
            //         }
            //     });
            // }
        });
    </script>
@endsection
