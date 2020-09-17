<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sykes Task</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/custom.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
    <script src="{{ URL::asset('js/search.js') }}"></script>
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }
        .content {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container pt-5">
    <div class="content d-flex flex-mobile">
        <div class="ui card ml-2 pt-1 pb-1">
            <form id="search-form" class="m-2">
                <div class="form-group">
                    <label for="location">Location:</label>
                    <select name="location" id="location" required>
                        <option selected="true" disabled="disabled">Please select a location</option>
                        @foreach($locations as $location)
                            <option value="{{$location->__pk}}">{{$location->location_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="inline-field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" tabindex="0" class="hidden" id="near-beach" name="near-beach">
                        <label>Near Beach?</label>
                    </div>
                </div>
                <div class="inline-field">
                    <div class="ui toggle checkbox">
                        <input type="checkbox" tabindex="0" class="hidden" id="pets-allowed" name="pets-allowed">
                        <label>Pets Allowed</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="start-date">Start date</label>
                    <input type="date" id="start-date" name="trip-start"
                           min="2018-01-01" max="2022-12-31" required>
                </div>
                <div class="d-flex justify-content-between flex-row">
                    <div class="form-group">
                        <label for="nights">How many nights?</label>
                        <select name="nights" id="nights" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sleeps">Amount of guests</label>
                        <select id="sleeps" name="sleeps" required>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7+</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="beds">No# Beds</label>
                        <select id="beds" name="beds" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6+</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="_token" value="{{ csrf_token() }}" name="_token"/>
                <input type="submit" value="Submit" />
            </form>
        </div>
        <div class="container">
            <div class="row results-feedback mb-2">

            </div>
            <div class="ui link cards">

            </div>
        </div>
    </div>
</div>
<script>
    $('.ui.checkbox').checkbox();
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd
    }
    if(mm<10){
        mm='0'+mm
    }

    $('#start-date').attr('min', today);
</script>
</body>
</html>
