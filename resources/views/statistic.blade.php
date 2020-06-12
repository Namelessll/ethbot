@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Статистика бота</h4>
                    <p>Кол-во зарегистрированных: <strong>{{count($users)}} чел.</strong></p>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя пользователя</th>
                                    <th scope="col">Кол-во рефералов</th>
                                    <th scope="col">XXX coin</th>
                                    <th scope="col">ETH</th>
                                    <th scope="col">Дата регистрации</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="row">{{$user->user_id}}</th>
                                        <td>{{$user->username}}</td>
                                        <td>{{$user->referals}}</td>
                                        <td>{{$user->balanceToken}}</td>
                                        <td>{{$user->balanceEth}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>@if($user->ban == 1)Заблокирован @else Активен @endif</td>
                                        <td>
                                            @if($user->ban == 0)
                                                <form action="{{route('banStatusUser')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="ti-trash"></i> Заблокировать</button>
                                                </form>
                                            @else
                                                <form action="{{route('unBanStatusUser')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                                                    <button type="submit" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Разблокировать</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                                {{$users->links()}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
