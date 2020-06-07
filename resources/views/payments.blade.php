@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Заявки на вывод</h4>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12" style="border: 1px solid #eaeaea; border-radius: 5px; padding: 15px 25px;">
                                <div class="payment-item">
                                    <div class="status">
                                        <span class="badge badge-warning">Ожидает выплаты</span>
                                    </div>
                                    <div class="user-id mt-1">
                                        <h6>ID User: 693000234</h6>
                                        <p><b>BTC-Кошелёк:</b> 1EiB5dJiSob5C4WnKMv9gwjH9v7FqmRd4V</p>
                                        <p>Сумма на вывод: <b>0.00200000 BTC</b></p>
                                    </div>
                                    <div class="buttons_pay" style="display: flex;">
                                        <form action="#" class="mr-2">
                                            <button type="button" class="btn btn-success btn-xs mt-3">Одобрить заявку</button>
                                        </form>
                                        <form action="#">
                                            <button type="button" class="btn btn-danger btn-xs mt-3">Отклонить заявку</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
