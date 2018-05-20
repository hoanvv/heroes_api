@extends('back-end.layouts.app')
@section('content')
    <div class="title-block">
        <h3 class="title"> Invoice
            <a href="#" onclick="javascript:window.top.close();" style="font-size: 13px;color: red;">Close</a>
        </h3>
    </div>
    <section class="section">
        <div class="row sameheight-container">
            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 stats-col">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title"> Your Trip </h4>
                            <p class="title-description"> Time: {{$requestShip->created_at}}</p>
                        </div>
                        <div class="header-block pull-right">
                            <label class="search">
                                Status:
                            </label>
                            <div class="pagination">
                                @switch($status)
                                    @case(0)
                                    <span> Canceled</span>
                                    @break

                                    @case(1)
                                    <span> Waiting</span>
                                    @break

                                    @case(2)
                                    <span> Accepted</span>
                                    @break

                                    @case(3)
                                    <span> Delivering</span>
                                    @break

                                    @case(4)
                                    <span> Completed</span>
                                    @break
                                    @default
                                    <span></span>
                                @endswitch
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <div id="map" style="width:100%; height: 250px"></div>
                        <div style="border-bottom: 1px solid #ccc;margin-top: 20px;">
                            <p><b>Pick up: </b>{{$requestShip->pickup_location_address}}</p>
                            <p><b>Destination: </b>{{$requestShip->destination_address}}</p>
                        </div>
                        <div class="row" style="border-bottom: 1px solid #ccc;margin-top: 20px;">
                            <div class="col-sm-4">
                                <p>Distance</p>
                                <p><b>{{$requestShip->distance}} km</b></p>
                            </div>
                            <div class="col-sm-4">
                                <p>Duration</p>
                                <p><b>{{$requestShip->duration}} seconds</b></p>
                            </div>
                            <div class="col-sm-4">
                                <p>Package Type</p>
                                <p><b>{{$requestShip->packageType->name}}</b></p>
                            </div>
                        </div>
                        <div class="row" style="border-bottom: 1px solid #ccc;margin-top: 20px; margin-bottom:20px">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4"><i style="font-size: 5em" class="fa fa-user-circle-o" aria-hidden="true"></i></div>
                                    <div class="col-sm-8">
                                        <b>Package onwer</b>
                                        <p style="margin-bottom:0">{{$requestShip->user->first_name}} {{$requestShip->user->last_name}}</p>
                                        <p style="margin-bottom:10px">{{$requestShip->user->email}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-4"><i style="font-size: 5em" class="fa fa-user" aria-hidden="true"></i></div>
                                    <div class="col-sm-8">
                                        <b>Shipper</b>
                                        @if($shipper)
                                            <p style="margin-bottom:0">{{$shipper->first_name}} {{$shipper->last_name}}</p>
                                            <p style="margin-bottom:10px">{{$shipper->email}}</p>
                                        @else
                                            <p style="margin-bottom:10px">No one</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-12 col-md-6 col-xl-6 history-col">
                <div class="card sameheight-item">
                    <div class="card-header card-header-sm bordered">
                        <div class="header-block">
                            <h4 class="title">Fare Breakdown For Ride No :{{$requestShip->id}}</h4>
                        </div>
                    </div>
                    <div class="card-block">
                        <b>Total Fare: {{$requestShip->price}} VND</b>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function initMap() {
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var directionsService = new google.maps.DirectionsService;
            var pickUp = <?php echo $requestShip->pickup_location; ?>;
            var destination = <?php echo $requestShip->destination; ?>;
            console.log(destination);

            var mediumPointLat = (pickUp['latitude'] + destination['latitude']) / 2;
            var mediumPointLng = (pickUp['longitude'] + destination['longitude']) / 2;
            var mediumPoint = {lat: mediumPointLat, lng: mediumPointLng}
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: mediumPoint
            });
            directionsDisplay.setMap(map);

            calculateAndDisplayRoute(directionsService, directionsDisplay, pickUp, destination);
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay, pickUp, destination) {
            var selectedMode = 'DRIVING';
            directionsService.route({
                origin: {lat: pickUp['latitude'], lng: pickUp['longitude']},  // Haight.
                destination: {lat: destination['latitude'], lng: destination['longitude']},  // Ocean Beach.
                // Note that Javascript allows us to access the constant
                // using square brackets and a string value as its
                // "property."
                travelMode: google.maps.TravelMode[selectedMode]
            }, function(response, status) {
                if (status == 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBweUpkwe6WszENfuX4QC9ql-DLrB1Mj5c&callback=initMap">
    </script>
@endsection