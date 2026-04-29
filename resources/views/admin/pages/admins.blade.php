@extends('admin/adminlayout')

@section('container')


<a href="{{ route('admin.admin.add') }}" type="button" class="btn btn-primary">+ Add Admin</a>


<br>
<br>


<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Admin Details</h4>

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
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> ID </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone</th>
                          

                            <th>Type</th>
                            <th>Salary</th>
                        


                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($admins as $admin)
                          <tr>
                           
                            <td>
                              <span>{{ $admin->id }}</span>
                            </td>
                            <td> {{ $admin->name }} </td>



                            
                         
                         




                            <td> {{ $admin->email }}</td>


                            <td> {{ $admin->phone }} </td>


                            <td>


                            @if($admin->usertype=="1")


                                  Super Admin

                            @endif                     
                            @if($admin->usertype=="3")


                                  Sub Admin

                            @endif



                            </td>


                            
                     <td>{{ $admin->salary }} INR</td>


                            <td>

                            <a href="{{ route('admin.admin.edit', $admin->id) }}" class="badge badge-outline-primary">Edit</a>
                              <a href="{{ route('admin.admin.delete', $admin->id) }}" class="badge badge-outline-danger" style="margin-left:10px;">Delete</a>
                            </td>
                          </tr>

                        @endforeach
                       
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>





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