@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Управление ботом</h4>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <strong>Успех!</strong> {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{route('saveBotSetting')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="token_course" class="col-form-label">Курс токена, $</label>
                                <input class="form-control" type="text" placeholder="2" id="token_course" name="token_course" required @if(isset($bot_settings[0]->token_course)) value="{{$bot_settings[0]->token_course}}" @endif>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="channel_link" class="col-form-label">Ссылка на канал</label>
                                <input class="form-control" type="text" placeholder="https://123.com" id="channel_link" name="channel_link" required @if(isset($bot_settings[0]->channel_link)) value="{{$bot_settings[0]->channel_link}}" @endif>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="channel_id" class="col-form-label">ID чата или супер-группы</label>
                                <input class="form-control" type="text" placeholder="345246758562" id="channel_id" name="channel_id" required @if(isset($bot_settings[0]->channel_id)) value="{{$bot_settings[0]->channel_id}}" @endif>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="welcome_message" class="col-form-label">Настройка приветственного сообщения для пользователей</label>
                                <textarea class="form-control" id="welcome_message" placeholder="Привет!" name="welcome_message" style="resize: none;" cols="30" rows="7" required >@if(isset($bot_settings[0]->welcome_message)){{$bot_settings[0]->welcome_message}}@endif</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="ask_question_message" class="col-form-label">Настройка сообщения для кнопки "❓ Задать вопрос"</label>
                                <textarea class="form-control" id="ask_question_message" placeholder="По поводу вопросов обратитесь к @manager" name="ask_question_message" style="resize: none;" cols="30" rows="7" required >@if(isset($bot_settings[0]->ask_question_message)){{$bot_settings[0]->ask_question_message}}@endif</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="question_answers" class="col-form-label">Настройка сообщения для кнопки "💬 Вопрос/Ответ"</label>
                                <textarea class="form-control" id="question_answers" placeholder="Вопрос -> Ответ" name="question_answers" style="resize: none;" cols="30" rows="7" required >@if(isset($bot_settings[0]->question_answers)){{$bot_settings[0]->question_answers}}@endif</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_registration" class="col-form-label">Сумма выплаты при регистрации</label>
                                <input class="form-control" type="text" placeholder="0.00005000" id="payment_registration" name="payment_registration" required @if(isset($bot_settings[0]->payment_registration)) value="{{number_format($bot_settings[0]->payment_registration, 8, ".", "")}}" @endif>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_out" class="col-form-label">Минимальная сумма выплаты</label>
                                <input class="form-control" type="text" placeholder="0.00400000" id="payment_out" name="payment_out" required @if(isset($bot_settings[0]->payment_out)) value="{{number_format($bot_settings[0]->payment_out, 8, ".", "")}}" @endif>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_min" class="col-form-label">Значения для выплат (Min)</label>
                                <input class="form-control" type="text" placeholder="0.00000500" id="payment_min" name="payment_min" required @if(isset($bot_settings[0]->payment_min)) value="{{number_format($bot_settings[0]->payment_min, 8, ".", "")}}" @endif>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_max" class="col-form-label">Значения для выплат (Max)</label>
                                <input class="form-control" type="text" placeholder="0.00001900" id="payment_max" name="payment_max" required @if(isset($bot_settings[0]->payment_max)) value="{{number_format($bot_settings[0]->payment_max, 8, ".", "")}}" @endif>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="payment_by_refer" class="col-form-label">Сумма XXX coin за реферала</label>
                                <input class="form-control" type="text" placeholder="0.00000500" id="payment_by_refer" name="payment_by_refer" required @if(isset($bot_settings[0]->payment_by_refer)) value="{{number_format($bot_settings[0]->payment_by_refer, 8, ".", "")}}" @endif>
                            </div>
                            <div class="col-md-12 mb-1">
                                <label for="payment_by_refer_percent" class="col-form-label">Процент выплаты с каждого реферала, %</label>
                                <input class="form-control" type="text" placeholder="10" id="payment_by_refer_percent" name="payment_by_refer_percent" required @if(isset($bot_settings[0]->payment_by_refer_percent)) value="{{number_format($bot_settings[0]->payment_by_refer_percent, 8, ".", "")}}" @endif>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success mt-2 pr-4 pl-4" style="width: 100%;">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
