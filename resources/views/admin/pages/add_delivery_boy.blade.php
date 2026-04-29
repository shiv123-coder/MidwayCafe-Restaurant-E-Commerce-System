@extends('admin/adminlayout')

@section('container')


<div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Add Delivery Boy</h4>
                    <br>

                    @if(Session::has('wrong'))
                        <div class="alert">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Oops!</strong> {{Session::get('wrong')}}
                        </div><br>
                    @endif
                    @if(Session::has('success'))
                        <div class="success">
                            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <strong>Success!</strong> {{Session::get('success')}}
                        </div>
                        <br>
                        @endif

                    <form class="forms-sample" action="{{ route('admin.add-delivery-boy-process') }}" method="post" enctype="multipart/form-data">

                       @csrf

                      <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputName1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email</label>
                        <input type="text" name="email" class="form-control" id="exampleInputName1">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Phone</label>
                        <input type="number" name="phone" class="form-control" id="exampleInputName1">
                      </div>

            


                      <div class="form-group">
                        <label for="exampleInputName1">Salary</label>
                        <input type="number" name="salary" class="form-control" id="exampleInputName1">
                      </div>


                      <div class="form-group">
                        <label for="dboy-password">Password</label>
                        <div class="pwd-wrap">
                            <input type="password" name="password" class="form-control" id="dboy-password">
                            <button type="button" class="pwd-eye-btn" onclick="toggleAdminPwd('dboy-password')" aria-label="Toggle password">
                                <svg id="eye-o-dboy-password" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eye-c-dboy-password" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/></svg>
                            </button>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="dboy-confirm">Confirm Password</label>
                        <div class="pwd-wrap">
                            <input type="password" name="confirm_password" class="form-control" id="dboy-confirm">
                            <button type="button" class="pwd-eye-btn" onclick="toggleAdminPwd('dboy-confirm')" aria-label="Toggle confirm password">
                                <svg id="eye-o-dboy-confirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg id="eye-c-dboy-confirm" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M3 3l18 18"/></svg>
                            </button>
                        </div>
                      </div>

                  
                      <div class="form-group">
                        <label for="exampleFormControlFile1">Image</label>
                        <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1">
                      </div>
                  
                    
                      <button type="submit" class="btn btn-primary me-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>

            </div>



@endsection()




<style>
.alert { padding:16px 20px; background-color:#ef4444; color:white; border-radius:8px; margin-bottom:12px; }
.success { padding:16px 20px; background-color:#22c55e; color:white; border-radius:8px; margin-bottom:12px; }
.closebtn { margin-left:15px; color:white; font-weight:bold; float:right; font-size:22px; line-height:20px; cursor:pointer; transition:0.3s; }
.closebtn:hover { color:#111; }
.pwd-wrap { position:relative; }
.pwd-wrap .form-control { padding-right: 42px; }
.pwd-eye-btn { position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#94a3b8; padding:0; display:flex; align-items:center; }
.pwd-eye-btn:hover { color:#a855f7; }
</style>
<script>
function toggleAdminPwd(id) {
    var el = document.getElementById(id);
    var isPwd = el.type === 'password';
    el.type = isPwd ? 'text' : 'password';
    document.getElementById('eye-o-' + id).style.display = isPwd ? 'none' : 'inline';
    document.getElementById('eye-c-' + id).style.display = isPwd ? 'inline' : 'none';
}
</script>