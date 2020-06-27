@extends('layout')
@section('content')
    <div class="col-md-12 mb-20 clearfix">
        <div class="col-md-6 float-left">
            <span>Temperature for</span>
            <h4>{{ $location }}</h4>
        </div>
        <div class="col-md-6 float-left">
            <h1>{{ $temperature }}<sup>°C</sup></h1>
        </div>
    </div>
    <div class="history mt-5">
        <p>Previous records</p>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Temperature <sup>(°C)</sup></th>
                <th scope="col">Time</th>
              </tr>
            </thead>
            <tbody>
            @forelse ($previousTemperatures as $data)
                <tr>
                    <th scope="row">{{ $data->temperature }}<sup>°C</sup></th>
                    <td>{{ $data->created_at->format('F j, Y H:i') }}</td>
                </tr>
            @empty
            <tr>
                <th scope="row">-</th>
                <td>-</td>
            </tr>
            @endforelse
            </tbody>
          </table>
        <a class="btn btn-primary" href="{{ route('index') }}" role="button">Back</a>
    </div>
@endsection
