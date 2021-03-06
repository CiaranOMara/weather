@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row" v-if="messages.length">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Messages</div>

                    <div class="panel-body">
                        <li v-for="message in messages">
                            @{{ message }}
                        </li>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Humidity<small v-if="latestHumidity">: @{{ latestHumidity }}</small></div>

                    <div class="panel-body">
                        <chart ref="humidity" :data="humidity"></chart>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Temperature<small v-if="latestTemperature">: @{{ latestTemperature }}</small></div>

                    <div class="panel-body">
                        <chart ref="temperature" :data="temperature"></chart>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


