@extends('layouts.app')

@section('content')
<div class="row">

@foreach ($users as $user)
    <div class="col-sm-3">
        <div class="card">
          <div class="card-body">
          <h4 class="card-title">{{ $user->name }}</h4>
          <form action="/chat" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="first_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="sec_id" value="{{ $user->id }}">
            <input type="hidden" name="first_email" value="{{ Auth::user()->email }}">
            <input type="hidden" name="sec_email" value="{{ $user->email }}">
        </form>
        <button type="submit" class="btn btn-primary">Connect</button>
          </div>
        </div>
    </div>
@endforeach

@if ($channel)
{{ $channel->sid }} <br> <br>
{{ $member1->sid }} <br> <br>
{{ $member2->sid }}
@endif


@endsection

@section('js')
<script src="https://media.twiliocdn.com/sdk/js/chat/v3.4/twilio-chat.min.js"></script>

<script>
Twilio.Chat.Client.create('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJTSzg5YTM3OGIzMjQwZWE4ODA1YjExMWQyMmVmMTEyNGQyLTE1OTIzMzEzNjUiLCJpc3MiOiJTSzg5YTM3OGIzMjQwZWE4ODA1YjExMWQyMmVmMTEyNGQyIiwic3ViIjoiQUMwMGM0NTRkYzgzOWM3N2Y5MWFiNWI3Yzc3YWI4YjdmNCIsImV4cCI6MTU5MjMzNDk2NSwiZ3JhbnRzIjp7ImlkZW50aXR5IjoiYXN0dHQiLCJjaGF0Ijp7InNlcnZpY2Vfc2lkIjoiSVNjNGUyMDJjZDI1N2E0YjdkYTI3ZWUzMDc0NzRjNGZkNyJ9fX0.3kHSrE4TMue4p9oT3HK9eQ9iUSD-otrpYiCWb6yU7Fc').then(client => {
    console.log(client)
});
</script>

@endsection
