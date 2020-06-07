@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Webhook settings</h4>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <strong>Успех!</strong> {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <strong>Успех!</strong> {{ session('error') }}
                    </div>
                @endif
                <form action="{{route('saveServerSetting')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="server_api" class="col-form-label">Domain API</label>
                        <input class="form-control" type="text" placeholder="https://localhost" id="server_api" name="server_api" @if(isset($server_api[0]->setting_value)) value="{{$server_api[0]->setting_value}}" @endif >
                        <small class="form-text text-muted">Enter the url of your server to install Webhook.</small>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success mb-4 pr-4 pl-4">Save</button>
                </form>
                <small class="form-text text-muted">This setting affects the connection status of the bot API and the telegram server.</small>
                <div class="webhook-forms" style="display: flex;">
                    <form method="POST" action="{{route('setWebhook')}}" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary mt-3 mr-3 pr-4 pl-4">Set Webhook</button>
                    </form>
                    <form method="POST" action="{{route('removeWebhook')}}" enctype="multipart/form-data">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger mt-3 pr-4 pl-4">Remove Webhook</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
