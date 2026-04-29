@extends('admin/adminlayout')

@section('container')





<div class="row ">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Reservation Details</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                          
           
                            <th> Date </th>
                            <th> Time </th>
                            <th> Name </th>
                            <th> Email </th>
                            <th> Phone</th>
                        
                            <th> No of Guests </th>
              
                  
                            
                            <th> Message </th>
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody>

                        @foreach($reservations as $reservation)
                          <tr>
                           
                            <td>
                              <span class="ps-2">{{ $reservation->date }}</span>
                            </td>
                            <td> {{ $reservation->time }} </td>
                            <td> {{ $reservation->name }} </td>
                            <td>


                            {{ $reservation->email }}


                            </td>


                            <td>  {{  $reservation->phone }}</td>
                            <td> {{ $reservation->no_guest }} </td>
                     
                 

                            <td>

                            {{ $reservation->message }}

                              </td>
                            <td>
                                <form action="{{ route('admin.reservation.delete', $reservation->id) }}" method="POST" style="display:inline-block;">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="badge badge-outline-danger" style="background:none; border:1px solid #fc424a; cursor:pointer;" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</button>
                                </form>
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