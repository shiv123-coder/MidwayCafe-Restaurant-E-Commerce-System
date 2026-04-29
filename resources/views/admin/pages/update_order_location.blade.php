@extends('admin/adminlayout')

@section('container')

<br>

@if(Session::has('wrong'))

    <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Opps !</strong> {{Session::get('wrong')}}
</div>
<br>
    @endif
    @if(Session::has('success'))

    <div class="success">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
  <strong>Congrats !</strong> {{Session::get('success')}}
</div>
    <br>
    @endif


<div class="card">
  <h5 class="card-header">Customer Details</h5>
  <div class="card-body">
    <h5 class="card-text">Invoice No : {{  $order->invoice_no }}</h5>
    <br>
    <p class="card-text">Customer Name : {{ $order->user->name ?? 'N/A' }}</p>
    <p class="card-text">Customer Phone : {{ $order->user->phone ?? 'N/A' }}</p>
    <p class="card-text">Customer Email : {{ $order->user->email ?? 'N/A' }}</p>
    <p class="card-text">Shipping Address : {{ $order->shipping_address }}</p>
    <a href="/customer" class="btn btn-primary"><b>Details</a>
  </div>
</div>

<br>

<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Product Details</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Product Name </th>
                            <th> Price </th>
                            <th> Quantity </th>
                            <th> Subtotal </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($products as $product)
                          <tr>
                            <td> {{ $product->product->name ?? 'Product Deleted' }} </td>
                            <td> {{ $product->price }} </td>
                            <td> {{ $product->quantity }} </td>
                            <td> {{ $product->subtotal }}</td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

              @if($order->status == "Processed")
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Update Order Location</h4>
                    <form class="forms-sample" action="{{ asset('/invoice/approve/'.$order->invoice_no) }}" method="post" enctype="multipart/form-data">
                       @csrf
                       <div class="form-group">
                        <label for="exampleInputName1">Previous Delivery Time</label>
                        <input type="text" style="background-color:black !important;" name="" value="{{ $order->delivery_time }}" class="form-control" id="exampleInputName1" readonly>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Delivery Time (Now)</label>
                        <input type="datetime-local" name="time" value="{{ date('Y-m-d\TH:i') }}" class="form-control" id="exampleInputName1">
                      </div>
                      <button type="submit" class="btn btn-primary me-2">Update Order</button>
                      <a href="{{ asset('/invoice/cancel-order/'.$order->invoice_no) }}" class="btn btn-danger">Cancel Order</a>
                    </form>
                  </div>
                </div>
              </div>
              @endif


         




@endsection()



<style>
.alert {
  padding: 20px;
  background-color: #f44336;
  color: white;
}

.success {
  padding: 20px;
  background-color: #4BB543 ;
  color: white;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>