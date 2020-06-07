@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-6 mt-3">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Webhook settings</h4>
                <div class="alert alert-success" role="alert">
                    <strong>Well done!</strong> You successfully read this important alert message.
                </div>
                <form>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label">Domain API</label>
                        <input class="form-control" type="text" placeholder="https://localhost" id="example-text-input">
                        <small class="form-text text-muted">Enter the url of your server to install Webhook.</small>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success mb-4 pr-4 pl-4">Save</button>
                </form>
                <small class="form-text text-muted">This setting affects the connection status of the bot API and the telegram server.</small>
                <div class="webhook-forms" style="display: flex;">
                    <form>
                        <button type="submit" class="btn btn-sm btn-primary mt-3 mr-3 pr-4 pl-4">Set Webhook</button>
                    </form>
                    <form>
                        <button type="submit" class="btn btn-sm btn-danger mt-3 pr-4 pl-4">Remove Webhook</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
