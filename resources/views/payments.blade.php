@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Заявки на вывод</h4>

                    <div class="container-fluid">
                        <div class="row">
                            @foreach($payments as $payment)
                                <div class="col-md-12" style="border: 1px solid #eaeaea; border-radius: 5px; padding: 15px 25px;">
                                    <div class="payment-item">
                                        <div class="status">
                                            @if($payment->status == 0)
                                                <span class="badge badge-warning">Ожидает выплаты</span>
                                            @elseif($payment->status == 1)
                                                <span class="badge badge-success">Одобрено</span>
                                            @else
                                                <span class="badge badge-danger">Отклонено</span>
                                            @endif
                                        </div>
                                        <div class="user-id mt-1">
                                            <h6>ID User: {{$payment->user_id}}</h6>
                                            <p><b>BTC-Кошелёк:</b> {{$payment->valet}}</p>
                                            <p>Сумма на вывод: <b>{{$payment->value}} ETH</b></p>
                                            <p>Дата: <b>{{$payment->created_at}}</b></p>

                                        </div>
                                        @if($payment->status == 0)
                                            <div class="buttons_pay" style="display: flex;">
                                                <form action="{{route('transactionAccept')}}"  method="POST" enctype="multipart/form-data" class="mr-2">
                                                    @csrf
                                                    <input type="hidden" name="transaction_id" value="{{$payment->id}}">
                                                    <input type="hidden" name="user_id" value="{{$payment->user_id}}">
                                                    <button type="submit" class="btn btn-success btn-xs mt-3">Одобрить заявку</button>
                                                </form>
                                                <form action="{{route('transactionDecline')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="transaction_id" value="{{$payment->id}}">
                                                    <input type="hidden" name="user_id" value="{{$payment->user_id}}">
                                                    <button type="submit" class="btn btn-danger btn-xs mt-3">Отклонить заявку</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
