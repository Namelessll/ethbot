@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Пользовательские вопросы</h4>

                   <div class="container-fluid">
                       <div class="row">
                           <div class="col-md-12 mb-2" style="padding: 20px 10px; border: 1px solid #f1f1f1; border-radius: 5px;">
                               <ul class="nav nav-tabs" id="myTab1" role="tablist">
                                   <li class="nav-item">
                                       <a class="nav-link active show" id="home-tab1" data-toggle="tab" href="#home1" role="tab" aria-controls="home" aria-selected="false">Вопрос</a>
                                   </li>
                                   <li class="nav-item">
                                       <a class="nav-link" id="profile-tab1" data-toggle="tab" href="#profile1" role="tab" aria-controls="profile" aria-selected="true">Форма для ответа</a>
                                   </li>
                               </ul>
                               <div class="tab-content mt-3" id="myTabContent">
                                   <div class="tab-pane fade active show" id="home1" role="tabpanel" aria-labelledby="home-tab">
                                       <h6>ID пользователя: 315779386</h6>
                                       <small style="color: #9c9c9c;">2 минуты 41 секунда назад</small>
                                       <p style="margin-top: 10px;">
                                           <mark style="padding: 10px; border-left: 4px solid #a694e8; background-color: #f9f7eb;"><em>Чего бот завис?</em></mark>
                                       </p>
                                   </div>
                                   <div class="tab-pane fade" id="profile1" role="tabpanel" aria-labelledby="profile-tab">
                                       <form action="#" method="POST" enctype="multipart/form-data">
                                           @csrf
                                           <div class="form-group" style="margin: 0;">
                                               <label for="answer_for_user" class="col-form-label">Ответ на вопрос пользователя ID: 315779386</label>
                                               <textarea class="form-control" id="answer_for_user" placeholder="Привет!" name="answer_for_user" style="resize: none;" cols="15" rows="4"></textarea>
                                           </div>
                                           <button type="submit" class="btn btn-success mt-2 pr-4 pl-4" style="width: 100%;">Отправить</button>
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
