@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Статистика бота</h4>
                    <p>Кол-во зарегистрированных: <strong>63441 чел.</strong></p>
                    <div class="single-table">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead class="text-uppercase">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя пользователя</th>
                                    <th scope="col">Кол-во рефералов</th>
                                    <th scope="col">Сумма на балансе</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>18</td>
                                    <td>$120</td>
                                    <td>Активен</td>
                                    <td><button type="button" class="btn btn-danger btn-xs"><i class="ti-trash"></i> Заблокировать</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>18</td>
                                    <td>$120</td>
                                    <td>Заблокирован</td>
                                    <td><button type="button" class="btn btn-success btn-xs"><i class="fa fa-check"></i> Разблокировать</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
