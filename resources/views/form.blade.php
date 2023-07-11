<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booking System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Customer Form') }}</div>
    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                        @endif
    
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        <form action="{{ route('store.booking') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name:</label>
                                    <input type="text" id="name" name="name" required class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label for="email"   class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required><br>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone:</label>
                                    <input type="text" id="phone"  class="form-control" name="phone" required><br>
                                </div>

                                <div class="col-md-6">
                                    <label for="vehicle">Vehicle:</label>
                                    <select id="vehicle" name="vehicle" class="form-select">
                                        <option value="" selected>Select Vehicle</option>
                                       @foreach ($vehilces as $vehicle )
                                        <option value="{{ $vehicle->name }}" >{{ $vehicle->name }}</option>
                                       @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="booking-type" class="form-label">Booking Type:</label><br>
                                    <div style="display: flex;gap:10px">
                                        <div>
                                            <input type="radio" id="full-day" class="form-check-input" name="booking_type" value="full-day" required>
                                            <label for="full-day">Full Day</label><br>
                                        </div>
                                        <div>
                                            <input type="radio" id="half-day" class="form-check-input" name="booking_type" value="half-day">
                                            <label for="half-day">Half Day</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="booking-date">Booking Date:</label>
                                    <input type="date" id="booking-date" name="booking_date" value="{{ date('Y-m-d') }}" readonly class="form-control">
                                </div>
                                <div class="col-md-6 mt-3"  id="booking-shift-wrapper" style="display: none;">
                                    <label for="booking-shift"  class="form-label">Booking Shift:</label><br>
                                    <div style="display: flex;gap:10px">
                                        <div>
                                            <input type="radio" id="morning" name="booking_shift" class="form-check-input" value="morning">
                                            <label for="morning">Morning</label>
                                        </div>
                                        <div>
                                            <input type="radio" id="evening" name="booking_shift" class="form-check-input" value="evening">
                                            <label for="evening">Evening</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <button type="submit" class="btn btn-primary">Book Vehicle</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('input[name="booking_type"]').change(function () {
            var bookingType = $(this).val();
            if (bookingType === 'half-day') {
                $('#booking-shift-wrapper').show();
            } else {
                $('#booking-shift-wrapper').hide();
            }
        });
    });
</script>
</body>
</html>