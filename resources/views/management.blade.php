@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Управление ботом</h4>
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="captcha_question" class="col-form-label">Настройка Captcha для регистрации пользователей</label>
                                <input class="form-control" type="text" placeholder="5+6=" id="captcha_question" name="captcha_question">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="captcha_answer" class="col-form-label">Ответ на Captcha</label>
                                <input class="form-control" type="text" placeholder="11" id="captcha_answer" name="captcha_answer">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="welcome_message" class="col-form-label">Настройка приветственного сообщения для пользователей</label>
                                <textarea class="form-control" id="welcome_message" placeholder="Привет!" name="welcome_message" style="resize: none;" cols="30" rows="7"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_registration" class="col-form-label">Сумма выплаты при регистрации</label>
                                <input class="form-control" type="text" placeholder="0.00005000" id="payment_registration" name="payment_registration">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_out" class="col-form-label">Минимальная сумма выплаты</label>
                                <input class="form-control" type="text" placeholder="0.00400000" id="payment_out" name="payment_out">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_min" class="col-form-label">Значения для выплат (Min)</label>
                                <input class="form-control" type="text" placeholder="0.00000500" id="payment_min" name="payment_min">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_max" class="col-form-label">Значения для выплат (Max)</label>
                                <input class="form-control" type="text" placeholder="0.00001900" id="payment_max" name="payment_max">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_by_refer" class="col-form-label">Сумма сатоши за реферала</label>
                                <input class="form-control" type="text" placeholder="0.00000500" id="payment_by_refer" name="payment_by_refer">
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="payment_by_refer_percent" class="col-form-label">Процент выплаты с каждого реферала, %</label>
                                <input class="form-control" type="text" placeholder="10" id="payment_by_refer_percent" name="payment_by_refer_percent">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2 pr-4 pl-4" style="width: 100%;">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
