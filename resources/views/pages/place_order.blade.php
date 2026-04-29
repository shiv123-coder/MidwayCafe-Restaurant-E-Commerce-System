<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="SSLCommerz">
    <title>MidwayCafe</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body class="bg-light">
<div class="container">
    <div class="py-5 text-center">
        <h2>MidwayCafe</h2>

      
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
            </h4>
            <ul class="list-group mb-3">
               
                <li class="list-group-item d-flex justify-content-between">
                    <span>Total (INR)</span>
                    <strong>{{ $total }}</strong>
                </li>
            </ul>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Shipping address</h4>
            <form method="POST" action="{{url('confirm_place_order/'.$total)}}" class="needs-validation" novalidate>
               
            @csrf

                <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St"
                           value="93 B, New Eskaton Road" required>
                    <div class="invalid-feedback">
                        Please enter your shipping address.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="state">State *</label>
                        <select class="custom-select d-block w-100" name="state" id="state" required>
                            <option value="">Choose...</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Assam">Assam</option>
                            <option value="Delhi">Delhi</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid state.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="city">City *</label>
                        <select class="custom-select d-block w-100" name="city" id="city" required disabled>
                            <option value="">Choose state first...</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid city.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="zip">Zip *</label>
                        <input type="text" class="form-control" name="zip" id="zip" placeholder="" required>
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const stateSelect = document.getElementById('state');
                        const citySelect = document.getElementById('city');

                        const cityMapping = {
                            "Maharashtra": ["Mumbai", "Pune", "Nagpur", "Nashik", "Aurangabad"],
                            "Karnataka": ["Bengaluru", "Mysuru", "Mangalore", "Hubli"],
                            "Gujarat": ["Ahmedabad", "Surat", "Vadodara", "Rajkot"],
                            "Tamil Nadu": ["Chennai", "Coimbatore", "Madurai"],
                            "Uttar Pradesh": ["Lucknow", "Kanpur", "Varanasi", "Noida"],
                            "Kerala": ["Kochi", "Thiruvananthapuram", "Kozhikode"],
                            "Madhya Pradesh": ["Indore", "Bhopal", "Jabalpur", "Gwalior"],
                            "Rajasthan": ["Jaipur", "Jodhpur", "Udaipur", "Kota"],
                            "West Bengal": ["Kolkata", "Howrah", "Durgapur", "Siliguri"],
                            "Telangana": ["Hyderabad", "Warangal", "Nizamabad"],
                            "Punjab": ["Ludhiana", "Amritsar", "Jalandhar"],
                            "Haryana": ["Gurugram", "Faridabad", "Panipat"],
                            "Bihar": ["Patna", "Gaya", "Bhagalpur"],
                            "Odisha": ["Bhubaneswar", "Cuttack", "Rourkela"],
                            "Assam": ["Guwahati", "Dibrugarh", "Silchar"],
                            "Delhi": ["New Delhi", "North Delhi", "South Delhi"]
                        };

                        stateSelect.addEventListener('change', function() {
                            const selectedState = this.value;
                            
                            // Clear and disable city select if no state is selected
                            if (!selectedState) {
                                citySelect.innerHTML = '<option value="">Choose state first...</option>';
                                citySelect.disabled = true;
                                return;
                            }

                            // Enable city select and populate with relevant cities
                            citySelect.disabled = false;
                            citySelect.innerHTML = '<option value="">Choose city...</option>';
                            
                            const cities = cityMapping[selectedState] || [];
                            cities.forEach(city => {
                                const option = document.createElement('option');
                                option.value = city;
                                option.textContent = city;
                                citySelect.appendChild(option);
                            });
                        });
                    });
                </script>
                <hr class="mb-4">
              
                <hr class="mb-4">
                <button class="btn btn-primary" 
                     
                        endpoint="{{ url('/confirm_place_order') }}"> Confirm order
                </button>
            </form>
        </div>
    </div>

   
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>


<!-- If you want to use the popup integration, -->
<script>
    var obj = {};
    obj.cus_name = $('#customer_name').val();
    obj.cus_phone = $('#mobile').val();
    obj.cus_email = $('#email').val();
    obj.cus_addr1 = $('#address').val();
    obj.amount = $('#total_amount').val();

    $('#sslczPayBtn').prop('postdata', obj);

    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);

    // Bootstrap validation script
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
</script>
</html>
